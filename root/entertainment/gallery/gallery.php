<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>
Image Gallery
</title>

<link rel="icon" type="image/vnd.microsoft.icon" href="/images/allpirates.ico">
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" />
<script src="/javascript/ddmenu.js" type="text/javascript"></script>

</head>

<body>

<div id="container">

    <?php session_start(); ?>
    
    <?php include("../../header.html"); ?>

    <?php include("../../menu.html"); ?>

	<div id="main_content">

	  <img src="/entertainment/gallery/images/galleryheader.png"></img></p>
   
      <?php
		 
         if(isset($_SESSION['account']) && strcmp ($_SESSION['account'], "duketip") == 0) {
	  ?>
			 
		   <object width="650" height="450">
           <param name="movie" value="duketip/duketipshow.swf" base="duketip/" >
           <param name="allowFullScreen" value="true" />
           <embed src="duketip/duketipshow.swf" width="650" height="450" base="duketip/" allowFullScreen="true" >
           </embed>
           </object>
      <?php
		 }
		 else {
      ?>

		   <object width="550" height="380">
           <param name="movie" value="slideshow.swf">
           <param name="allowFullScreen" value="true" />
           <embed src="slideshow.swf" width="550" height="380" allowFullScreen="true" >
           </embed>
           </object>
           
     <?php
		 }
	  ?>
      
      <p>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
           	</div>
				<div class="clearthis">&nbsp;</div>


    <?php include("../../footer.html"); ?>
</div>

</body>
</html>