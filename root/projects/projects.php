<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php

$path = substr($_SERVER['SCRIPT_FILENAME'], 0,
    strrpos($_SERVER['SCRIPT_FILENAME'], '/') + 1);

# Original PHP code by Chirp Internet: www.chirp.com.au
  # Please acknowledge use of this code by including this header.

  function getFileList($dir, $recurse=false, $level=0)
  {
    # array to hold return value
    $retval = array();

    # add trailing slash if missing
    if(substr($dir, -1) != "/") $dir .= "/";

    # open pointer to directory and read list of files
    $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
    while(false !== ($entry = $d->read())) {
      # skip hidden files
      if($entry[0] == ".") continue;
      if(is_dir("$dir$entry")) {
		$nlevel = $level+1;
        $retval[] = array(
          "fullname" => "$dir$entry/",
		  "name" => "$entry",
          "size" => 0,
		  "level" => "$nlevel",
          "lastmod" => filemtime("$dir$entry")
        );
        if($recurse && is_readable("$dir$entry/")) {
          $retval = array_merge($retval, getFileList("$dir$entry/", true, $level+1));
        }
      } elseif(is_readable("$dir$entry")) {
		$nlevel = $level+1;
        $retval[] = array(
          "fullname" => "$dir$entry",
		  "name" => "$entry",
          "size" => filesize("$dir$entry"),
		  "level" => "$nlevel",
          "lastmod" => filemtime("$dir$entry")
        );
      }
    }
    $d->close();

    return $retval;
  }
?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>
Projects
</title>

<link rel="icon" type="image/vnd.microsoft.icon" href="/images/allpirates.ico">
<link rel="stylesheet" type="text/css" href="/style.css" media="screen" />
<script src="/javascript/ddmenu.js" type="text/javascript"></script>
<script type="text/javascript"> 
  var imgpath	= "/projects/images/";
</script>    
<script language="javascript" type="text/javascript" src="/javascript/jstree.js"></script> 

</head>

<body>

<div id="container">

    <?php include("$DOCUMENT_ROOT/header.html"); ?>

    <?php include("$DOCUMENT_ROOT/menu.html"); ?>

	<div id="main_content">
	  <img src="images/projects.jpg"></img></p>

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

     <div class="tree" style="text-align:left;">
     <script type="text/javascript"> 
		<!--
		var Tree = new Array;
		// nodeId | parentNodeId | nodeName | nodeUrl
     <?php 
	 
     $count = 0;
     $maxlevno = 0;
	 $sect = isset($_GET['sect']) ? $_GET['sect']: NULL;
	 
	 if(is_null($sect))
	   $sect = "java";

     # include all subdirectories recursively
     $dirlist = getFileList("src/".$sect."/", true);
     $levalue = array(0 => 1);

     sort($dirlist);
     printf(" 		Tree[%s]  = \"%s|%s|%s|#\";\n", $count, $count+1, 0, $sect);
     $count = $count + 1;

	 foreach ($dirlist as $value) {
		
       if($maxlevno < $value['level']) {
         $maxlevno = $value['level'];		   
         $levalue = array_merge((array)$levalue, array($maxlevno => $count));
	     $temp = $count;
	   }
	   elseif($maxlevno > $value['level']) {
         $temp = $value['level'];

         if ($value['size'] == 0)
		   $levalue[$temp+1] = $count+1;

		 $temp = $levalue[$temp];
	   }
	   else {
	     $temp = $value['level'];
		 $temp = $levalue[$temp];
	   }

       if ($value['size'] == 0)
         printf(" 		Tree[%s]  = \"%s|%s|%s|#\";\n", $count, $count+1, $temp, $value['name']);
	   else
         printf(" 		Tree[%s]  = \"%s|%s|%s|srcviewer.php?vfile=%s\";\n", $count, $count+1, $temp, $value['name'], $value['fullname']);
		 
	   $count = $count + 1;
	 }
	
     ?>
	
	  createTree(Tree);
		//-->
 	 </script> 
     </div>

   	</div>
	<div class="clearthis">&nbsp;</div>

    <?php include("$DOCUMENT_ROOT/footer.html"); ?>
</div>

</body>
</html>