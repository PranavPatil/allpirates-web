
<?php

  require("phpmail/class.phpmailer.php");
  require("phpmail/class.smtp.php");

   try {

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
     $mail->AddAddress("pranav@gmail.com", "Pranav");

     $mail->Subject = "Complete AllPirates Account Registration";
     $mail->AltBody = "You'll need to confirm your email address in order to complete your registration. Click the link below:
   http://www.pranav_patil.getasite.co.cc/accounts/verify.php";

     $mail->WordWrap = 50;                                 // set word wrap to 50 characters
#    $mail->Body    = $html;
     $mail->MsgHTML("Hello");
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
       $msg = 'Mailer Error: ' . $e->getTrace();
       $msgid = 'accerror';
   }

  echo $msgid . "\n";
  echo $msg;


  exit;

?>
