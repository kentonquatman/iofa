<?php

if (!defined('BASEPATH')) exit('Invalid file request');
if (!defined('PATH_THIRD')) define('PATH_THIRD', EE_APPPATH.'third_party/');
	require_once PATH_THIRD.'zoo_triggers/config.php';

/**
 * Zoo Triggers Update Class
 *
 * @package   Zoo Triggers
 * @author    ExpressionEngine Zoo <info@eezoo.com>
 * @copyright Copyright (c) 2011 ExpressionEngine Zoo (http://eezoo.com)
 */
class Zoo_triggers_upd
{
	var $version = ZOO_TRIGGERS_VER;
	var $module_name = ZOO_TRIGGERS_CLASS;

	function __construct()
	{
	}

	function install()
	{
		// Insert module data
		$data = array(
			'module_name' => $this->module_name,
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		);

		ee()->db->insert('modules', $data);

		return TRUE;
	}

	function uninstall()
	{
		// Delete module and his actions
		ee()->db->select('module_id');
		$query = ee()->db->get_where('modules', array('module_name' => $this->module_name));

		ee()->db->where('module_id', $query->row('module_id'));
		ee()->db->delete('module_member_groups');

		ee()->db->where('module_name', $this->module_name);
		ee()->db->delete('modules');

		ee()->db->where('class', $this->module_name);
		ee()->db->delete('actions');

		ee()->db->where('class', $this->module_name.'_mcp');
		ee()->db->delete('actions');

		return TRUE;
	}

	function update($current = '')
	{
		if (!$current || $current == $this->version)
		{
			return FALSE;
		}

		ee()->db->where('class', __CLASS__);
		ee()->db->update('extensions', array('version' => $this->version));
	}
}