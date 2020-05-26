<?php
/**
 * Receive specific number of new messages from Gmail Inbox.
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
	// If you don't need the message body, omit the third parameter:
	$g->receive(2,5, true);
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
