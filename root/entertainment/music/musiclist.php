<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>
Music World
</title>

<link rel="icon" type="image/vnd.microsoft.icon" href="/images/allpirates.ico"/>
<link rel="stylesheet" type="text/css" media="screen" href="/style.css"/>
<script language="javascript" type="text/javascript" src="/javascript/ddmenu.js"></script>
<script language="javascript" type="text/javascript" src="/javascript/jquery.js"></script>
<script language="javascript" type="text/javascript" src="/javascript/jtablesorter.min.js"></script> 
<script language="javascript" type="text/javascript" src="/javascript/tableh.js"></script> 
<script language="javascript">

  $(document).ready(function() 
    { 
      $("#musicTable").tablesorter(); 
    } 
  ); 

  function playvideo(vlink)
  {
    document.musiclist.linkv.value = vlink;
    document.musiclist.submit();
  }
  
</script>

</head>

<body>

<div id="container">

    <?php include("$DOCUMENT_ROOT/header.html"); ?>

    <?php include("$DOCUMENT_ROOT/menu.html"); ?>

	<div id="main_content" style="background:url(images/background_music.jpg) repeat fixed;">
    <form id="musiclist" name="musiclist" action="/entertainment/music/musicplayer.php" method="post">

     <TABLE id="musicTable" name="musicTable" cellSpacing=1 cellPadding=2 width="100%" border=0  cols=9 align="center" background="transparent"
       onMouseOver="javascript:trackTableHighlight(event, '#E3E8FF');" onMouseOut="javascript:highlightTableRow(0);">
      <thead style="cursor:pointer;">
      <TR style=" border-bottom-color:#0000CC; background-color:#E7C0FE">
       <TH width="1%"><input name='linkv' type='hidden'></TH>
	   <TH width="5%">
	    <P align=center><STRONG><FONT face=Verdana size=1>TrackNo</FONT></STRONG></P>
       </TH>
	   <TH width="25%">
	    <P align=center><STRONG><FONT face=Verdana size=1>Track Name</FONT></STRONG></P>
       </TH>
	   <TH width="25%">
	    <P align=center><STRONG><FONT face=Verdana size=1>Artist</FONT></STRONG></P>
       </TH>
	   <TH width="25%">
	    <P align=center><STRONG><FONT face=Verdana size=1>Album</FONT></STRONG></P>
       </TH>
	   <TH width="6%">
	    <P align=center><STRONG><FONT face=Verdana size=1>Year</FONT></STRONG></P>
       </TH>
	   <TH width="6%">
	    <P align=center><STRONG><FONT face=Verdana size=1>Rating</FONT></STRONG></P>
       </TH>
	   <TH width="6%">
	    <P align=center><STRONG><FONT face=Verdana size=1>Link</FONT></STRONG></P>
       </TH>
      </TR>
      </thead>
      <tbody style="font-family:Verdana, Geneva, sans-serif; font-weight:bold; font-size:10px;">

      <?php
       include 'parsexml.php';

       for($x=0;$x<count($track_array);$x++){ 
	  
	     echo "\n\t\t<TR align=\"left\">";
         echo "\n\t\t  <TD style=\"padding-bottom:4px; padding-top:4px; padding-left:4px;\"></TD>";
  	     echo "\n\t\t  <TD style=\"padding-bottom:4px; padding-top:4px; padding-left:4px;\">";
		 echo $x+1;
		 echo "</TD>";
	     echo "\n\t\t  <TD style=\"padding-bottom:4px; padding-top:4px; padding-left:4px;\">";
		 echo $track_array[$x]->title;
		 echo "</TD>";
	     echo "\n\t\t  <TD style=\"padding-bottom:4px; padding-top:4px;\">";
		 echo $track_array[$x]->artist;
		 echo "</TD>";
	     echo "\n\t\t  <TD style=\"padding-bottom:4px; padding-top:4px;\">";
		 echo $track_array[$x]->album;
		 echo "</TD>";
	     echo "\n\t\t  <TD style=\"padding-bottom:4px; padding-top:4px;\">";
		 echo $track_array[$x]->year;
		 echo "</TD>";
	     echo "\n\t\t  <TD style=\"padding-bottom:4px; padding-top:4px; padding-left:4px;\">";
		 echo $track_array[$x]->rating;
		 echo "</TD>";
	     echo "\n\t\t  <TD style=\"padding-bottom:4px; padding-top:4px; padding-left:4px;\">";
	     echo "\n<input name=\"videolink\" type=\"image\" src=\"/entertainment/music/images/playbutton.gif\" ";
		 echo "\n\t\t      style=\"cursor:hand\" alt=\"play video\" onclick=\"playvideo( '";
		 $url = "http://www.youtube.com/watch?v=".$track_array[$x]->ylink;
		 echo $url."' ) \" ></TD>";
         echo "\n\t\t</TR>";	  
	   }
	   
	  ?>
      </tbody>
	 </TABLE>
    </form>
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