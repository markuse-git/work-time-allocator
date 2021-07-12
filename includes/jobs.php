<?php

add_filter('manage_edit-jobs_columns', 'mwta_jobs_column_headers');
add_filter('manage_jobs_posts_custom_column','mwta_jobs_column_data', 1,2);
add_filter('admin_head-edit.php','mwta_register_custom_jobs_titles');

function mwta_jobs_column_headers($columns){
    $columns = array(
        'cb' => '<input type="checkbox">',
        'title' => __('Job Title'),
        'client' => __('Client'),
        'price' => __('Price'),
        'closed' => __('closed?')
    );
    return $columns;
}

function mwta_jobs_column_data($column, $post_id){
    $output = '';
    $currency = get_option('mwta_currency_option');
    
    switch($column){
        case 'title':
            $job_title = get_field('job_title', $post_id);
            $output .= $job_title;
            break;
        case 'client':
            $client = get_field('client',$post_id);
            $output .= $client->name; 
            break;
        case 'price':
            $price = get_field('price',$post_id);
            $output .= number_format((float)$price,2,',','.') . ' ' . $currency;
            break;
        case 'closed':
            if(get_field('closed',$post_id) == 1){
                $closed = date('Y-m-d',get_post_modified_time());
                $output .= $closed;
            }
            break;
    }
    echo $output;
}

function mwta_register_custom_jobs_titles(){
    add_filter(
        'the_title',
        'mwta_jobs_custom_admin_titles',
        99,
        2
    );
}

function mwta_jobs_custom_admin_titles($title,$post_id){
    global $post;
    $output = $title;
    if(isset($post->post_type)){
        switch($post->post_type){
            case 'jobs':
                $job_title = get_field('job_title',$post_id);
                $output = $job_title;
                break;
        }
    }
    return $output;
}

?>