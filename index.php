<HTML>
<HEAD>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script language="javascript">
var audio_player;

function load_list(url) {
  $('#track_list').load('/~geoffeg/list.php?path=' + escape(url));
}

function pause() {
  
}

function play_pause(url) {
  url = escape(url);
  url = '/mp3' + url;
  if (audio_player.paused && audio_player.src.match(url+"$")) { // the user tapped the currently playing track while playback was paused
    audio_player.play();
  } else if (audio_player.paused == false && audio_player.src.match(url+"$")) { // the user tapped the currently paused track
    audio_player.pause();
  } else { // the track names didn't match, switch to the new track
    audio_player.src = url;
    audio_player.load();
    audio_player.play();
  }

}

function play(url) {
  audioPlayer.src = url;
  audioPlayer.load();
  playPause();
}

function init() {
  audio_player = $('AUDIO')[0];
  load_list('');
}
window.onload = init;
//window.onkeypress = key_handler;
</script>
<style type="text/css">
UL, LI, BODY, DIV, SPAN { margin: 0; padding: 0; border: 0; font-size: 100%; }
BODY { font-family: Helvetica; }
UL { list-style: none; }
#album_art { float: left; }
#album_info, AUDIO { display: none; }
#album_info_album_name, #album_info_artist_name { font-size: 12px; }

#track_list LI { font-size: 50px; font-weight: bold; padding: 30px; border-bottom: 1px solid #e9e9e9; }
#track_list LI.odd_row { background-color: #f3f3f3 }
</style>

</HEAD>
<BODY>
<audio></audio>
<div id="album_info">
  <img src="" id="album_art" width="50" height="50"/>
  <div id="album_info_artist_name">&nbsp;</div>
  <div id="album_info_album_name">&nbsp;</div>
  <div id="album_info_details">
    <span id="album_info_total_songs"><span id="album_info_total_songs_value">&nbsp;</span> Songs</span>
    <span id="album_info_total_minutes"><span id="album_info_total_minutes_value">&nbsp;</span> Minutes</span>
  </div>
</div>

<div>
  <UL id="track_list">
    
  </UL>
</div>

</BODY>
