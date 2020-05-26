<?php
/**
 * Receive all mail from Gmail Inbox example.
 *
 * Created on 11-Nov-06.
 *
 * @package gmTest
 * @author Vladislav Bailovic <malatestapunk@gmail.com>
 */

include ('gmatom.php');

$g = new GmAtom ('allpirates', 'password');
$msgCount = $g->check();
if (false === $msgCount) {
	die ('Error');
} else {
	echo "<h1>".$msgCount." messages</h1>";
	$g->receiveAll();
	$g->sortBy('subject', true);
	echo '<dl>';
	foreach ($g->messages as $mid=>$msg) {
		echo '<dt>'.$mid.': <B>'.$msg->from.'</b> '.$msg->subject.'</dt>';
		echo '<dd>'.$msg->body.'</dd>';
		echo '<dd>'.date('r', $msg->timestamp)." ({$msg->date})".'</dd>';
		echo '<dd><a href="'.$msg->link.'">'.$msg->link.'</a></dd>';
	}
	echo '</dl>';
}
?>
