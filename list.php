<?php 
require_once('getid3/getid3.php');
$getID3 = new getID3;
$mp3_dir = "/Volumes/WD External/iTunes Library/iTunes Music";
$mp3_url_root = "/mp3";
$path = $mp3_dir . $HTTP_GET_VARS['path'];
if ($handle = opendir($path)) {
  while (false !== ($file = readdir($handle))) {
    if (substr($file, 0, 1) != '.') {
    $count++;
      $url = $HTTP_GET_VARS['path'] . '/' . $file;
      $css_class = "odd_row";
      if ($count%2) $css_class = "even_row";
      if (is_dir($path . "/" . $file)) :
        ?>
     <LI onclick="load_list('<?=$url?>')" class="<?=$css_class?>"><?=$file?></LI>
    <?php else:
      $file_id3 = $getID3->analyze($path . '/' . $file);
    ?> 
     <LI onclick="play_pause('<?=$url?>')" class="<?=$css_class?>"><?=@$file_id3['tags']['id3v2']['title'][0]?></LI>
    <?php endif; ?>
<?php
    }
  }
}

?>
