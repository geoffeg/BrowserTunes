<?php 
$mp3_dir = "/Volumes/WD External/iTunes Library/iTunes Music";
$mp3_url_root = "/mp3";
$path = $mp3_dir . $HTTP_GET_VARS['path'];
if ($handle = opendir($path)) {
  while (false !== ($file = readdir($handle))) {
    $count++;
    if (substr($file, 0, 1) != '.') {
      $url = $HTTP_GET_VARS['path'] . '/' . $file;
      $css_class = "even_row";
      if ($count%2) $css_class = "odd_row";
      if (is_dir($path . "/" . $file)) :
        ?>
     <LI onclick="load_list('<?=$url?>')" class="<?=$css_class?>"><?=$file?></LI>
    <?php else: ?> 
     <LI onclick="play_pause('<?=$url?>')" class="<?=$css_class?>"><?=$file?></LI>
    <?php endif; ?>
<?php
    }
  }
}

?>
