
<?php

 /*
 create table users
 (
   userid int primary key auto_increment,
   name varchar(15) not null Unique,
   email varchar(25) not null Unique,
   passwd varchar(15) not null,
   vericode int not null
  ) ENGINE=MyISAM;
 */

  $name = isset($_POST['name']) ? $_POST['name']: '';
  $passwd = isset($_POST['passwd']) ? $_POST['passwd']: '';
  $vericode = isset($_POST['vericode']) ? $_POST['vericode']: '';
  $msg = '';

  if(strlen($name) > 0 && strlen($passwd) > 0 && strlen($vericode) > 0)
  {
     $link = mysql_connect('sql207.getasite.co.cc', 'getas_2513119', 'password');

     if (!$link) {
       $msg = 'Could not connect to the System: ' . mysql_error();
       $msgid = 'logerror';
     }

     if(mysql_select_db("getas_2513119_allpirates", $link))
	 {
	   $sql = sprintf("SELECT passwd, vericode from users where name='%s'", mysql_real_escape_string($name));
       $result = mysql_query($sql, $link);

       if (!$result)
       {
         $msg = 'Error: ' . mysql_error();
         $msgid = 'logerror';
       }
	   else {

         if ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		   // if(strcmp ($row[0], $passwd) == 0 && strcmp ($row[1], $vericode) == 0) {    // commented during duketip program for img upload.
		   if(strcmp ($row[0], $passwd) == 0) {
             $msg = 'Login Successfully';
             $msgid = 'logsuccess';

			 session_start();
             $_SESSION['account'] = $name;
		   }
           else {
             $msg = 'The password entered for the user or the machine from which the account is accessed does not match.';
             $msgid = 'loginvalid';
           }
         }
         else {
           $msg = 'The Server does not find any login entry with the user name \''. $name . '\'.';
           $msgid = 'loginvalid';
         }

         mysql_free_result($result);
	   }
	 }
	 else {
       $msg = 'Error: ' . mysql_error();
       $msgid = 'logerror';
	 }

      mysql_close($link);
  }
  else {
      $msg = 'The Server could did not find any valid field for user name or password for authentication';
      $msgid = 'loginvalid';
  }

  echo $msgid . "\n";
  echo $msg;

  if($msgid == 'logerror') {
    echo "\nThere was a problem in the server in either connecting or accessing data from the database server. \nPlease contact the administrator at allpirates@gmail.com for further assistence.";

  }
  elseif($msgid == 'loginvalid') {
    echo "\nPlease check the user name, password once again. \nMake sure you login on the same machine on which you registered.";
  }

  exit;

?>
