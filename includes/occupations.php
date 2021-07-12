<?php

add_filter('manage_edit-occupations_columns', 'mwta_occupations_column_headers');
add_filter('manage_occupations_posts_custom_column','mwta_occupations_column_data', 1,2);
add_filter('admin_head-edit.php','mwta_register_custom_occupations_titles');

function mwta_occupations_column_headers($columns){
    $columns = array(
        'cb' => '<input type="checkbox">',
        'title' => __('Occupation'),
        'price_per_hour' => __('Price per Hour')
    );
    return $columns;
}

function mwta_occupations_column_data($column, $post_id){
    $output = '';
    $currency = get_option('mwta_currency_option');
    
    switch($column){
        case 'title':
            $occupation = get_field('occupation', $post_id);
            $output .= $occupation;
            break;
        case 'price_per_hour':
            $price = get_field('price_per_hour',$post_id);
            $output .= number_format($price,2,',','.') . ' ' . $currency;
            break;
    }
    echo $output;
}

function mwta_register_custom_occupations_titles(){
    add_filter(
        'the_title',
        'mwta_custom_occupations_titles',
        99,
        2
    );
}

function mwta_custom_occupations_titles($title,$post_id){
    global $post;
    $output = $title;
    if(isset($post->post_type)){
        switch($post->post_type){
            case 'occupations':
                $occupation = get_field('occupation',$post_id);
                $output = $occupation;
                break;
        }
    }
    return $output;
}

add_filter('acf/fields/post_object/result','my_acf_post_object_occupations',10,4);

function my_acf_post_object_occupations($text,$post,$field,$post_id){
    if($post->post_type == 'occupations'){
        $text = $post->occupation;  
    }
    return $text;
}

?>