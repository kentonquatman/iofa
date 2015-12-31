<?php

require_once PATH_THIRD.'zoo_triggers/config.php';

$lang = array(
// -------------------------------------------
//  Module CP
// -------------------------------------------

'zoo_triggers_module_name' => ZOO_TRIGGERS_NAME,
'zoo_triggers_module_description' => ZOO_TRIGGERS_DESC,

// -------------------------------------------
//  Settings
// -------------------------------------------

'index_title' => 'Settings',

'index_categories_title_table' => 'Categories',
'index_archive_title_table' => 'Archives',
'index_tag_title_table' => 'Tags',
'index_author_title_table' => 'Authors',

'index_categories_label_trigger' => 'Trigger keywords (seperate keywords with comma)',
'index_categories_label_operator' => 'Combining multiple categories',
'index_categories_label_prefix' => '{trigger:entries} Prefix',
'index_categories_label_separator' => '{trigger:entries} Separator',
'index_categories_label_separator_last' => '{trigger:entries} Last separator',
'index_categories_label_postfix' => '{trigger:entries} Postfix',

'index_categories_option_operator_and' => 'AND',
'index_categories_option_operator_or' => 'OR',

'index_archives_label_trigger' => 'Trigger keywords (seperate keywords with comma)',
'index_archives_label_year' => 'Year notation',
'index_archives_label_month' => 'Month notation',
'index_archives_label_prefix' => '{trigger:entries} Prefix',
'index_archives_label_separator' => '{trigger:entries} Separator',
'index_archives_label_postfix' => '{trigger:entries} Postfix',

'index_archives_option_year_2' => 'A two digit representation of a year',
'index_archives_option_year_4' => 'A full numeric representation of a year, 4 digits',
'index_archives_option_month_long' => 'A full textual representation of a month, such as January or March',
'index_archives_option_month_zeros' => 'Numeric representation of a month, with leading zeros',
'index_archives_option_month_short' => 'A short textual representation of a month, three letters',
'index_archives_option_month_leading' => 'Numeric representation of a month, without leading zeros',

'index_tag_label_trigger' => 'Trigger keywords (seperate keywords with comma)',
'index_tag_label_operator' => 'Combining multiple categories',
'index_tag_label_prefix' => '{trigger:entries} Prefix',
'index_tag_label_separator' => '{trigger:entries} Separator',
'index_tag_label_separator_last' => '{trigger:entries} Last separator',
'index_tag_label_postfix' => '{trigger:entries} Postfix',
'index_tag_websafe_separator' => 'Websafe seperator used by Tag',

'index_author_label_trigger' => 'Author keywords (seperate keywords with comma)',
'index_author_label_operator' => 'Combining multiple authors',
'index_author_label_prefix' => '{trigger:entries} Prefix',
'index_author_label_separator' => '{trigger:entries} Separator',
'index_author_label_separator_last' => '{trigger:entries} Last separator',
'index_author_label_postfix' => '{trigger:entries} Postfix',

'index_button_save' => 'Save settings'
);