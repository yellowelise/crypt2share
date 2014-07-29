<?php
session_start();
$f = $_SESSION["app_address"] . "homes/" . $_REQUEST['f'];
//$f = $_SESSION['home'] . $_REQUEST['f'];

if (isset($_REQUEST['w']))
$w = $_REQUEST['w'];
else
$w = '800';

if (isset($_REQUEST['h']))
$h = $_REQUEST['h'];
else
$h = '450';

?>

<!doctype html>

<head>
<script src="/jwplayer/jwplayer.js"></script>
<script>jwplayer.key="e8Ih38F/F90sFhPB2fNVIM0wdQskZLzW4oUusQ=="</script>
<script src="/jwplayer/jquery.js"></script>

</head>

<body style="margin:0px;">
<div id='my-video'></div>
<script type='text/javascript'>
    jwplayer('my-video').setup({
		autostart: "false",
		//fullscreen: "true",
        file: '<?echo $f?>',
        image: '/jwplayer/logobig.png',
        width: '<?echo $w?>',
        height: '<?echo $h?>',
        players: [
        { type: "flash", src: "/jwplayer/jwplayer.flash.swf", config: {provider: "sound"}  },
        {  type: "html5", config: {provider: "sound"}  }
  ],
     events:
     {
        onPlay: function () {jwplayer('my-video').setFullscreen(true)},
        onPause: function() {jwplayer('my-video').setFullscreen(false)},
        onComplete:function()
           {
               jwplayer('my-video').setFullscreen(false),
               jwplayer('my-video').setup(options)
            }                      
     }
 
    });
//alert($(window).width() + "x" + ($(window).width() / 1.7777));
</script>
</body>
