<?php

if (!defined('BASEPATH')) exit('Invalid file request');
require_once PATH_THIRD.'zoo_triggers/config.php';
require_once PATH_THIRD.'zoo_triggers/helper.php';

/**
 * Zoo Triggers Class
 *
 * @package   Zoo Triggers
 * @author    ExpressionEngine Zoo <info@eezoo.com>
 * @copyright Copyright (c) 2011 ExpressionEngine Zoo (http://eezoo.com)
 */
class Zoo_triggers
{
	var $return_data;

	/**
	 * Module Constructor
	 */
	function __construct()
	{

		$this->helper = new Zoo_triggers_helper();

		$this->archive = new stdClass();
		$this->categories = new stdClass();

		return false;
	}

	function archive()
	{
		// Get tag attributes and vars
		$this->archive->results = null;
		$this->archive->results_nested = array();
		$this->archive->output = null;
		$this->archive->attrChannel = (ee()->TMPL->fetch_param('channel')) ? explode('|', ee()->TMPL->fetch_param('channel')) : ee()->TMPL->fetch_param('channel');
		$this->archive->attrCssId = ee()->TMPL->fetch_param('css_id', "list-archive");
		$this->archive->attrCssYears = ee()->TMPL->fetch_param('css_years', "item-year");
		$this->archive->attrCssMonths = ee()->TMPL->fetch_param('css_months', "item-month");
		$this->archive->attrCssActive = ee()->TMPL->fetch_param('css_active', "active");
		$this->archive->attrMonth = ee()->TMPL->fetch_param('month', "long"); // Options: long, short
		$this->archive->attrPath = ee()->TMPL->fetch_param('path', ee()->uri->uri_string . '/archive');
		$this->archive->attrShowCounter = ee()->TMPL->fetch_param('show_counter', "yes"); // Options: yes, no
		$this->archive->attrShowLink = ee()->TMPL->fetch_param('show_link', "yes"); // Options: yes, no
		$this->archive->attrShowUl = ee()->TMPL->fetch_param('show_ul', "yes");
		$this->archive->attrShowAll = ee()->TMPL->fetch_param('show_all', "no");
		$this->archive->attrAllText = ee()->TMPL->fetch_param('all_text', "View all");
		$this->archive->attrAllPath = ee()->TMPL->fetch_param('all_path', ee()->uri->uri_string);
		$this->archive->attrTextPrefix = ee()->TMPL->fetch_param('text_prefix', "");
		$this->archive->attrTextPostfix = ee()->TMPL->fetch_param('text_postfix', "");
		$this->archive->attrStatus = explode('|', ee()->TMPL->fetch_param('status', 'open'));
		$this->archive->attrStyle = ee()->TMPL->fetch_param('style', 'nested'); // Options: list, nested
		$this->archive->attrYear = ee()->TMPL->fetch_param('year', "long"); // Options: long, short
		$this->archive->attrShowFutureEntries = ee()->TMPL->fetch_param('show_future_entries', "yes"); // Options: yes, no
		$this->archive->attrShowExpired = ee()->TMPL->fetch_param('show_expired', "no"); // Options: yes, no
		$this->archive->attrType = ee()->TMPL->fetch_param('type', "monthly"); // Options: monthly, yearly

		if(strpos($this->archive->attrPath, "/") != 0 && !substr_compare('http', $this->archive->attrPath, 0, 4, true))
			$this->archive->attrPath = '/' . $this->archive->attrPath;
		if(strpos($this->archive->attrAllPath, "/") != 0 && !substr_compare('http', $this->archive->attrPath, 0, 4, true))
			$this->archive->attrAllPath = '/' . $this->archive->attrAllPath;

		// Build Query
		ee()->db->select('ct.year, ct.month, COUNT(title) as count')
					 ->from('exp_channel_titles ct');

			// Filter channels
			if($this->archive->attrChannel)
			{
				ee()->db->join('exp_channels ch', 'ch.channel_id = ct.channel_id', 'left')
							 ->where_in('ch.channel_name', $this->archive->attrChannel);
			}

			$timestamp = (ee()->TMPL->cache_timestamp != '') ? ee()->TMPL->cache_timestamp : ee()->localize->now;

			if($this->archive->attrShowFutureEntries != "yes")
				ee()->db->where('ct.entry_date <', $timestamp);

			if($this->archive->attrShowExpired != "yes")
				ee()->db->where('(ct.expiration_date > ' . $timestamp . ' OR ct.expiration_date IS NULL OR ct.expiration_date = 0)');

			// Filter status
			ee()->db->where_in('ct.status', $this->archive->attrStatus);

			//group-> monthly - yearly

			if($this->archive->attrType == "yearly")
			{
				ee()->db->group_by('year')->order_by('year desc');
			}
			else
			{
				ee()->db->group_by('month, year')->order_by('year desc, month desc');
			}
			// Execute Query
			$this->archive->results = ee()->db->get()->result();

		// Check for style and build output
		if($this->archive->attrStyle == "nested" && $this->archive->attrType == "monthly")
		{
			$years = array_values(array_unique($this->helper->simplify_array($this->archive->results, "year")));

			$this->archive->output .= $this->archive->attrShowUl == "yes" ? '<ul' . (empty($this->archive->attrCssId) ? '' : ' id="' . $this->archive->attrCssId . '"') . '>' : '';
			foreach($years as $year_key => $yearitem)
			{
				$link_text = lang(date(($this->archive->attrYear == "long" ? "Y" : "'y"), mktime(0, 0, 0, 1, 1, $yearitem)));
				$link = $yearitem;

				// Get months for this year
				$year_total = 0;
				$months = array();
				foreach($this->archive->results as $result)
				{
					if($result->year == $yearitem)
					{
						$year_total += $result->count;
						array_push($months, $result);
					}
				}

				// Print it
				if(!empty($months))
				{
					$class = ($year_key == 0 ? 'first ' : '') . ($year_key == count($years) - 1 && $this->archive->attrShowAll != "yes" ? 'last ' : '') . ($this->helper->in_url($yearitem) ? $this->archive->attrCssActive . ' ' : '') . (empty($this->archive->attrCssYears) ? '' : $this->archive->attrCssYears . ' ');
					$this->archive->output .= '<li' . ((empty($class)) ? '' : ' class="' . trim($class) . '"') . '>' . (($this->archive->attrShowLink == "yes") ? '<a href="' . $this->archive->attrPath . '/' . $link . '">' : '') . trim($this->archive->attrTextPrefix . " " .  $link_text . " " .  $this->archive->attrTextPostfix) . (($this->archive->attrShowLink == "yes") ? '</a>' : '') . (($this->archive->attrShowCounter == "yes") ? ' (' . $year_total . ')' : '');

						$this->archive->output .= '<ul>';
						foreach($months as $month_key => $monthitem)
						{
							$link_text = lang(date(($this->archive->attrMonth == "long" ? "F" : "M"), mktime(0, 0, 0, $monthitem->month, 1, $yearitem)));
							$link = $yearitem . '/' . $monthitem->month;

							$class = ($month_key == 0 ? 'first ' : '') . ($month_key == count($months) - 1 ? 'last ' : '') . (($this->helper->in_url($monthitem->month) && $this->helper->in_url($yearitem)) ? $this->archive->attrCssActive . ' ' : '') . (empty($this->archive->attrCssMonths) ? '' : $this->archive->attrCssMonths . ' ');
							$this->archive->output .= '<li' . ((empty($class)) ? '' : ' class="' . trim($class) . '"') . '>' . (($this->archive->attrShowLink == "yes") ? '<a href="' . $this->archive->attrPath . '/' . $link . '">' : '') . trim($this->archive->attrTextPrefix . " " .  $link_text . " " .  $this->archive->attrTextPostfix) . (($this->archive->attrShowLink == "yes") ? '</a>' : '') . (($this->archive->attrShowCounter == "yes") ? ' (' . $monthitem->count . ')' : '');
						}
						$this->archive->output .= '</ul>';

					$this->archive->output .= '</li>';
				}
			}
			$this->archive->output .= $this->archive->attrShowAll == "yes" ? '<li class="last item-all"><a href="' . $this->archive->attrAllPath . '/">'. $this->archive->attrAllText .'</a></li>' : '';
			$this->archive->output .= $this->archive->attrShowUl == "yes" ? '</ul>' : '';
		}
		else // List
		{
			$this->archive->output .= $this->archive->attrShowUl == "yes" ? '<ul' . (empty($this->archive->attrCssId) ? '' : ' id="' . $this->archive->attrCssId . '"') . '>' : '';
			foreach($this->archive->results as $key => $archive)
			{
				$month = lang(date(($this->archive->attrMonth == "long" ? "F" : "M"), mktime(0, 0, 0, $archive->month, 1, $archive->year)));
				$year = lang(date(($this->archive->attrYear == "long" ? "Y" : "'y"), mktime(0, 0, 0, 1, 1, $archive->year)));

				$link_text = ($this->archive->attrType == "yearly") ? $year : $month . ' ' . $year;
				$link = ($this->archive->attrType == "yearly") ? $archive->year : $archive->year . '/' . $archive->month ;

				$class = ($key == 0 ? 'first ' : '') . ($key == count($this->archive->results) - 1 ? 'last ' : '') . (((($this->helper->in_url($archive->month) && $this->archive->attrType == "monthly") || $this->archive->attrType == "yearly") && $this->helper->in_url($archive->year)) ? $this->archive->attrCssActive . ' ' : '');
				$this->archive->output .= '<li' . ((empty($class)) ? '' : ' class="' . trim($class) . '"') . '>' . (($this->archive->attrShowLink == "yes") ? '<a href="' . $this->archive->attrPath . '/' . $link . '">' : '') . trim($this->archive->attrTextPrefix . " " .  $link_text . " " .  $this->archive->attrTextPostfix) . (($this->archive->attrShowLink == "yes") ? '</a>' : '') . (($this->archive->attrShowCounter == "yes") ? ' (' . $archive->count . ')' : '');
				$this->archive->output .= '</li>';
			}
			$this->archive->output .= $this->archive->attrShowAll == "yes" ? '<li class="last item-all"><a href="' . $this->archive->attrAllPath . '/">'. $this->archive->attrAllText .'</a></li>' : '';
			$this->archive->output .= $this->archive->attrShowUl == "yes" ? '</ul>' : '';
		}

		return $this->archive->output;
	}

