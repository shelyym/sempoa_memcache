<?php
/*
 *  Database, Websetting and Path Setting
 *  untuk multiple selection di def di init.php
 */
$serverpath = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "sempoa_8";

//$db_name = "c1nt466_sempoa_migrasi";
$db_prefix = '';
//init db setting
$DbSetting = array ("serverpath" => $serverpath, "db_username" => $db_username, "db_password" => $db_password,
                    "db_name"    => $db_name, "db_prefix" => $db_prefix);
//Websetting
$domain = "localhost:8888";
$folder = '/sempoa_memcached/';
$title = 'Dashboard';
    $metakey = 'TBS';
$metadescription = 'TBS';
$lang = 'en';
$currency = 'IDR';
//path untuk save, filesystem path kalau untuk linux bisa dari depan /opt/lamp/...
$photo_path = '/Users/efindiongso/Documents/htdocs/sempoa_memcached/uploads/'; //always use full path - elroy 19 12 2014
//path utk url, tanpa http:// dan tanpa folder e.g /leapportal/
$photo_url = 'uploads/';

//plugins/jQuery_File_Upload/server/php/files/images/';
//themepath
//cek if admin or not
//echo $_GET['url'];
/*if($_GET['url']== 'index')
    $themepath = 'carouselfull';
elseif($_GET['url']== 'home' || $_GET['url'] == "leap_admin")
    $themepath = 'adminlte';
else {
    $themepath = 'cleanblog';
}*/
/*
$adminlte = 0;
if (strpos($_GET['url'], 'EfiHome') !== false || strpos($_GET['url'], 'PageWeb') !== false || strpos($_GET['url'],
        'GalleryWeb') !== false || strpos($_GET['url'], 'FilesWeb') !== false || strpos($_GET['url'],
        'EventWeb') !== false || strpos($_GET['url'], 'SettingWeb') !== false
) {
    $adminlte = 1;
}*/
/*if($_GET['url']== 'index' || $_GET['url'] == "leap_admin"||$adminlte)
    $themepath = 'adminlte';
else {
   $themepath = 'tbstheme'; 
}*/
/*
$exp = explode("/", $_GET['url']);
if ($_GET['url'] != "index" && count($exp) < 2) {
    $themepath = 'tbstheme';
} else {
    $themepath = 'adminlte';
}*/
if (strpos($_GET['url'], 'PushHome') !== false || $_GET['url'] == "index"){
    $themepath = 'adminlte2';
}else{
    $themepath = 'tbstheme';
}

// init web setting
$WebSetting = array ("domain"          => $domain, "folder" => $folder, "title" => $title, "metakey" => $metakey,
                     "metadescription" => $metadescription, "lang" => $lang, "currency" => $currency,
                     "photopath"       => $photo_path, "photourl" => $photo_url, "themepath" => $themepath);
//timezone
$timezone = 'Asia/Jakarta';

//javascript files
$js = "loader_js.php";
//css files
$css = "loader_css.php";

//main class MUST BE subclass of Apps
$mainClass = "SempoaMain";
//set namespace for apps
$nameSpaceForApps = array ("");