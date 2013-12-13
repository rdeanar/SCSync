<?php
/**
 *  get.php path_to_save
 *
 */

date_default_timezone_set('Europe/Moscow');
ini_set('memory_limit', '256M');

include "config.php";
include "db.php";
include "php-soundcloud-master/Services/Soundcloud.php";


class scsync
{

    public $save_path = '/store/';
    public $save_local = true;

    const db_links = DB_LINK;
    const db_auth = DB_AUTH;

    public $db;
    public $already_downloaded = array();

    public $sc; // API object

    public $count = 50;

    public static $current_download_operation = 'downloading content';

    public $stat = array(0,0,0);

    static function log($msg, $replace = false)
    {
        if ($replace) {
            echo "\r" . $msg . "";
        } else {
            echo "\n" . wordwrap($msg,80) . "";
        }
    }

    /**
     * Pre progress bar
     */
    static function ppb(){
        self::log('_');
    }

    public function __construct()
    {
        $auth = $this->getAuth();

        // create client object and set access token
        $this->sc = new Services_Soundcloud(CLIENT_ID, CLIENT_SECRET, REDIRECT_URL);

        $this->sc->setCurlOptions(array(
            CURLOPT_PROGRESSFUNCTION => array(get_class($this), 'progressCallback'),
            CURLOPT_NOPROGRESS => false,
            CURLOPT_RETURNTRANSFER => true,

        ));

        if ($auth['expires_in'] > time()) { // сессия еще валидна
            self::log('Use saved session.');
            $this->sc->setAccessToken($auth['access_token']);
        } else {
            // обновляем сессию
            self::log('Session expired. Refreshing session.');
            self::$current_download_operation = 'Refreshing session';
            self::ppb();
            $token = $this->sc->accessTokenRefresh($auth['refresh_token']);
            $token['expires_in'] += time();
            $db = new db(self::db_auth);
            $db->saveAuth(serialize($token));
        }
        self::log('Authorization successful.');

        $this->already_downloaded = $this->getLinksArray();
    }

    public function __destruct(){
        self::log(str_repeat('-',80));
        self::log($this->stat[0] . ' downloaded, ' . $this->stat[1] . ' skipped, ' . $this->stat[2] . ' failed');
        self::log('');
    }

    public function setSavePath($local, $path)
    {
        $this->save_local = $local;
        $this->save_path = $path;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function processStream($stream)
    {
        $i = 0;
        $j = 0;
        $count = min($this->count, count($stream->collection));
        foreach ($stream->collection as $item) {
            if ($i >= $count) continue;
            if ($this->trackDownload($item->origin)) $j++;
            $i++;
            self::log($i . ' / ' . $count . ' tracks processed. ' . ceil(($i) * 100 / $count) . '%, ' . $j . ' downloaded, ' . ($i - $j) . ' skipped');
        }
    }

    public function processTracksArray($stream)
    {
        $i = 0;
        $j = 0;
        $count = min($this->count, count($stream));
        foreach ($stream as $track) {
            if ($i >= $count) continue;
            if ($this->trackDownload($track)) $j++;
            $i++;
            self::log($i . ' / ' . $count . ' tracks processed. ' . ceil(($i) * 100 / $count) . '%, ' . $j . ' downloaded, ' . ($i - $j) . ' skipped');
        }

    }

    public function trackDownload($track)
    {
        if ($track->kind != 'track') return false;

        self::log( str_repeat('-',80)); // -----------------------------

        self::log('Track "' . $track->title . '"');
        if (in_array($track->id, $this->already_downloaded)) {
            self::log('Already downloaded. Continue...');
            $this->stat[1]++; // skipped
            self::log( str_repeat('-',80)); // -----------------------------
            return false;
        }

        $downloaded_file = null;
        $download = false;
        $low = false;

        try {
            $low = false;
            self::$current_download_operation = 'Trying to download full track';
            self::ppb();
            $downloaded_file = $this->sc->download($track->id);
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            //self::log($e->getMessage());
            self::log('Unable to download full track.');
        }

        if (is_null($downloaded_file)) {
            self::log('Downloading stream version');
            $track_url = $track->stream_url . '?client_id=' . CLIENT_ID;
            //$downloaded_file = file_get_contents($track_url);
            self::$current_download_operation = 'Downloading stream';
            self::ppb();
            $downloaded_file = $this->downloadFileByUrl($track_url);
            $low = true;
        }

        if (!is_null($downloaded_file)) {

            if ($this->save_local == true) {
                $path = dirname(__FILE__) . $this->save_path;
                if (!file_exists($path)) mkdir($path);
            } else {
                $path = $this->save_path;
            }

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
                $this->addLink($track->id);
                self::log('Successfully downloaded as "' . $new_name . '"!');
                $this->stat[0]++; // downloaded
            }
        } else {
            self::log('Unable to download ' . ($low ? '(low)' : '(high)') . ' "' . $track->title . '" ');
            $this->stat[2]++; // failed
        }
        self::log( str_repeat('-',80)); // -----------------------------

        return $download ? true : false;

    }

