<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>
Music World
</title>

<link rel="icon" type="image/vnd.microsoft.icon" href="/images/allpirates.ico">
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" />
<script src="/javascript/ddmenu.js" type="text/javascript"></script>
<script type="text/javascript" src="/flash/player/swfobject.js"></script>
</head>

<body>

<div id="container">

    <?php include("$DOCUMENT_ROOT/header.html"); ?>

    <?php include("$DOCUMENT_ROOT/menu.html"); ?>

	<div id="main_content">
	  <img src="/entertainment/music/images/musicpanel.png"></img></p>

<?php
$PARAMS = (isset($HTTP_POST_VARS)) ? $HTTP_POST_VARS : $HTTP_GET_VARS;
$vlink = "";

foreach ( $PARAMS as $key=>$value ){
  if ( $key == "linkv") {
     $vlink = $value;
  }
}
?>
   <object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="500" height="315">
		<param name="movie" value="/flash/player/player-viral.swf" />
		<param name="allowfullscreen" value="true" />
		<param name="allowscriptaccess" value="always" />
        <param name="wmode" value="transparent" />
		<param name="flashvars" value="file=<?php print( $vlink); ?>&autostart=true" />
		<embed
			type="application/x-shockwave-flash"
			id="player2"
			name="player2"
			src="/flash/player/player-viral.swf" 
			width="500" 
			height="315"
			allowscriptaccess="always" 
			allowfullscreen="true"
            wmode="transparent" 
			flashvars="file=<?php print($vlink); ?>&autostart=true" 
		/>
	</object>

      <p>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
           	</div>
				<div class="clearthis">&nbsp;</div>


    <?php include("$DOCUMENT_ROOT/footer.html"); ?>
</div>

</body>
</html>