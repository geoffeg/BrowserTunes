<?php 
require_once('getid3/getid3.php');
$getID3 = new getID3;
$mp3_dir = "/Volumes/WD External/iTunes Library/iTunes Music";
$path = $mp3_dir . urldecode($HTTP_GET_VARS['path']);
$file_id3 = $getID3->analyze(get_mp3($path));

if ($HTTP_GET_VARS['mode'] == "art") {
  get_album_art($file_id3);
} else if ($HTTP_GET_VARS['mode'] == "id3") {
  get_album_info($path, $file_id3);
}

function get_album_art($id3) {
  header("Content-Type: image/png");
  echo $id3['id3v2']['PIC'][0]['data'];
}

function get_album_info($path, $id3) {
  header("Content-Type: application/json");
  $info['artist'] = $id3['id3v2']['TP1'][0]['data'];
  $info['album'] = $id3['id3v2']['TAL'][0]['data'];
  echo json_encode(array_merge($info, get_album_totals($path)));
}

function get_album_totals($path) {
  global $getID3;
  if (is_dir($path)) {
    // look for the first mp3 in the directory
    if ($handle = opendir($path)) {
      while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
          $track_id3 = $getID3->analyze(get_mp3($path));
          $info['total_length'] += @$track_id3['playtime_seconds'];
          $info['total_songs']++;
        }
      }
    }
  }
  return $info;
}

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