    public function downloadFileByUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_BUFFERSIZE,128);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, array(get_class($this), 'progressCallback'));
        curl_setopt($ch, CURLOPT_NOPROGRESS, false);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function progressCallback($download_size, $downloaded, $upload_size, $uploaded)
    {
        if ($download_size > 0) {
            $progress = (round($downloaded / $download_size * 1000) / 10);
            $progress_int = round($progress);

            // [*******----------][43%]
            $pr_long = 40;
            $pr_complete = round($pr_long * $progress_int / 100);
            $pr_string = "[" . str_repeat('*', $pr_complete) . str_repeat('-', ($pr_long - $pr_complete)) . "][" . $progress_int . "%] " . scsync::$current_download_operation;

            // scsync::log( scsync::$current_download_operation . ', precent:' .$progress. " from " . $download_size, true);
            scsync::log($pr_string, true);
        } else {
            scsync::log(scsync::$current_download_operation, true);
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

    public function ownStream()
    {
        try {
            self::log('Own stream');
            self::$current_download_operation = 'Getting own stream';
            self::ppb();
            $stream = json_decode($this->sc->get('me/activities/tracks/affiliated'));
            $this->processStream($stream);
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            self::log('Unknown error with message ' . $e->getMessage());
        }

    }


    public function resolve($url)
    {
        self::$current_download_operation = 'Resolve content type by link';
        self::ppb();
        return json_decode($this->sc->get('resolve', array('url' => $url), array(CURLOPT_FOLLOWLOCATION => true)));
    }

    public function getUserTracks($id)
    {
        try {
            self::log('User #' . $id);
            self::$current_download_operation = 'Getting user\'s tracks';
            self::ppb();
            $stream = json_decode($this->sc->get('users/' . $id . '/tracks'));
            $this->processTracksArray($stream);
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            self::log('Unknown error with message ' . $e->getMessage());
        }

    }

    public function getGroupTracks($id)
    {
        try {
            self::log('Group #' . $id);
            self::$current_download_operation = 'Getting group\'s tracks';
            self::ppb();
            $stream = json_decode($this->sc->get('groups/' . $id . '/tracks'));
            $this->processTracksArray($stream);
        } catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
            self::log('Unknown error with message ' . $e->getMessage());
        }

    }

}


$app = new scsync();
if (isset($argv[1])) {
    $app->setSavePath(false, $argv[1]);
}

if (isset($argv[3])) {
    $app->setCount($argv[3]);
}


if (isset($argv[2])) {
    if ($argv[2] == 'STREAM') {
        $app->ownStream();
    } else {
        $resolve = $app->resolve($argv[2]);
        $id = $resolve->id;
        switch ($resolve->kind) {
            case 'track':
                $app->trackDownload($resolve);
                break;
            case 'user':
                $app->getUserTracks($id);
                break;

            case 'playlist':
                $app->processTracksArray($resolve->tracks);
                break;

            case 'group':
                $app->getGroupTracks($id);
                break;

            default:
                self::log('Unknown kind: ' . $resolve->kind . ', id: ' . $id);
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