	function categories()
	{
		// Get tag attributes and vars
		$this->categories->results = null;
		$this->categories->results_nested = array();
		$this->categories->output = null;
		$this->categories->attrChannel = (ee()->TMPL->fetch_param('channel')) ? explode('|', ee()->TMPL->fetch_param('channel')) : ee()->TMPL->fetch_param('channel');
		$this->categories->attrCssId = ee()->TMPL->fetch_param('css_id', "list-categories");
		$this->categories->attrCatGroupId = ee()->TMPL->fetch_param('cat_group_id', "all");
		$this->categories->attrCssActive = ee()->TMPL->fetch_param('css_active', "active");
		$this->categories->attrCssActiveTrail = ee()->TMPL->fetch_param('css_active_trail', "active-trail");
		$this->categories->attrPath = ee()->TMPL->fetch_param('path', ee()->uri->uri_string . '/category');
		$this->categories->attrShowChildren = ee()->TMPL->fetch_param('show_children', "yes");
		$this->categories->attrShowCounter = ee()->TMPL->fetch_param('show_counter', "yes");
		$this->categories->attrShowEmpty = ee()->TMPL->fetch_param('show_empty', "no");
		$this->categories->attrShowLink = ee()->TMPL->fetch_param('show_link', "yes");
		$this->categories->attrShowUl = ee()->TMPL->fetch_param('show_ul', "yes");
		$this->categories->attrShowAll = ee()->TMPL->fetch_param('show_all', "no");
		$this->categories->attrAllText = ee()->TMPL->fetch_param('all_text', "View all");
		$this->categories->attrAllPath = ee()->TMPL->fetch_param('all_path', ee()->uri->uri_string);
		$this->categories->attrTextPrefix = ee()->TMPL->fetch_param('text_prefix', "");
		$this->categories->attrTextPostfix = ee()->TMPL->fetch_param('text_postfix', "");
		$this->categories->attrStatus = ee()->TMPL->fetch_param('status', false);
		$this->categories->attrStyle = ee()->TMPL->fetch_param('style', 'nested');
		$this->categories->attrStartOn = ee()->TMPL->fetch_param('start_on', "");
		$this->categories->attrShowFutureEntries = ee()->TMPL->fetch_param('show_future_entries', "no"); // Options: yes, no
		$this->categories->attrShowExpired = ee()->TMPL->fetch_param('show_expired', "no"); // Options: yes, no

		if(strpos($this->categories->attrPath, "/") != 0 && !substr_compare('http', $this->categories->attrPath, 0, 4, true))
			$this->categories->attrPath = '/' . $this->categories->attrPath;
		if(strpos($this->categories->attrAllPath, "/") != 0 && !substr_compare('http', $this->categories->attrAllPath, 0, 4, true))
			$this->categories->attrAllPath = '/' . $this->categories->attrAllPath;

		if($this->categories->attrCatGroupId != "all")
		{
			if(!strpos($this->categories->attrCatGroupId, '|'))
			{
				$this->categories->catgroups = $this->categories->attrCatGroupId;
			}
			else
			{
				$this->categories->catgroups = implode("','", explode('|', $this->categories->attrCatGroupId));
			}
		}
		else
		{
			//get all category groups
			$this->categories->catgroups = array_filter(array_unique(explode('|', implode('|', $this->helper->simplify_array(ee()->db->select('cat_group')->where_in('channel_name', $this->categories->attrChannel)->get('channels')->result())))));
		}

		// Be gone when there are no catgroups
		if(empty($this->categories->catgroups))
			return false;

		// Build Query
		ee()->db->select('c.cat_id, count(DISTINCT cp.entry_id) as cat_count, c.cat_name, c.cat_url_title, c.parent_id')
					 ->from('exp_categories c, exp_channels ch')
					 ->join('exp_category_posts cp', 'cp.cat_id = c.cat_id', 'left')
					 ->join('exp_channel_titles ct', 'ct.entry_id = cp.entry_id', 'left')
					 //->join('exp_channels ch', 'ch.cat_group = c.group_id', 'left')
					 ->where_in("c.group_id", $this->categories->catgroups);
		if($this->categories->attrStartOn != '')
			ee()->db->where('ct.entry_date >=', ee()->localize->convert_human_date_to_gmt($this->categories->attrStartOn));
		ee()->db->order_by("cat_order");

			$timestamp = (ee()->TMPL->cache_timestamp != '') ? ee()->TMPL->cache_timestamp : ee()->localize->now;

			if($this->categories->attrShowFutureEntries != "yes")
				ee()->db->where('(ct.entry_date < ' . $timestamp . ' OR ct.entry_date IS NULL)');

			if($this->categories->attrShowExpired != "yes")
				ee()->db->where('(ct.expiration_date > ' . $timestamp . ' OR ct.expiration_date IS NULL OR ct.expiration_date = 0)');

			// Filter children
			if($this->categories->attrShowChildren == "no")
			{
				ee()->db->where('c.parent_id', 0);
			}

			// Filter status
			if(!empty($this->categories->attrStatus))
				$this->categories->attrStatus = explode("|", $this->categories->attrStatus);

			//if($this->categories->attrStatus !== false && $this->categories->attrShowEmpty != "yes")
			//	ee()->db->where_in('ct.status', $this->categories->attrStatus);
			//elseif($this->categories->attrStatus !== false && $this->categories->attrShowEmpty == "yes")
			//	ee()->db->where('(ct.status IN ("' . implode('","', $this->categories->attrStatus) . '") OR ct.status IS NULL)');
			//elseif($this->categories->attrStatus === false && $this->categories->attrShowEmpty != "yes")
			//	ee()->db->where('(ct.status != "closed" OR ct.status IS NOT NULL)');
			//elseif($this->categories->attrStatus === false && $this->categories->attrShowEmpty == "yes")
			//	ee()->db->where('(ct.status != "closed" OR ct.status IS NULL)');

			if($this->categories->attrStatus !== false && $this->categories->attrShowEmpty != "yes")
				ee()->db->where_in('ct.status', $this->categories->attrStatus);
			elseif($this->categories->attrStatus !== false && $this->categories->attrShowEmpty == "yes")
				ee()->db->where('(ct.status IN ("' . implode('","', $this->categories->attrStatus) . '") OR ct.status IS NULL)');

			// Filter channels
			if($this->categories->attrChannel)
			{
				ee()->db->where_in('ch.channel_name', $this->categories->attrChannel);
				if($this->categories->attrShowEmpty == 'no')
					ee()->db->where('ch.channel_id = ct.channel_id');
			}

			// Execute Query
			$this->categories->results = ee()->db->group_by("c.cat_id")->get()->result();


		// Check for style
		if($this->categories->attrStyle == "nested")
		{
			foreach($this->categories->results as $key => $category)
			{
				if(!empty($category->parent_id))
				{
					if(!isset($this->categories->results_nested[$category->parent_id]))
						$this->categories->results_nested[$category->parent_id] = array();
					array_push($this->categories->results_nested[$category->parent_id], $category);
					unset($this->categories->results[$key]);
				}
			}
		}

		// Build Output
		$this->categories->output .= $this->categories->attrShowUl == "yes" ? '<ul' . (empty($this->categories->attrCssId) ? '' : ' id="' . $this->categories->attrCssId . '"') . '>' : '';
		$this->categories->count = 0;
		foreach($this->categories->results as $key => $category)
		{
			$class = ($this->categories->count == 0 ? 'first ' : '') . ($this->categories->count == count($this->categories->results) - 1  && $this->categories->attrShowAll != "yes" ? 'last ' : '') . (($this->helper->in_url($category->cat_url_title)) ? $this->categories->attrCssActive . ' ' : '') . (($this->helper->in_url($this->helper->get_child_categories($category->cat_id))) ? $this->categories->attrCssActiveTrail . ' ' : '');
			$this->categories->output .= '<li' . ((empty($class)) ? '' : ' class="' . trim($class) . '"') . '>' . (($this->categories->attrShowLink == "yes") ? '<a href="' . $this->categories->attrPath . '/' . $category->cat_url_title . '">' : '') . trim($this->categories->attrTextPrefix . " " . $category->cat_name . " " .  $this->categories->attrTextPostfix) . (($this->categories->attrShowLink == "yes") ? '</a>' : '') . (($this->categories->attrShowCounter == "yes") ? ' (' . $category->cat_count . ')' : '');
			$this->categories_nested($category->cat_id);
			$this->categories->output .= '</li>';
			$this->categories->count++;
		}
		$this->categories->output .= $this->categories->attrShowAll == "yes" ? '<li class="last item-all"><a href="' . $this->categories->attrAllPath . '">'. $this->categories->attrAllText .'</a></li>' : '';
		$this->categories->output .= $this->categories->attrShowUl == "yes" ? '</ul>' : '';

		return $this->categories->output;
	}

