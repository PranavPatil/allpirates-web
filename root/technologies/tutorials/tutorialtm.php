<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<link rel="icon" type="image/vnd.microsoft.icon" href="/images/allpirates.ico">
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" />
<script src="/javascript/ddmenu.js" type="text/javascript"></script>

</head>

<body>

<div id="container">

    <?php include("$DOCUMENT_ROOT/header.html"); ?>

    <?php include("$DOCUMENT_ROOT/menu.html"); ?>

	<div id="main_content">

      <p>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
 
      <div class="pagecontent">
      <?php 
	  $address = isset($_POST["address"]) ? $_POST["address"]: NULL;

      if(!isset($address))
	    $address = isset($_GET["address"]) ? $_GET["address"]: NULL;
	  
	  if (is_null($address))
		echo "<center><h2>Tutorial Not Specified</h2></center>";
	  else 
	  {
        $pos = strrchr($address, ".");
        $ext = substr($pos, 1, strlen($pos));
		  
		if(strcasecmp($ext, "html") != 0)
  		  echo "<center><h2>Invalid Tutorial</h2></center>";
		else
		{
          $root = "$DOCUMENT_ROOT";
          $full = $root."/".$address;
	  
          if (file_exists($full)) {
            include("$full");	  
	      }
	      else
		    echo "<center><h2>Tutorial Not Found</h2></center>";
		}
	  }
	        	  
	  ?>
      </div>
      
   	</div>
	<div class="clearthis">&nbsp;</div>

    <?php include("$DOCUMENT_ROOT/footer.html"); ?>
</div>

</body>
</html>