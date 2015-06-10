<?php
/**
 * Messages-Extender pages/messages/send override
 * 
 * @package Messages-Extender
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 */

elgg_gatekeeper();

$page_owner = elgg_get_logged_in_user_entity();
elgg_set_page_owner_guid($page_owner->getGUID());

$title = elgg_echo('messages:add');

elgg_push_breadcrumb($title);

$params = messages_extender_prepare_form_vars((int)get_input('send_to'));
$content = elgg_view_form('messages/send', array('name' => 'messages'), $params);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
