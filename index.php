<HTML>
<HEAD>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<meta name="apple-mobile-web-app-capable" content="yes"/> 
<meta name="viewport" content="width=320; user-scalable=no"/>
<script language="javascript">
var audio_player;
var current_url;

function load_list(url) {
  current_url = url;
  var url_tokens = unescape(url).split('/');
  $('#track_list').load('list.php?path=' + escape(url));
  if (url_tokens.length > 1) { // We're in an album. fetch album artwork and info
    $('#back_button').show();
  $('#title').html(url_tokens[url_tokens.length - 1]);
  } else {
  $('#title').html("Artists");
    $('#back_button').hide();
  }
  if (url_tokens.length == 3) { // We're in an album. fetch album artwork and info
    $('#album_info').show();
    $('#album_art').attr('src','album_info.php?mode=art&path=' + escape(url));
    $.getJSON('album_info.php?mode=id3&path=' + escape(url), function(data) {
        $('#album_info_artist_name').html(data['artist']);
        $('#album_info_album_name').html(data['album']);
        $('#album_info_total_songs_value').html(data['total_songs']);
        $('#album_info_total_minutes_value').html(parseInt(data['total_length'] / 60));
    });
  } else {
    $('#album_info').hide();
  }
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

function go_back() {
  var url_tokens = current_url.split('/');
  url_tokens.length = url_tokens.length - 1;
  load_list(url_tokens.join('/'));
}


function next_track() {

}

addEventListener('load', function() {
  setTimeout(function() { window.scrollTo(0,1) }, 100);
  audio_player = $('AUDIO')[0];
  audio_player.addEventListener("ended", function() { next_track(); }, true);
  load_list('');
});
//window.onkeypress = key_handler;
</script>
<style type="text/css">
UL, LI, BODY, DIV, SPAN { margin: 0; padding: 0; border: 0; font-size: 100%; }
BODY { font-family: Helvetica; }
UL { list-style: none; }
#album_art { float: left; padding-right: 10px; }
#album_info { padding: 10px; min-height: 90px; }
#album_info_album_name, #album_info_artist_name { font-size: 20px; margin-bottom: 5px; }
#album_info_artist_name { font-weight: bold; }
#album_info_total_songs, #album_info_total_minutes { font-size: 14px; color: #979797 }

#track_list LI { font-size: 20px; font-weight: bold; padding: 14px; border-bottom: 1px solid #e9e9e9; border-top: 1px solid #e9e9e9; text-overflow: ellipsis; overflow: hidden; width: 292px; white-space: nowrap; }
#track_list LI.odd_row { background-color: #f3f3f3; }
#navigation {  position: relative; height: 15px; width: 292px; border-top: 1px solid #83898d; border-bottom: 1px solid black; text-shadow: #4b545f 0px -1px 1px; font-size: 20px; font-weight: bold; color: white; padding: 14px; background: -webkit-gradient(linear, left top, left bottom, color-stop(0, rgb(181,192,206)), color-stop(0.5, rgb(136,155,179)), color-stop(0.5, rgb(127,148,176)), color-stop(1, rgb(109,131,161))); }
#back_button { position: absolute; top: 7px; }
#title { position: absolute; top: 10px; left: 80px; width: 180px; text-align: center; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
#album_info, AUDIO, #back_button { display: none; }
#control_bar { position: relative; height: 80px; border: 1px solid black; top: -48px; }
</style>

</HEAD>
<BODY>
<div id="navigation">
  <span id="back_button" onclick="go_back()"><img src="back-button.png"/></span>
  <span id="title">&nbsp;</span>
  <span id="now_playing"></span>
</div>
<div id="album_info">
  <img src="" id="album_art" width="90"/>
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
<audio></audio>

</BODY>
