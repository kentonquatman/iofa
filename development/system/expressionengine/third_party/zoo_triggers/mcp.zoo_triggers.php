<?php

if (!defined('BASEPATH')) exit('Invalid file request');
require_once PATH_THIRD.'zoo_triggers/config.php';
require_once PATH_THIRD.'zoo_triggers/helper.php';

/**
 * Zoo Triggers Control Panel Class
 *
 * @package   Zoo Triggers
 * @author    ExpressionEngine Zoo <info@eezoo.com>
 * @copyright Copyright (c) 2011 ExpressionEngine Zoo (http://eezoo.com)
 */
class Zoo_triggers_mcp
{
	var $module_name = ZOO_TRIGGERS_NAME;
	var $class_name = ZOO_TRIGGERS_CLASS;
	var $settings = null;

	/**
	 * Control Panel Constructor
	 */
	function __construct()
	{
		// Variables
		$this->helper = new Zoo_triggers_helper();
		$this->base = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.$this->class_name;
		$this->form_base = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.$this->class_name;

		// Load settings
		$extension_settings = ee()->db->get_where('extensions', array('class' => $this->class_name .'_ext', 'hook' => 'sessions_start'), 1)->row();
		$this->settings = unserialize($extension_settings->settings);
	}

	// --------------------------------------------------------------------

	function index()
	{
		// Variables
		$vars = array();
		$vars['settings'] = $this->settings;

		// Check settings
		$vars['show_tag_settings'] = $this->helper->is_installed('Tagger') || $this->helper->is_installed('Tag') ? true : false;

		// Load view
		return $this->_content_wrapper('index', 'index_title', $vars);
	}

	function index_save()
	{
		// Data
		$data = array();
		$data['category_triggers'] = ee()->input->post('category_triggers');
		$this->settings['settings']['entries_operator'] = ee()->input->post('category_operator');
		$this->settings['settings']['entries_title_categories_prefix'] = ee()->input->post('category_prefix');
		$this->settings['settings']['entries_title_categories_separator'] = ee()->input->post('category_separator');
		$this->settings['settings']['entries_title_categories_separator_last'] = ee()->input->post('category_separator_last');
		$this->settings['settings']['entries_title_categories_postfix'] = ee()->input->post('category_postfix');

		$data['archive_triggers'] = ee()->input->post('archive_triggers');
		$this->settings['settings']['entries_title_archives_year'] = ee()->input->post('archive_year');
		$this->settings['settings']['entries_title_archives_month'] = ee()->input->post('archive_month');
		$this->settings['settings']['entries_title_archives_prefix'] = ee()->input->post('archive_prefix');
		$this->settings['settings']['entries_title_archives_separator'] = ee()->input->post('archive_separator');
		$this->settings['settings']['entries_title_archives_postfix'] = ee()->input->post('archive_postfix');

		$data['tag_triggers'] = ee()->input->post('tag_triggers');
		$this->settings['settings']['entries_title_tag_prefix'] = ee()->input->post('tag_prefix');
		$this->settings['settings']['entries_title_tag_separator'] = ee()->input->post('tag_separator');
		$this->settings['settings']['entries_title_tag_separator_last'] = ee()->input->post('tag_separator_last');
		$this->settings['settings']['entries_title_tag_postfix'] = ee()->input->post('tag_postfix');
		$this->settings['settings']['entries_title_tag_websafe_separator'] = ee()->input->post('tag_websafe_separator');

		$data['author_triggers'] = ee()->input->post('author_triggers');
		$this->settings['settings']['entries_title_author_prefix'] = ee()->input->post('author_prefix');
		$this->settings['settings']['entries_title_author_separator'] = ee()->input->post('author_separator');
		$this->settings['settings']['entries_title_author_separator_last'] = ee()->input->post('author_separator_last');
		$this->settings['settings']['entries_title_author_postfix'] = ee()->input->post('author_postfix');

		// Data
		$this->settings['triggers']['category'] = explode(",", ((!empty($data['category_triggers'])) ? $data['category_triggers'] : "category"));
		$this->settings['triggers']['archive'] = explode(",", ((!empty($data['archive_triggers'])) ? $data['archive_triggers'] : "archive"));
		$this->settings['triggers']['tag'] = explode(",", ((!empty($data['tag_triggers'])) ? $data['tag_triggers'] : "tag"));
		$this->settings['triggers']['author'] = explode(",", ((!empty($data['author_triggers'])) ? $data['author_triggers'] : "author"));

		// Save settings
		ee()->db->where(array('class' => $this->class_name .'_ext', 'hook' => 'sessions_start'))
		             ->update('extensions', array('settings' => serialize($this->settings)));

		// Redirect
		ee()->session->set_flashdata('message_success', lang('index_save_success'));
		ee()->functions->redirect($this->base.AMP.'method=index');
	}

	// --------------------------------------------------------------------

	private function _content_wrapper($content_view, $lang_key, $vars = array())
	{
		$vars['content_view'] = $content_view;
		$vars['base'] = $this->base;
		$vars['form_base'] = $this->form_base;


		ee()->view->cp_page_title = lang($lang_key);
		ee()->cp->set_breadcrumb($this->base, lang('zoo_triggers_module_name'));

		ee()->load->library('table');


		return ee()->load->view($vars['content_view'], $vars, TRUE);
	}
}