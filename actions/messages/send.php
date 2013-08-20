<?php
/**
 * Messages-Extender messages/send action replacement
 * 
 * @package MEssages-Extender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 */

$subject = strip_tags(get_input('subject'));
$body = get_input('body');
$recipient_guids = get_input('members');

elgg_make_sticky_form('messages');

//$reply = get_input('reply',0); // this is the guid of the message replying to

if (!$recipient_guids || empty($recipient_guids)) {
	register_error(elgg_echo("messages:user:blank"));
	forward("messages/compose");
}

if (!is_array($recipient_guids)) {
	$recipient_guids = array($recipient_guids);
}

// Make sure the message field, send to field and title are not blank
if (!$body || !$subject) {
	register_error(elgg_echo("messages:blank"));
	forward("messages/compose");
}

// Loop over recipients and verify users
foreach ($recipient_guids as $idx => $guid) {
	$user = get_user($guid);
	if (!elgg_instanceof($user, 'user')) {
		register_error(elgg_echo("messages:user:nonexist", array($guid)));
	} else {
		// Otherwise, 'send' the message 
		$result = messages_send($subject, $body, $guid, 0, $reply);
		if (!$result) {
			register_error(elgg_echo("messages-extender:user:senderror", array($user->name)));
		}
	}
}

// Save 'send' the message
if (!$result) {
	$fwd = "messages/compose";
} else {
	$fwd = 'messages/inbox/' . elgg_get_logged_in_user_entity()->username;
	elgg_clear_sticky_form('messages');	
	system_message(elgg_echo("messages:posted"));
}

forward($fwd);
