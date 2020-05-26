<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>
Source Viewer
</title>
<link rel="icon" type="image/vnd.microsoft.icon" href="/images/allpirates.ico">
<style type="text/css">
.codestyle span{display:inline;}
.codestyle pre {
white-space: pre-wrap; /* css-3 */
white-space: -moz-pre-wrap !important; /* Mozilla, since 1999 */
white-space: -pre-wrap; /* Opera 4-6 */
white-space: -o-pre-wrap; /* Opera 7 */
word-wrap: break-word; /* Internet Explorer 5.5+ */
}

</style>
<link type="text/css" rel="stylesheet" href="/code2html/css/sh_ide-msvcpp.min.css">
<link rel="stylesheet" type="text/css" href="/style.css" media="screen" />
<script src="/javascript/ddmenu.js" type="text/javascript"></script>
<script type="text/javascript" src="/code2html/sh_main.min.js"></script>

</head>

<body onLoad="sh_highlightDocument('/code2html/lang/', '.min.js');">

<div id="container">

    <?php include("$DOCUMENT_ROOT/header.html"); ?>

    <?php include("$DOCUMENT_ROOT/menu.html"); ?>

	<div id="main_content">

      <?php 
	  
        $vfile = isset($_GET['vfile']) ? $_GET['vfile']: "";

        $pos  = strrchr($vfile, ".");
 	    $ext = substr($pos, 1, strlen($pos));
		$pclass = "";
		$imgsrc = "";
		
		switch ($ext)
        {
          case "java":         $pclass = "sh_java";
                               $imgsrc = "java_title.png";
                               break;
          case "cpp":          $pclass = "sh_cpp";
                               $imgsrc = "cpp_title.png";
                               break;
          case "c":            $pclass = "sh_c";
                               $imgsrc = "c_title.png";
                               break;
          case "cs":           $pclass = "sh_csharp";
                               $imgsrc = "csharp_title.png";
                               break;
          case "py":           $pclass = "sh_python";
                               $imgsrc = "python_title.png";
                               break;
          case "php":          $pclass = "sh_php";
                               $imgsrc = "web_title.png";
                               break;
          case "jsp":          $pclass = "sh_html";
                               $imgsrc = "web_title.png";
                               break;
          case "asp":          $pclass = "sh_html";
                               $imgsrc = "web_title.png";
                               break;
          case "sql":          $pclass = "sh_sql";
                               $imgsrc = "no_title.png";
                               break;
          case "xml":          $pclass = "sh_xml";
                               $imgsrc = "no_title.png";
                               break;
          case "pl":           $pclass = "sh_perl";
                               $imgsrc = "web_title.png";
                               break;
          case "js":           $pclass = "sh_javascript";
                               $imgsrc = "web_title.png";
                               break;
          case "html":         $pclass = "sh_html";
                               $imgsrc = "web_title.png";
                               break;
          case "sh":           $pclass = "sh_sh";
                               $imgsrc = "linux_title.png";
                               break;
          default:             $pclass = "sh_sh";
                               $imgsrc = "no_title.png";
		                       break;
        }

      ?>

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
	  <img src="images/<?php echo $imgsrc; ?>"></img></p>
      <hr />

      <div class="codestyle" style="width:830px; padding-left:10px; padding-right:10px;">

      <pre  id="codePre" style="text-align:left;font-size: 13px; color:#000; width: 830px;" class="<?php echo $pclass; ?>">

      <?php 
        if (file_exists($vfile)) {
	      $fh = fopen($vfile, 'r');
          $theData = fread($fh, filesize($vfile));
          fclose($fh);
		  echo "\n";
          echo $theData;
		}
		else
		  echo "<center><h2>File Not Found</h2></center>";
	  ?>
      </pre>
      </div>

   	</div>
	<div class="clearthis">&nbsp;</div>
<br /><br /><br />
    <?php include("$DOCUMENT_ROOT/footer.html"); ?>
</div>

</body>
</html>