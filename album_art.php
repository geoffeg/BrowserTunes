<?php 
require_once('getid3/getid3.php');
$getID3 = new getID3;
$mp3_dir = "/Volumes/WD External/iTunes Library/iTunes Music";
$path = $mp3_dir . $HTTP_GET_VARS['path'];
$file_id3 = $getID3->analyze(get_mp3($path));
header("Content-Type: image/png");
echo @$file_id3['id3v2']['PIC'][0]['data'];


function get_mp3($path) {
  if (is_dir($path)) {
    // look for the first mp3 in the directory
    if ($handle = opendir($path)) {
      while (false !== ($file = readdir($handle))) {
        $fullpath = $path . '/' . $file;
        if (substr($fullpath, strlen($fullpath) - strlen('.mp3')) == '.mp3') {
          return $fullpath;
        }
      }
    }
  } else {
    return $path;
  }
}

?>
