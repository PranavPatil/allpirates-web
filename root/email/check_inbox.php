<?php
/**
 * Check Gmail Inbox example.
 * This just checks Gmail Inbox for new mail.
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
	echo "<h1>".$msgCount." new messages</h1>";
}

?>
