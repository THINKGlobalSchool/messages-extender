<?php
/**
 * Messages-Extender start.php
 * 
 * @package Messages-Extender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 * 
 * OVERRIDES:
 * - forms/messages/send
 * - forms/messages/reply
 *
 * ACTIONS:
 * - Replaces messages/send
 * 
 * PAGES:
 * - Replaces pages/messages/send page
 */

// Register init
elgg_register_event_handler('init', 'system', 'messages_extender_init');

// Init
function messages_extender_init() {
	// Unregister messages/send action
	elgg_unregister_action("messages/send");

	// Register new and improved action
	$action_path = elgg_get_plugins_path() . 'messages-extender/actions/messages';
	elgg_register_action("messages/send", "$action_path/send.php");

	// Extend messages page handler
	elgg_register_plugin_hook_handler('route', 'messages', 'messages_extender_route_handler', 50);
}

// Hook into messages routing to replace messages send page
function messages_extender_route_handler($hook, $type, $return, $params) {
	if (is_array($return['segments']) && $return['segments'][0] == 'compose') {
		elgg_load_library('elgg:messages');
		$base_dir = elgg_get_plugins_path() . 'messages-extender/pages/messages';
		include("$base_dir/send.php");
		return true;
	}
	return $return;
}

/**
 * Prepare the compose form variables
 *
 * @return array
 */
function messages_extender_prepare_form_vars($recipient_guid = 0) {

	// input names => defaults
	$values = array(
		'subject' => '',
		'body' => '',
		'members' => '',
	);

	if (elgg_is_sticky_form('messages')) {
		foreach (array_keys($values) as $field) {
			$values[$field] = elgg_get_sticky_value('messages', $field);
		}
	} else if ($recipient_guid) {
		$values['members'] = array($recipient_guid);
	}

	elgg_clear_sticky_form('messages');

	return $values;
}

