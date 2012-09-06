<?php

$rssimport = $vars['entity'];

// create the link to toggle form
echo "<h4 class=\"rssimport_center\"><a href=\"javascript:void(0);\" class=\"rssimport-formtoggle\">";
echo $rssimport ? elgg_echo('rssimport:edit:settings') : elgg_echo('rssimport:create:new');
echo "</a></h4><br>";


//create the div for the form, hidden if we're viewing a feed, visible if we're adding a new feed
$initialstyle = $rssimport ? '' : ' style="display:block"';
echo '<div id="createrssimportform"' . $initialstyle . '>';


// set up the title
echo elgg_echo('rssimport:name') . "<br>";
echo elgg_view('input/text', array(
     'name' => 'feedtitle',
     'id' => 'feedName',
     'value' => elgg_get_sticky_value('rssimport', 'feedtitle', $rssimport->title)
     ));
  
echo "<br><br>";


// set up the feed url
echo elgg_echo('rssimport:url') . "<br>";
echo elgg_view('input/text', array(
    'name' => 'feedurl',
    'id' => 'feedurl',
    'value' => elgg_get_sticky_value('rssimport', 'feedurl', $rssimport->description)
    ));

echo "<br><br>";


// dropdown for cron import - if no cron allowed make it a hidden input with value 'never'

// default options
$view = 'input/dropdown';
$view_suffix = "<br><br>";
$options = array(
    'name' => 'cron',
    'id' => 'feedcron',
    'value' => elgg_get_sticky_value('rssimport', 'cron', $rssimport->cron),
    'options_values' => array('never' => elgg_echo('rssimport:cron:never'))
);
  
// add in various times, as set by the plugin settings
$cron_times = array('hourly', 'daily', 'weekly');

foreach ($cron_times as $time) {
  $cron_allowed = elgg_get_plugin_setting('cron_' . $time, 'rssimport');
    
  if ($cron_allowed == 'yes') {
    $options['options_values'][$time] = elgg_echo('rssimport:cron:'.$time);
  }
}
  
// no cron schedules allowed, force hidden input
if (count($options['options_values']) <= 1) {
  $view = 'input/hidden';
  $options['value'] = 'never';
  unset($options['options_values']);
  $view_suffix = '';
}
else {
  echo elgg_echo('rssimport:cron:description') . " ";
}

echo elgg_view($view, $options) . $view_suffix;


// default access
echo elgg_echo('rssimport:defaultaccess:description') . " ";
echo elgg_view('input/access', array(
    'name' => 'defaultaccess',
    'value' => elgg_get_sticky_value('rssimport', 'defaultaccess', $rssimport->defaultaccess)
    ));

echo "<br><br>";


// default tags textbox
echo elgg_echo('rssimport:defaulttags') . "<br>";
echo elgg_view('input/text', array(
    'name' => 'defaulttags',
    'id' => 'defaulttags',
    'value' => elgg_get_sticky_value('rssimport', 'defaulttags', $rssimport->defaulttags)
    ));

echo "<br><br>";


// copyright checkbox
echo "<div class=\"rssimport_copyright_warning\">" . elgg_echo('rssimport:copyright:warning') . "</div>";
$options = array(
    'name' => 'copyright',
    'value' => 1
);

if (elgg_get_sticky_value('rssimport', 'copyright', $rssimport->copyright)) {
  $options['checked'] = 'checked';
}

echo elgg_view('input/checkbox', $options);

echo elgg_echo('rssimport:copyright');
echo "<br><br>";

// hidden input for containerid - the container_guid of the imported content
echo elgg_view('input/hidden', array(
    'name' => 'containerid',
    'value' => elgg_get_sticky_value('rssimport', 'containerid', $vars['containerid'])
    ));


// hidden input for import_into - the type of content to import into
echo elgg_view('input/hidden', array(
    'name' => 'import_into',
    'value' => elgg_get_sticky_value('rssimport', 'import_into', $vars['import_into'])
    ));


// are we updating something?
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $rssimport->guid));


//submit button
echo elgg_view('input/submit', array(
    'value' => $rssimport ? elgg_echo('rssimport:update') : elgg_echo('rssimport:create')
    ));

echo elgg_view('input/button', array(
    'value' => elgg_echo('rssimport:cancel'),
    'class' => 'rssimport-formtoggle',
    ));

echo "</div>";