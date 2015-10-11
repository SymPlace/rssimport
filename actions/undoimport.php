<?php

$id = get_input('id');

$history = elgg_get_annotation_from_id($id);

//sanity check
if (!is_object($history)) {
	register_error(elgg_echo('rssimport:invalid:history'));
	forward(REFERRER);	
}

if($history->owner_guid != elgg_get_logged_in_user_guid() && !elgg_is_admin_logged_in()){
	register_error(elgg_echo('rssimport:wrong:permissions'));
	forward(REFERRER);
}


// so now we know we're the owner, we can go ahead and delete
$ids = explode(',', $history->value);
foreach ($ids as $guid) {
	$entity = get_entity($guid);
	if ($entity) {
		$entity->delete();
	}
}

// all imported entities deleted - now delete the history entry
$history->delete();

//set message and return to referrer
system_message(elgg_echo('rssimport:undoimport:success'));
forward(REFERRER);