<?php
$connect_to = '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX';
$user = 'pranav@gmail.com';
$password = 'password';

$connection = imap_open($connect_to, $user, $password)
  or die("Can't connect to '$connect_to': " . imap_last_error());

imap_close($connection);
?>
