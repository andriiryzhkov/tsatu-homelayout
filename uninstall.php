<?php

/* 
 * Uninstall TSATU Homelayout plugin
 */

if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') ) {
    exit();
}

// Removing plugin options
delete_option('tsatu_show_widget_areas');
delete_option('tsatu_page_content');

for ($wa = 1; $wa <= 5; $wa++) {
    delete_option('tsatu_columns_' . $wa);
    for ($cl = 1; $cl <= 6; $cl++) {
        delete_option('tsatu_home_area_' . $wa . '_' . $cl);
    }
}