	function authors()
	{
		// Get tag attributes and vars
		$this->authors->results = null;
		$this->authors->results_nested = array();
		$this->authors->output = null;
		$this->authors->attrChannel = (ee()->TMPL->fetch_param('channel')) ? explode('|', ee()->TMPL->fetch_param('channel')) : ee()->TMPL->fetch_param('channel');
		$this->authors->attrCssId = ee()->TMPL->fetch_param('css_id', "list-categories");
		$this->authors->attrCssActive = ee()->TMPL->fetch_param('css_active', "active");
		$this->authors->attrPath = ee()->TMPL->fetch_param('path', ee()->uri->uri_string . '/category');
		$this->authors->attrShowChildren = ee()->TMPL->fetch_param('show_children', "yes");
		$this->authors->attrShowCounter = ee()->TMPL->fetch_param('show_counter', "yes");
		$this->authors->attrShowEmpty = ee()->TMPL->fetch_param('show_empty', "no");
		$this->authors->attrShowLink = ee()->TMPL->fetch_param('show_link', "yes");
		$this->authors->attrShowUl = ee()->TMPL->fetch_param('show_ul', "yes");
		$this->authors->attrShowAll = ee()->TMPL->fetch_param('show_all', "no");
		$this->authors->attrAllText = ee()->TMPL->fetch_param('all_text', "View all");
		$this->authors->attrAllPath = ee()->TMPL->fetch_param('all_path', ee()->uri->uri_string);
		$this->authors->attrTextPrefix = ee()->TMPL->fetch_param('text_prefix', "");
		$this->authors->attrTextPostfix = ee()->TMPL->fetch_param('text_postfix', "");
		$this->authors->attrStatus = ee()->TMPL->fetch_param('status', false);
		$this->authors->attrShowFutureEntries = ee()->TMPL->fetch_param('show_future_entries', "no"); // Options: yes, no
		$this->authors->attrShowExpired = ee()->TMPL->fetch_param('show_expired', "no"); // Options: yes, no

		if(strpos($this->authors->attrPath, "/") != 0 && !substr_compare('http', $this->authors->attrPath, 0, 4, true))
			$this->authors->attrPath = $this->authors->attrPath;
		if(strpos($this->authors->attrAllPath, "/") != 0 && !substr_compare('http', $this->authors->attrPath, 0, 4, true))
			$this->authors->attrAllPath = '/' . $this->authors->attrAllPath;

		// Build Query
		ee()->db->select('m.member_id, m.username, m.screen_name, COUNT(DISTINCT ct.entry_id) as author_count')
					 ->from('exp_members m')
					 ->join('exp_channel_titles ct', 'ct.author_id = m.member_id', 'left')
					 ->join('exp_channels ch', 'ch.channel_id = ct.channel_id', 'left')
					 ->order_by("m.screen_name");

			$timestamp = (ee()->TMPL->cache_timestamp != '') ? ee()->TMPL->cache_timestamp : ee()->localize->now;

			if($this->authors->attrShowFutureEntries != "yes")
				ee()->db->where('(ct.entry_date < ' . $timestamp . ' OR ct.entry_date IS NULL)');

			if($this->authors->attrShowExpired != "yes")
				ee()->db->where('(ct.expiration_date > ' . $timestamp . ' OR ct.expiration_date IS NULL OR ct.expiration_date = 0)');

			// Filter status
			if(!empty($this->authors->attrStatus))
				$this->authors->attrStatus = explode("|", $this->authors->attrStatus);

			if($this->authors->attrStatus !== false && $this->authors->attrShowEmpty != "yes")
				ee()->db->where_in('ct.status', $this->authors->attrStatus);
			elseif($this->authors->attrStatus !== false && $this->authors->attrShowEmpty == "yes")
				ee()->db->where('(ct.status IN ("' . implode('","', $this->authors->attrStatus) . '") OR ct.status IS NULL)');

			// Filter channels
			if($this->authors->attrChannel)
			{
				ee()->db->where_in('ch.channel_name', $this->authors->attrChannel);

			}

			if($this->authors->attrShowEmpty == 'no')
					ee()->db->where('m.member_id = ct.author_id');

			// Execute Query
			$this->authors->results = ee()->db->group_by("m.member_id")->get()->result();

		// Build Output
		$this->authors->output .= $this->authors->attrShowUl == "yes" ? '<ul' . (empty($this->authors->attrCssId) ? '' : ' id="' . $this->authors->attrCssId . '"') . '>' : '';
		$this->authors->count = 0;
		foreach($this->authors->results as $key => $author)
		{
			$class = ($this->authors->count == 0 ? 'first ' : '') . ($this->authors->count == count($this->authors->results) - 1  && $this->authors->attrShowAll != "yes" ? 'last ' : '') . (($this->helper->in_url($author->username)) ? $this->authors->attrCssActive . ' ' : '');
			$this->authors->output .= '<li' . ((empty($class)) ? '' : ' class="' . trim($class) . '"') . '>' . (($this->authors->attrShowLink == "yes") ? '<a href="' . $this->authors->attrPath . '/' . $author->username . '">' : '') . trim($this->authors->attrTextPrefix . " " . $author->screen_name . " " .  $this->authors->attrTextPostfix) . (($this->authors->attrShowLink == "yes") ? '</a>' : '') . (($this->authors->attrShowCounter == "yes") ? ' (' . $author->author_count . ')' : '');
			$this->authors->output .= '</li>';
			$this->authors->count++;
		}
		$this->authors->output .= $this->authors->attrShowAll == "yes" ? '<li class="last item-all"><a href="' . $this->authors->attrAllPath . '">'. $this->authors->attrAllText .'</a></li>' : '';
		$this->authors->output .= $this->authors->attrShowUl == "yes" ? '</ul>' : '';

		return $this->authors->output;
	}

