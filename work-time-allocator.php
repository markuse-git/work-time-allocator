<?php

/*
Plugin Name: Work Time Allocator
Description: Allocates working times to client jobs and generates reports
Version: 1.0
Author: Markus Eichelhardt
License: GLP2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

require __DIR__ . '/includes/employees.php';
require __DIR__ . '/includes/clients.php';
require __DIR__ . '/includes/jobs.php';
require __DIR__ . '/includes/occupations.php';
require __DIR__ . '/includes/timetracker.php';
require __DIR__ . '/includes/report.php';
require __DIR__ . '/includes/roles-caps.php';
require __DIR__ . '/includes/include-acf.php';
require __DIR__ . '/includes/plugin-menu.php';

define('ME_INSERT_JS', plugin_dir_url(__FILE__).'js');

add_action('wp_enqueue_scripts','mwta_plugin_files');

function mwta_plugin_files(){
    wp_enqueue_script('jobs_menu_js',ME_INSERT_JS.'/jobs-menu.js',array('jquery'),'',true);
    wp_enqueue_script('fields_and_alerts_js',ME_INSERT_JS.'/fields-and-alerts.js',array('jquery'),'',true);
    wp_enqueue_script('jquery-ui-datepicker');
}

add_action('admin_enqueue_scripts','mwta_admin_scripts');

function mwta_admin_scripts(){
    wp_register_script('wta-plugin-menu', plugins_url('/js/plugin-menu.js',__FILE__), array('jquery'),'',true);    
    wp_enqueue_script('wta-plugin-menu');
}

?>