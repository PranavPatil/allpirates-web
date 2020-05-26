<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<?php
$msgid = isset($_GET['msgid']) ? $_GET['msgid']: '';
?>
<title><?php if ($msgid=="accsuccess") echo "Successful Account Registration"; else if ($msgid=="logsuccess") echo "Successful Login"; ?></title>

<link rel="icon" type="image/vnd.microsoft.icon" href="/images/allpirates.ico">
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" />
<script src="/javascript/ddmenu.js" type="text/javascript"></script>

</head>

<body>

<div id="container">

    <?php include("$DOCUMENT_ROOT/header.html"); ?>

    <?php include("$DOCUMENT_ROOT/menu.html"); ?>

	<div id="main_content" style="background:url(/accounts/images/msgbk.jpg) repeat fixed;">

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
      
      <center>
      <table align="center"><tbody>
      <tr>
        <td>
        <?php 
		  if ($msgid=="accsuccess") 
		  {
		    echo "<img src=\"/icons/email.png\" align=\"bottom\">"; 
			echo "\n</td>\n";
			echo "<td><h1>&nbsp;&nbsp;&nbsp;&nbsp;Email Verification</h1></td></tr>";
            echo "\n</tbody></table>";
            echo "<br /><br />";
            echo "<h3>&nbsp;&nbsp;&nbsp;&nbsp;Please check your email inbox inorder to verify your email address and complete the registration process.</h3>";
            echo "<br /><br />";
            echo "It is important to verify your email address inorder to confirm your identity, ensure valid source for contact, keep updated with the website and help to reset your password.";
			
		  }
		  else if ($msgid=="versuccess") 
		  {
		    echo "<img src=\"/icons/success.png\" align=\"bottom\">";
			echo "\n</td>\n";
			echo "<td><h1>&nbsp;&nbsp;&nbsp;&nbsp;Email Verification Completed</h1></td></tr>";
            echo "\n</tbody></table>";
            echo "<br /><br />";
			$msg = isset($_GET['msg']) ? $_GET['msg']: '';
            echo "<h3>&nbsp;&nbsp;&nbsp;&nbsp;" . $msg . ".</h3>";
            echo "<br /><br />";
            echo "You could now login using you recently created username and password and gain access to your AllPirates user account.";
			
		  }
		  else if ($msgid=="vererror") 
		  {
		    echo "<img src=\"/icons/error.png\" align=\"bottom\">";
			echo "\n</td>\n";
			echo "<td><h1>&nbsp;&nbsp;&nbsp;&nbsp;Error in SQL</h1></td></tr>";
            echo "\n</tbody></table>";
            echo "<br /><br />";
			$msg = isset($_GET['msg']) ? $_GET['msg']: '';
            echo "<h3>&nbsp;&nbsp;&nbsp;&nbsp;" . stripslashes($msg) . ".</h3>";
            echo "<br /><br />";
            echo "There was a problem in the server in either connecting or accessing data from the database server. Please contact the administrator at allpirates@gmail.com for further assistence.";
			
		  }
		  else if ($msgid=="verinvalid") 
		  {
		    echo "<img src=\"/icons/violated.png\" align=\"bottom\">";
			echo "\n</td>\n";
			echo "<td><h1>&nbsp;&nbsp;&nbsp;&nbsp;Invalid Request</h1></td></tr>";
            echo "\n</tbody></table>";
            echo "<br /><br />";
			$msg = isset($_GET['msg']) ? $_GET['msg']: '';
            echo "<h3>&nbsp;&nbsp;&nbsp;&nbsp;" . $msg . ".</h3>";
            echo "<br /><br />";
            echo "Please check the URL properly and try re-registering if the URL is still invalid.";
			
		  }
		  else if ($msgid=="logsuccess") 
		  {
		    echo "<img src=\"/icons/success.png\" align=\"bottom\">"; 
			echo "\n</td>\n";
			echo "<td><h1>&nbsp;&nbsp;&nbsp;&nbsp;Welcome to your AllPirates Account.</h1></td></tr>";
            echo "\n</tbody></table>";
            echo "<br /><br />";
            echo "<h3>&nbsp;&nbsp;&nbsp;&nbsp;You are officially logged in as a user of AllPirates website.</h3>";
            echo "<br /><br />";
            echo "You could now access numerous articles and source codes restricted before and could also request for site co-ordinator inorder to publish your work on this website.";
			
		  }
		  
		?>
      </center>
	  </p>
      <br /><br />
      <br /><br />
      <br /><br />
      <br /><br />
      <br /><br />
      <br /><br />
      <br /><br />
      <br /><br />
      <br /><br />
      <br /><br />
      <br /><br />
      <br /><br />
      <br /><br />

  </div>
				<div class="clearthis">&nbsp;</div>


    <?php include("$DOCUMENT_ROOT/footer.html"); ?>
</div>

</body>
</html>