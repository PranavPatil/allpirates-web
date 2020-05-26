<?php
/**
 * Receive default number of new messages from label 'mylabel'.
 * Note: no body excerpts are gathered in this example.
 *
 * Created on 11-Nov-06.
 *
 * @package gmTest
 * @author Vladislav Bailovic <malatestapunk@gmail.com>
 */

include ('gmatom.php');

$g = new GmAtom ('allpirates', 'password');
$g->setLabel('mylabel');
$msgCount = $g->check();
if (false === $msgCount) {
	die ('Error');
} else {
	echo "<h1>".$msgCount." messages</h1>";
	$g->receive();
	$g->sortBy('subject', true);
	echo '<dl>';
	foreach ($g->messages as $mid=>$msg) {
	/* If you need message bodies as well, you could do $msg->getBody(); here. */
	/* Then, you could echo $msg->body, or whatever */
		echo '<dt>'.$mid.': <B>'.$msg->from.'</b> '.$msg->subject.'</dt>';
		echo '<dd>'.date('r', $msg->timestamp)." ({$msg->date})".'</dd>';
		echo '<dd><a href="'.$msg->link.'">'.$msg->link.'</a></dd>';
	}
	echo '</dl>';
}
?>
