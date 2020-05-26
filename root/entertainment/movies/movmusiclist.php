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
<script language="javascript" src="/javascript/sort.js"></script>
<script language="javascript" type="text/javascript" src="/javascript/tableh.js"></script> 
<script language="javascript">

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

     <TABLE id="rsTable" name="rsTable" cellSpacing=1 cellPadding=2 width="100%" border=0  cols=9 align="center" background="transparent"
       onMouseOver="javascript:trackTableHighlight(event, '#E3E8FF');" onMouseOut="javascript:highlightTableRow(0);">
      <TR style=" border-bottom-color:#0000CC; background-color:#E7C0FE">
       <TD width="1%"></TD>
	   <TD width="5%">
	    <P align=center><A href="javascript:sortTable(1, rsTable);"><STRONG><FONT face=Verdana size=1>TrackNo</FONT></STRONG></A></P>
       </TD>
	   <TD width="25%">
	    <P align=center><A href="javascript:sortTable(2, rsTable);"><STRONG><FONT face=Verdana size=1>Track Name</FONT></STRONG></A>
        </P>
       </TD>
	   <TD width="25%">
	    <P align=center><A href="javascript:sortTable(3, rsTable);"><STRONG><FONT face=Verdana size=1>Artist</FONT></STRONG></A></P>
       </TD>
	   <TD width="25%">
	    <P align=center><A href="javascript:sortTable(4, rsTable);"><STRONG><FONT face=Verdana size=1>Album</FONT></STRONG></A></P>
       </TD>
	   <TD width="6%">
	    <P align=center><A href="javascript:sortTable(5, rsTable);"><STRONG><FONT face=Verdana size=1>Year</FONT></STRONG></A></P>
       </TD>
	   <TD width="6%">
	    <P align=center><A href="javascript:sortTable(6, rsTable);"><STRONG><FONT face=Verdana size=1>Rating</FONT></STRONG></A></P>
       </TD>
	   <TD width="6%">
	    <P align=center><A href="javascript:sortTable(7, rsTable);"><STRONG><FONT face=Verdana size=1>Link</FONT></STRONG></A></P>
       </TD>
       <TD width="1%"><input name='linkv' type='hidden'></TD>
      </TR>
      <?php
       include 'parsexml.php';

       for($x=0;$x<count($track_array);$x++){ 
	  
	     echo "\n\t\t<TR>";
         echo "\n\t\t  <TD></TD>";
  	     echo "\n\t\t  <TD>";
	     echo "\n\t\t    <P align=center><STRONG><FONT face=Verdana size=1>";
		 echo $x+1;
		 echo "</FONT></STRONG></P></TD>";
	     echo "\n\t\t  <TD>";
	     echo "\n\t\t    <P align=center><STRONG><FONT face=Verdana size=1>";
		 echo $track_array[$x]->title;
		 echo "</FONT></STRONG></P></TD>";
	     echo "\n\t\t  <TD>";
	     echo "\n\t\t    <P align=center><STRONG><FONT face=Verdana size=1>";
		 echo $track_array[$x]->artist;
		 echo "</FONT></STRONG></P></TD>";
	     echo "\n\t\t  <TD>";
	     echo "\n\t\t    <P align=center><STRONG><FONT face=Verdana size=1>";
		 echo $track_array[$x]->album;
		 echo "</FONT></STRONG></P></TD>";
	     echo "\n\t\t  <TD>";
	     echo "\n\t\t    <P align=center><STRONG><FONT face=Verdana size=1>";
		 echo $track_array[$x]->year;
		 echo "</FONT></STRONG></P></TD>";
	     echo "\n\t\t  <TD>";
	     echo "\n\t\t    <P align=center><STRONG><FONT face=Verdana size=1>";
		 echo $track_array[$x]->rating;
		 echo "</FONT></STRONG></P></TD>";
	     echo "\n\t\t  <TD>";
	     echo "\n\t\t   <P align=center><STRONG><FONT face=Verdana size=1><input name=\"videolink\" type=\"image\" src=\"/entertainment/music/images/playbutton.gif\" ";
		 echo "\n\t\t      style=\"cursor:hand\" alt=\"play video\" onclick=\"playvideo( '";
		 $url = "http://www.youtube.com/watch?v=".$track_array[$x]->ylink;
		 echo $url."' ) \" ></FONT></STRONG></P></TD>";
         echo "\n\t\t  <TD></TD>";
         echo "\n\t\t</TR>";	  
	   }
	   
	  ?>
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