
<?php

  require 'aes.php';  // from www.movable-type.co.uk/scripts/aes-php.html
  require("$DOCUMENT_ROOT/phpmail/class.phpmailer.php");
  require("$DOCUMENT_ROOT/phpmail/class.smtp.php");

  $name = isset($_POST['name']) ? $_POST['name']: NULL;
  $email = isset($_POST['email']) ? $_POST['email']: NULL;
  $passwd = isset($_POST['passwd']) ? $_POST['passwd']: NULL;
  $vericode = isset($_POST['vericode']) ? $_POST['vericode']: NULL;

  // $timer = microtime(true);
  $valid = 1;

  if($name == NULL) {
    $valid = 0;
    $msg = '\'Name\' field is empty.';
    $msgid = 'accinvalid';
  }
  elseif($email == NULL) {
    $valid = 0;
    $msg = '\'Email\' field is empty.';
    $msgid = 'accinvalid';
  }
  elseif($passwd == NULL) {
    $valid = 0;
    $msg = '\'Passwd\' field is empty.';
    $msgid = 'accinvalid';
  }
  elseif($vericode == NULL) {
    $valid = 0;
    $msg = '\'Vericode\' field is empty.';
    $msgid = 'accinvalid';
  }

  if($valid == 1) {

    $link = mysql_connect('sql207.getasite.co.cc', 'getas_2513119', 'password');

    if (!$link) {
      $valid = 0;
      $msg = 'Could not connect to the System: ' . mysql_error();
      $msgid = 'accerror';
    }
	else {

      if(mysql_select_db("getas_2513119_allpirates", $link))
      {
	    $sql = sprintf("SELECT count(*) from users where name='%s'", mysql_real_escape_string($name));
        $result = mysql_query($sql, $link);

        if($result != FALSE && ($row = mysql_fetch_array($result, MYSQL_NUM))) {

		  if($row[0] == 0) {

			$row = FALSE;
   	        $sql = sprintf("SELECT count(*) from users where email='%s'", mysql_real_escape_string($email));
            $result = mysql_query($sql, $link);

            if($result != FALSE && ($row = mysql_fetch_array($result, MYSQL_NUM))) {

              if($row[0] == 0) {
  	            $valid = 1;
		      }
			  else {
  	            $valid = 0;
                $msg = "Email address aready present in the system. \nPlease select a different email id for registration.";
                $msgid = 'accinvalid';
			  }
			}
			else {
              $msg = 'Error: ' . mysql_error();
              $msgid = 'logerror';
			}
		  }
		  else {
            $valid = 0;
            $msg = "User name aready present in the system. \nPlease select a different user name.";
            $msgid = 'accinvalid';
		  }
		}
        else {
          $msg = 'Error: ' . mysql_error();
          $msgid = 'logerror';
        }

        mysql_free_result($result);
	  }
      else {
		 $valid = 0;
         $msg = 'Error: ' . mysql_error();
         $msgid = 'accerror';
	  }

      mysql_close($link);
	}
  }

  if($valid == 1) {

   // initialise password & plaintesxt if not set in post array (shouldn't need stripslashes if magic_quotes is off)
   $pwd = "Lock9991122J55";
   $pt = "name=".$name."&email=".$email."&passwd=".$passwd."&vericode=".$vericode;
   $plain = stripslashes($pt);
   $encr = AESEncryptCtr($plain, $pwd, 256);

   try {

     $html = "<div style=\"margin: 0pt;\">
<center>
<table style=\"border: 20px solid rgb(238, 238, 238); margin: 10px auto; width: 550px;\">
<tbody><tr><td style=\"padding: 20px;\">
  <table>
    <tr>
      <td><img alt=\" \" src=\"http://pranav_patil.getasite.co.cc/images/allpirates_logo.png\"></td>
      <td align=\"top\"><h1 style=\"font-family:Monotype Corsiva; font-size:35px; color:#A2A2A2; float:left;\" border= \"0\">&nbsp;&nbsp;&nbsp;&nbsp;All Pirates</h1></td>
    </tr>
  </table>
<hr style=\"border: 0pt none ; min-height: 1px; background-color: rgb(204, 204, 204); color: rgb(204, 204, 204); margin-bottom: 20px;\">

<p style=\"color: rgb(54, 54, 54); font-family: &#39;Lucida Grande&#39;,Trebuchet,Helvetica,sans-serif; font-size: 14px; line-height: 20px; margin-to=
p: 10px; text-align: justify;\">You&#39;ll need to confirm your email address in order to complete your registration. Click the link below:</p>

<p style=\"color: rgb(54, 54, 54); font-family: &#39;Lucida Grande&#39;,Trebuchet,Helvetica,sans-serif; font-size: 12px; line-height: 18px; margin-to=
p: 20px; text-align: justify;\"></p><center><a href=\"http://www.pranav_patil.getasite.co.cc/accounts/verify.php?rcode=";

     $html = $html.urlencode($encr)."\" target=\"_blank\"><img alt=\"Verify Email\" src=\"http://pranav_patil.getasite.co.cc/images/verify.gif\" border=\"0\"></a></center>
</td></tr>
</tbody></table>
</center>
</div>";

     $mail = new PHPMailer(true);

     $mail->IsSMTP();                                      // set mailer to use SMTP
     $mail->Host = "smtp.gmail.com";  // specify main and backup server
     $mail->SMTPAuth = true;     // turn on SMTP authentication
     $mail->SMTPSecure = "ssl";
     $mail->Port = "465";
     $mail->Username = "allpirates";  // SMTP username
     $mail->Password = "password"; // SMTP password

     $mail->From = "allpirates@gmail.com";
     $mail->FromName = "All Pirates";
     $mail->AddReplyTo("allpirates@gmail.com","All Pirates");
     $mail->AddAddress($email, $name);

     $mail->Subject = "Complete AllPirates Account Registration";
     $mail->AltBody = "You'll need to confirm your email address in order to complete your registration. Click the link below:

   http://www.pranav_patil.getasite.co.cc/accounts/verify.php?rcode=".urlencode($encr);

     $mail->WordWrap = 50;                                 // set word wrap to 50 characters
#    $mail->Body    = $html;
     $mail->MsgHTML($html);
     $mail->IsHTML(true);                                  // set email format to HTML

     if(!$mail->Send())
     {
	   $valid = 0;
       $msg = 'Mailer Error: ' . $mail->ErrorInfo;
       $msgid = 'accerror';
     }
     else{
       $msg = 'Registration completed successfully !!';
       $msgid = 'accsuccess';
     }
   } catch (phpmailerException $e) {
       $valid = 0;
       $msg = 'Mailer Error: ' . $e->errorMessage();
       $msgid = 'accerror';
   }
  }

  echo $msgid . "\n";
  echo $msg;

  if($msgid == 'accerror') {
    echo "\nThere was a problem in the server in either connecting or accessing data from the database server. \nPlease contact the administrator at allpirates@gmail.com for further assistence.";

  }
  elseif($msgid == 'accinvalid') {
    echo "\nPlease check whether all fields are filled before submitting the form.";
  }

  exit;

?>
