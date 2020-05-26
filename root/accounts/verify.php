
<!--
create table users
(
 userid int primary key auto_increment,
 name varchar(15) not null Unique,
 email varchar(25) not null Unique,
 passwd varchar(15) not null,
 vericode int not null
) ENGINE=MyISAM;
/
-->

<?php

  require 'aes.php';  // from www.movable-type.co.uk/scripts/aes-php.html
  $msg = '';
  $encr = isset($_GET['rcode']) ? $_GET['rcode']: NULL;

  if($encr != NULL) {

    $pwd = "Lock9991122J55";
    $decr = AESDecryptCtr($encr, $pwd, 256);
	$name = '';
	$email = '';
	$passwd = '';
	$vericode = '';
	$val = 0;

    $tok = strtok($decr, " &");

    while ($tok !== false) {

	  if(strncmp('name=',$tok, strlen('name=')) == 0) {
		$name = substr($tok, strlen('name='));

		if(strlen($name) > 0)
		  $val++;
	  }
      elseif(strncmp('email=',$tok, strlen('email=')) == 0) {
		$email = substr($tok, strlen('email='));

		if(strlen($email) > 0)
		  $val++;
	  }
	  elseif(strncmp('passwd=',$tok, strlen('passwd=')) == 0) {
		$passwd = substr($tok, strlen('passwd='));

		if(strlen($passwd) > 0)
		  $val++;
	  }
	  elseif(strncmp('vericode=',$tok, strlen('vericode=')) == 0) {
		$vericode = substr($tok, strlen('vericode='));

		if(strlen($vericode) > 0)
		  $val++;
	  }

      $tok = strtok(" &");
    }

    if($val == 4)
	{
      $link = mysql_connect('sql207.getasite.co.cc', 'getas_2513119', 'password');

      if (!$link) {
        $msg = 'Could not connect to the System: ' . mysql_error();
        $msgid = 'vererror';
      }

      if(mysql_select_db("getas_2513119_allpirates", $link))
	  {
	    $sql =  "INSERT INTO users values ( NULL, \"".$name."\", \"".$email."\", \"".$passwd."\", \"".$vericode."\")";

        if (!mysql_query($sql, $link))
        {
          $msg = 'Error: ' . mysql_error();
          $msgid = 'vererror';
        }
	    else {
          $msg = 'User Registration Process is Completed Successfully';
          $msgid = 'versuccess';
		}
	  }
	  else {
        $msg = 'Error: ' . mysql_error();
        $msgid = 'vererror';
	  }

      mysql_close($link);
	}
    else {
      $msg = 'The Server could did not find the registration code valid with no such entry in the system before';
      $msgid = 'verinvalid';
	}
  }
  else {
    $msg = 'The request was forwarded without any registration code to the server';
    $msgid = 'verinvalid';
  }

  $url = "Location: /accounts/message.php?msgid=". $msgid . "&msg=". $msg;
  header($url);
  exit;

?>
