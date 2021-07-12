<?php

define('WTA_ACF_PATH', plugin_dir_path(__DIR__) . 'lib/advanced-custom-fields/');
define('WTA_ACF_URL', plugin_dir_path(__DIR__) . 'lib/advanced-custom-fields/');

$show_acf_admin = false;

if(class_exists('ACF')){
    $show_acf_admin = true;
}

include_once(WTA_ACF_PATH . 'acf.php');

add_filter('acf/settings/url', 'acf_settings_url');
add_filter('acf/settings/show_admin','acf_show_admin');

add_action('views_edit-employees','older_acf_warning');
add_action('views_edit-jobs','older_acf_warning');
add_action('views_edit-occupations','older_acf_warning');
add_action('views_edit-clients','older_acf_warning');

function acf_settings_url($url){
    return WTA_ACF_URL;
}

function acf_show_admin($show_admin){
    global $show_acf_admin;
    return $show_acf_admin;
    //return true;
}

function older_acf_warning($views){
    global $acf;
    $acf_version = (float)$acf->settings['version'];
    $acf_version_required = 5.8;
    
    if($acf_version < $acf_version_required){
        echo '<p> You are using an older version ' . $acf_version . ' of the Advanced Custom Fields Plugin. </p>';
    }
    
    return $views;
}

include_once(plugin_dir_path(__DIR__) . '/cpt/clients-acf.php');
include_once(plugin_dir_path(__DIR__) . '/cpt/employees-acf.php');
include_once(plugin_dir_path(__DIR__) . '/cpt/jobs-acf.php');
include_once(plugin_dir_path(__DIR__) . '/cpt/occupations-acf.php');

?>