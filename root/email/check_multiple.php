<?php
/**
 * Check mail for multiple Gmail accounts.
 * Note the (bool)true parameter to check() method.
 * 
 * Created on 11-Nov-06.
 * 
 * @package gmTest
 * @author Vladislav Bailovic <malatestapunk@gmail.com>
 */

include ('gmatom.php');


$accounts = array (
	'0' => array ('username'=>'username1', 'password'=>'password1'),
	'1' => array ('username'=>'username2', 'password'=>'password2'),
);
$g = new GmAtom();
foreach ($accounts as $a) {
	$g->setLoginInfo ($a['username'], $a['password']);
	// We need fresh connection for each account, so we supply
	// (bool)true to check() method.
	$msgCount = $g->check(true);
	if (false !== $msgCount) {
		echo $msgCount . ' messages for ' . $g->username . '<br />';
	} else {
		echo 'There has been an error checking "' . $g->username . '" account<br />';
	}
}
?>
