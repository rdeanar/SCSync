<?

include "config.php";
include "db.php";
include "php-soundcloud-master/Services/Soundcloud.php";


if (isset($_GET['code'])) {
// create client object with app credentials
    $client = new Services_Soundcloud(CLIENT_ID, CLIENT_SECRET, REDIRECT_URL);

    // exchange authorization code for access token
    $code = $_GET['code']; // cd3dd6c2a0353f8736285bdf2d7a6c24

    try{
    $access_token = $client->accessToken($code);
    $access_token['expires_in'] += time();

    $db = new db(DB_AUTH);
    $db->saveAuth(serialize($access_token));

    echo '<h1>Authorized successful.</h1><br> Close Terminal tab, return to Finder and repeat action.';
    //echo print_r($access_token);

    }catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $a){
        echo 'Invalid CODE, <a href="/">try again</a>';
    }

} elseif(isset($_GET['getcode'])) {
// create client object with app credentials
    $client = new Services_Soundcloud(
        CLIENT_ID, CLIENT_SECRET, REDIRECT_URL);

// redirect user to authorize URL
    header("Location: " . $client->getAuthorizeUrl());
}else{
    ?>
    <a href="?getcode=1">Auth</a>
<?
}

