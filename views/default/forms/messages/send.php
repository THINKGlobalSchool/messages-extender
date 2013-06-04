<?php
/**
 * Messages-Extender forms/messages/send override
 * 
 * @package Messages-Extender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 * 
 * @uses $vars['friends']
 */

$members = elgg_extract('members', $vars);
$subject = elgg_extract('subject', $vars, '');
$body = elgg_extract('body', $vars, '');

// $recipients_options = array();
// foreach ($vars['friends'] as $friend) {
// 	$recipients_options[$friend->guid] = $friend->name;
// }

// if (!array_key_exists($recipient_guid, $recipients_options)) {
// 	$recipient = get_entity($recipient_guid);
// 	if (elgg_instanceof($recipient, 'user')) {
// 		$recipients_options[$recipient_guid] = $recipient->name;
// 	}
// }

// $recipient_drop_down = elgg_view('input/dropdown', array(
// 	'name' => 'recipient_guid',
// 	'value' => $recipient_guid,
// 	'options_values' => $recipients_options,
// ));

$recipient_picker = elgg_view('input/userpicker', array(
	'id' => 'recipient_guids',
	'value' => $members
));

?>
<div>
	<label><?php echo elgg_echo("messages:to"); ?>: </label>
	<?php echo $recipient_picker; ?>
</div>
<div>
	<label><?php echo elgg_echo("messages:title"); ?>: <br /></label>
	<?php echo elgg_view('input/text', array(
		'name' => 'subject',
		'value' => $subject,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo("messages:message"); ?>:</label>
	<?php echo elgg_view("input/longtext", array(
		'name' => 'body',
		'value' => $body,
	));
	?>
</div>
<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('messages:send'))); ?>
</div>