	private function categories_nested($parent_id)
	{
		if(!empty($this->categories->results_nested[$parent_id]))
		{
			$this->categories->output .= '<ul>';
			$this->categories->nestedcount = 0;
			foreach($this->categories->results_nested[$parent_id] as $key => $category)
			{
				$class = ($this->categories->nestedcount == 0 ? 'first ' : '') . ($this->categories->nestedcount == count($this->categories->results_nested[$parent_id]) - 1 ? 'last ' : '') . (($this->helper->in_url($category->cat_url_title)) ? $this->categories->attrCssActive . ' ' : '') . (($this->helper->in_url($this->helper->get_child_categories($category->cat_id))) ? $this->categories->attrCssActiveTrail . ' ' : '');
				$this->categories->output .= '<li' . ((empty($class)) ? '' : ' class="' . trim($class) . '"') . '>' . (($this->categories->attrShowLink == "yes") ? '<a href="' . $this->categories->attrPath . '/' . $category->cat_url_title . '">' : '') . trim($this->categories->attrTextPrefix . " " .  $category->cat_name . " " .  $this->categories->attrTextPostfix) . (($this->categories->attrShowLink == "yes") ? '</a>' : '') . (($this->categories->attrShowCounter == "yes") ? ' (' . $category->cat_count . ')' : '');
				$this->categories_nested($category->cat_id);
				$this->categories->output .= '</li>';
				$this->categories->nestedcount++;
			}
			$this->categories->output .= '</ul>';
		}
	}
}