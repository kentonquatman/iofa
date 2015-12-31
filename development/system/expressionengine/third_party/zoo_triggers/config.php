<?php

if (!defined('ZOO_TRIGGERS_NAME'))
{
	define('ZOO_TRIGGERS_NAME', 'Zoo Triggers');
	define('ZOO_TRIGGERS_CLASS', 'Zoo_triggers');
	define('ZOO_TRIGGERS_VER', '1.2.5');
	define('ZOO_TRIGGERS_DESC', "Zoo Triggers is the add-on that fills the gap between Structure and 'categories and archives'.");
	define('ZOO_TRIGGERS_DOCS', 'http://ee-zoo.com/add-ons/triggers/');
	define('ZOO_TRIGGERS_UPD', 'http://ee-zoo.com/add-ons/triggers/releasenotes.rss');
}

// NSM Addon Updater
$config['name'] = ZOO_TRIGGERS_NAME;
$config['version'] = ZOO_TRIGGERS_VER;
$config['nsm_addon_updater']['versions_xml'] = ZOO_TRIGGERS_UPD;

// EE 2.6 Compatibility
if(!function_exists('ee'))
{
  function ee()
  {
    static $EE;
    if (!$EE)
      $EE = get_instance();
    return $EE;
  }
}