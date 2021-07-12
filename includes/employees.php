<?php

add_filter('manage_edit-employees_columns', 'mwta_employees_column_headers');
add_filter('manage_employees_posts_custom_column','mwta_employees_column_data', 1,2);
add_filter('admin_head-edit.php','mwta_register_custom_admin_titles');

function mwta_employees_column_headers($columns){
    $columns = array(
        'cb' => '<input type="checkbox">',
        'title' => __('Display Name'),
        'occupation' => __('Occupation'),
        'costs_per_hour' => __('Costs per Hour')
    );
    return $columns;
}

function mwta_employees_column_data($column, $post_id){
    $output = '';
    $currency = get_option('mwta_currency_option');
    
    switch($column){
        case 'title':
            //$display_name = get_field('display_name', $post_id);
            $output .= $display_name['display_name']; // Refenrez auf User?
            break;
        case 'occupation':
            $occupation = get_field('occupation',$post_id);
            $output .= $occupation->occupation;
            break;
        case 'costs_per_hour':
            $costs_per_hour = get_field('costs_per_hour',$post_id);
            $output .= number_format((float)$costs_per_hour,2,',','.') . ' ' . $currency;
            break;
    }
    echo $output;
}

function mwta_register_custom_admin_titles(){
    add_filter(
        'the_title',
        'mwta_employee_custom_admin_titles',
        99,
        2
    );
}

function mwta_employee_custom_admin_titles($title,$post_id){
    global $post;
    $output = $title;
    if(isset($post->post_type)){
        switch($post->post_type){
            case 'employees':
                $display_name = get_field('display_name',$post_id);
                $output = $display_name['display_name'];
                break;
        }
    }
    return $output;
}

?>