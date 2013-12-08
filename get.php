<?php
date_default_timezone_set('Europe/Moscow');
ini_set('memory_limit', '256M');

include "config.php";
include "db.php";
include "php-soundcloud-master/Services/Soundcloud.php";


class scsync
{

    public  $save_path = '/store/';
    public  $save_local = true;

    const db_links = DB_LINK;
    const db_auth = DB_AUTH;

    public $db;
    public $already_downloaded = array();

    public $sc; // API object

    public $count=50;

    public function setSavePath($local,$path){
        $this->save_local = $local;
        $this->save_path  = $path;
    }

    public function setCount($count){
        $this->count = $count;
    }

    public function processStream($stream)
    {
        $i = 0;
        $j = 0;
        $count = min( $this->count, count($stream->collection) );
        foreach ($stream->collection as $item) {
            if($i >= $count) continue;
            if($this->trackDownload($item->origin)) $j++;
            $i++;
            echo ($i) . '(' . ($j) . ') / ' . $count . ' records processed. ' . ceil(($i) * 100 / $count) . '%' . PHP_EOL;
        }
    }

    public function processTracksArray($stream){
        $i = 0;
        $j = 0;
        $count = min( $this->count, count($stream) );
        foreach ($stream as $track) {
            if($i >= $count) continue;
            if($this->trackDownload($track)) $j++;
            $i++;
            echo ($i) . '(' . ($j) . ') / ' . $count . ' records processed. ' . ceil(($i) * 100 / $count) . '%' . PHP_EOL;
        }

    }

    public function trackDownload($track)
    {
        if($track->kind != 'track') return false;

        if (in_array($track->id, $this->already_downloaded)) {
            echo 'Track already downloaded. Continue...'.PHP_EOL;
            return false;
        }

        $downloaded_file = null;
        try {
            $downloaded_file = $this->sc->download($track->id);
            $low = false;
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            echo($e->getMessage());
            echo PHP_EOL . 'Trying to download Stream Version' . PHP_EOL;
            $downloaded_file = file_get_contents($track->stream_url . '?client_id=' . CLIENT_ID);
            $low = true;
        }

        if ($this->save_local == true) {
            $path = dirname(__FILE__) . $this->save_path;
            if (!file_exists($path)) mkdir($path);
        } else {
            $path = $this->save_path;
        }

        if (!is_null($downloaded_file)) {

            $new_name = '';
            if ($track->created_at != null) {
                $new_name .= date('Y-m-d', strtotime($track->created_at));
            }
            $new_name .= '-';
            $new_name .= str_replace(' ', '_', $track->user->username);
            $new_name .= '-';
            $new_name .= str_replace(' ', '_', $track->title);
            if ($low) {
                $new_name .= '-';
                $new_name .= '128';
            }
            $new_name .= '.mp3';


            $download = file_put_contents($path . $new_name, $downloaded_file);

            if ($download) {
                echo 'Track "' . $track->title . '" Successfully downloaded as "' . $new_name . '"!' . PHP_EOL;
                $this->addLink($track->id);
            }
        } else {
            echo 'Unable to download "' . $track->title . '" ' . PHP_EOL;
        }

    }

    public function addLink($link)
    {
        $db = new db(self::db_links);
        $db->addLink($link);
    }

    public function getLinksArray()
    {
        $db = new db(self::db_links);
        return $db->getLinksArray();
    }

    public function getAuth()
    {
        $db = new db(self::db_auth);
        return unserialize($db->getAuth());

    }

    public function __construct()
    {
        $auth = $this->getAuth();

        // create client object and set access token
        $this->sc = new Services_Soundcloud(CLIENT_ID, CLIENT_SECRET, REDIRECT_URL);

        $expired = true; // сейчас по умолчанию сессия всегда считается устаревшей и обновляется

        if ($auth['expires_in'] > time()) { // сессия еще валидна
            echo 'Use saved session' . PHP_EOL;
            $this->sc->setAccessToken($auth['access_token']);
        } else {
            // обновляем сессию
            echo 'Refresh session' . PHP_EOL;
            $token = $this->sc->accessTokenRefresh($auth['refresh_token']);
            $token['expires_in'] += time();
            $db = new db(self::db_auth);
            $db->saveAuth(serialize($token));
        }

        $this->already_downloaded = $this->getLinksArray();


    }


    public function ownStream(){
        try {
            $stream = json_decode($this->sc->get('me/activities/tracks/affiliated'));
            $this->processStream($stream);
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            echo 'Unknown error with message ' . $e->getMessage() . PHP_EOL;
        }

    }


    public function resolve($url){
        return  json_decode($this->sc->get('resolve', array('url' => $url),array(CURLOPT_FOLLOWLOCATION => true)));
    }

    public function getUserTracks($id){
        try {
            echo '/users/'.$id.'/tracks';
            $stream = json_decode($this->sc->get('users/'.$id.'/tracks'));
            $this->processTracksArray($stream);
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            //exit($e->getMessage());
            echo 'Unknown error with message ' . $e->getMessage() . PHP_EOL;
        }

    }

    public function getGroupTracks($id){
        try {
            echo '/groups/'.$id.'/tracks';
            $stream = json_decode($this->sc->get('groups/'.$id.'/tracks'));
            print_r($stream);
            $this->processTracksArray($stream);
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            //exit($e->getMessage());
            echo 'Unknown error with message ' . $e->getMessage() . PHP_EOL;
        }

    }

}


$app = new scsync();
if(isset($argv[1])){
    $app->setSavePath(false,$argv[1]);
}

if(isset($argv[3])){
    $app->setCount($argv[3]);
}

if(isset($argv[2])){
    if($argv[2]=='STREAM'){
        $app->ownStream();
    }else{
        $resolve = $app->resolve($argv[2]);
        $id = $resolve->id;
        switch($resolve->kind){
            case 'track':
            // download Track
                //echo 'Trying to download track: '.$id;
            $app->trackDownload($resolve);
            break;
            case 'user':
            // download User stream
            $app->getUserTracks($id);
                break;

            case 'playlist':
                $app->processTracksArray($resolve->tracks);
                break;

            case 'group':
                $app->getGroupTracks($id);
                break;

            default:
                echo 'Unknown kind: '.$resolve->kind.', id: '.$id.PHP_EOL;
                //print_r($resolve);
        }
    }

}


//print_r($argv);

//die('DIE');

/*
/me/activities gives you user's recent activities
/me/activities/all is the same as the one above (Recent activities) /me/activities/tracks/affiliated is the recent tracks from users the logged-in user follows (the stream)
/me/activities/tracks/exclusive is recent exclusively shared tracks
/me/activities/all/own is recent activities on the logged-in users tracks
 */

?>


