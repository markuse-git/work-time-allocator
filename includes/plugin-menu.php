<?php

include('dashboard-admin-page.php');
include('options-admin-page.php');

add_action('admin_menu','mwta_create_menu');

function mwta_create_menu(){
    
    add_menu_page(
        '',
        'WTA',
        'manage_options',
        'mwta_dashboard_admin_page',
        'mwta_dashboard_admin_page',
        'dashicons-randomize'
    );
    
    add_submenu_page(
        'mwta_dashboard_admin_page',
        '',
        'Info',
        'manage_options',
        'mwta_dashboard_admin_page',
        'mwta_dashboard_admin_page'
    );
    
    add_submenu_page(
        'mwta_dashboard_admin_page',
        '',
        'Occupations',
        'manage_options',
        'edit.php?post_type=occupations'
    );
    
    
    if(wp_get_current_user()->roles[0] == 'administrator'){
        add_submenu_page(
            'mwta_dashboard_admin_page',
            '',
            'Employees',
            'manage_options',
            'edit.php?post_type=employees'
        );
    }

    add_submenu_page(
        'mwta_dashboard_admin_page',
        '',
        'Clients',
        'manage_options',
        'edit.php?post_type=clients'
    );
    
    add_submenu_page(
        'mwta_dashboard_admin_page',
        '',
        'Jobs',
        'manage_options',
        'edit.php?post_type=jobs'
    );
    
    add_submenu_page(
        'mwta_dashboard_admin_page',
        '',
        'Options',
        'manage_options',
        'mwta_options_admin_page',
        'mwta_options_admin_page'
    );

}

?>