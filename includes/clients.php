<?php

add_action('init', 'mwta_clients_register_post_types');

function mwta_clients_register_post_types(){
    
    $clients_args = array(
        'public' => true,
        'query_var' => 'clients',
        'show_in_menu' => false,
        'rewrite' => array(
            'slug' => 'clients',
            'with_front' => false
        ),
        'show_in_rest' => true,
        'supports' => array(''),
        'labels' => array(
            'name' => 'Clients',
            'singular_name' => 'Client',
            'add_new' => 'Add New Client',
            'add_new_item' => 'Add New Client',
            'edit_item' => 'Edit Client',
            'new_item' => 'New Client',
            'view_item' => 'View Client',
            'search_items' => 'Search Clients',
            'not_found' => 'No Client found',
            'not_found_in_trash' => 'No Client found in Trash'
        ),
        'menu_icon' => 'dashicons-businessman'
    );
    register_post_type('clients',$clients_args);
}

add_filter('manage_edit-clients_columns', 'mwta_clients_column_headers');
add_filter('manage_clients_posts_custom_column','mwta_clients_column_data', 1,2);
add_filter('admin_head-edit.php','mwta_register_custom_clients_titles');

function mwta_clients_column_headers($columns){
    $columns = array(
        'cb' => '<input type="checkbox">',
        'title' => __('Clients Name'),
        'shortcut' => __('Shortcut'),
        'monthly_fee' => __('Monthly Fee')
    );
    return $columns;
}

function mwta_clients_column_data($column, $post_id){
    $output = '';
    $currency = get_option('mwta_currency_option');
    
    switch($column){
        case 'title':
            $name = get_field('name', $post_id);
            $output .= $name;
            break;
        case 'shortcut':
            $shortcut = get_field('shortcut',$post_id);
            $output .= $shortcut;
            break;
        case 'monthly_fee':
            $fee = get_field('monthly_fee',$post_id);
            $output .= number_format($fee,2,',','.') . ' ' . $currency;
            break;
    }
    echo $output;
}

function mwta_register_custom_clients_titles(){
    add_filter(
        'the_title',
        'mwta_clients_custom_admin_titles',
        99,
        2
    );
}

function mwta_clients_custom_admin_titles($title,$post_id){
    global $post;
    $output = $title;
    if(isset($post->post_type)){
        switch($post->post_type){
            case 'clients':
                $name = get_field('name',$post_id);
                $output = $name;
                break;
        }
    }
    return $output;
}

add_filter('acf/fields/post_object/result','my_acf_post_object_result',10,4);

function my_acf_post_object_result($text,$post,$field,$post_id){
    if($post->post_type == 'clients'){
        $text = $post->name;  
    }
    return $text;
}

?>