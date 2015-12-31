<?php 

echo form_open($form_base.AMP.'method=index_save');

// Category Settings
$this->table->clear();
$this->table->set_template($cp_table_template);
$this->table->set_heading(array('colspan'=>4, 'data'=>lang('index_categories_title_table')));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_categories_label_trigger'), 'category_triggers')), form_input(array('name' => 'category_triggers', 'id' => 'category_triggers', 'value' => implode(',', $settings['triggers']['category']), 'class' => 'zoo-triggers-trigger')));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_categories_label_operator'), 'category_operator')), form_dropdown('category_operator', array('&' => lang('index_categories_option_operator_and'), '|' => lang('index_categories_option_operator_or')), $settings['settings']['entries_operator']));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_categories_label_prefix'), 'category_prefix')), form_input(array('name' => 'category_prefix', 'id' => 'category_prefix', 'value' => $settings['settings']['entries_title_categories_prefix'])));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_categories_label_separator'), 'category_separator')), form_input(array('name' => 'category_separator', 'id' => 'category_separator', 'value' => $settings['settings']['entries_title_categories_separator'])));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_categories_label_separator_last'), 'category_separator_last')), form_input(array('name' => 'category_separator_last', 'id' => 'category_separator_last', 'value' => $settings['settings']['entries_title_categories_separator_last'])));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_categories_label_postfix'), 'category_postfix')), form_input(array('name' => 'category_postfix', 'id' => 'category_postfix', 'value' => $settings['settings']['entries_title_categories_postfix'])));

echo $this->table->generate();

// Archive Settings
$this->table->clear();
$this->table->set_template($cp_table_template);
$this->table->set_heading(array('colspan'=>4, 'data'=>lang('index_archive_title_table')));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_archives_label_trigger'), 'archive_triggers')), form_input(array('name' => 'archive_triggers', 'id' => 'archive_triggers', 'value' => implode(',', $settings['triggers']['archive']), 'class' => 'zoo-triggers-trigger')));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_archives_label_year'), 'archive_year')), form_dropdown('archive_year', array('Y' => lang('index_archives_option_year_4'), 'y' => lang('index_archives_option_year_2')), $settings['settings']['entries_title_archives_year']));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_archives_label_month'), 'archive_month')), form_dropdown('archive_month', array('F' => lang('index_archives_option_month_long'), 'm' => lang('index_archives_option_month_zeros'), 'M' => lang('index_archives_option_month_short'), 'n' => lang('index_archives_option_month_leading')), $settings['settings']['entries_title_archives_month']));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_archives_label_prefix'), 'archive_prefix')), form_input(array('name' => 'archive_prefix', 'id' => 'archive_prefix', 'value' => $settings['settings']['entries_title_archives_prefix'])));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_archives_label_separator'), 'archive_separator')), form_input(array('name' => 'archive_separator', 'id' => 'archive_separator', 'value' => $settings['settings']['entries_title_archives_separator'])));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_archives_label_postfix'), 'archive_postfix')), form_input(array('name' => 'archive_postfix', 'id' => 'archive_postfix', 'value' => $settings['settings']['entries_title_archives_postfix'])));

echo $this->table->generate();

// Tag Settings
if($show_tag_settings):
	$this->table->clear();
	$this->table->set_template($cp_table_template);
	$this->table->set_heading(array('colspan'=>4, 'data'=>lang('index_tag_title_table')));
	$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_tag_label_trigger'), 'tag_triggers')), form_input(array('name' => 'tag_triggers', 'id' => 'tag_triggers', 'value' => implode(',', $settings['triggers']['tag']), 'class' => 'zoo-triggers-trigger')));
	$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_tag_label_prefix'), 'tag_prefix')), form_input(array('name' => 'tag_prefix', 'id' => 'tag_prefix', 'value' => $settings['settings']['entries_title_tag_prefix'])));
	$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_tag_label_separator'), 'tag_separator')), form_input(array('name' => 'tag_separator', 'id' => 'tag_separator', 'value' => $settings['settings']['entries_title_tag_separator'])));
	$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_tag_label_separator_last'), 'tag_separator_last')), form_input(array('name' => 'tag_separator_last', 'id' => 'tag_separator_last', 'value' => $settings['settings']['entries_title_tag_separator_last'])));
	$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_tag_label_postfix'), 'tag_postfix')), form_input(array('name' => 'tag_postfix', 'id' => 'tag_postfix', 'value' => $settings['settings']['entries_title_tag_postfix'])));
	$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_tag_websafe_separator'), 'tag_websafe_separator')), form_input(array('name' => 'tag_websafe_separator', 'id' => 'tag_websafe_separator', 'value' => $settings['settings']['entries_title_tag_websafe_separator'])));
	echo $this->table->generate();
endif;

// Auhtor Settings
$this->table->clear();
$this->table->set_template($cp_table_template);
$this->table->set_heading(array('colspan'=>4, 'data'=>lang('index_author_title_table')));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_author_label_trigger'), 'author_triggers')), form_input(array('name' => 'author_triggers', 'id' => 'author_triggers', 'value' => implode(',', $settings['triggers']['author']), 'class' => 'zoo-triggers-trigger')));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_author_label_prefix'), 'author_prefix')), form_input(array('name' => 'author_prefix', 'id' => 'author_prefix', 'value' => $settings['settings']['entries_title_author_prefix'])));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_author_label_separator'), 'author_separator')), form_input(array('name' => 'author_separator', 'id' => 'author_separator', 'value' => $settings['settings']['entries_title_author_separator'])));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_author_label_separator_last'), 'author_separator_last')), form_input(array('name' => 'author_separator_last', 'id' => 'author_separator_last', 'value' => $settings['settings']['entries_title_author_separator_last'])));
$this->table->add_row(array('width' => '35%', 'data' => form_label(lang('index_author_label_postfix'), 'author_postfix')), form_input(array('name' => 'author_postfix', 'id' => 'author_postfix', 'value' => $settings['settings']['entries_title_author_postfix'])));
echo $this->table->generate();

echo form_submit(array('name' => 'submit', 'value' => lang('index_button_save'), 'class' => 'submit'));
echo form_close();
?>