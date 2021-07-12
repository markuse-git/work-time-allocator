<?php

function cptui_register_my_cpts_occupations() {

	/**
	 * Post Type: Occupations.
	 */

	$labels = [
		"name" => __( "Occupations", "twentyseventeen" ),
		"singular_name" => __( "Occupation", "twentyseventeen" ),
	];

	$args = [
		"label" => __( "Occupations", "twentyseventeen" ),
		"labels" => $labels,
		"description" => "",
		"public" => false,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => false,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "occupations", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-networking",
		"supports" => false,
	];

	register_post_type( "occupations", $args );
}

add_action( 'init', 'cptui_register_my_cpts_occupations' );

//---------------------ACF--------------------------------------

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5f68a44c8c661',
	'title' => 'Occupations Details',
	'fields' => array(
		array(
			'key' => 'field_5f68a45624ad4',
			'label' => 'Occupation',
			'name' => 'occupation',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5f68a47a24ad5',
			'label' => 'Price per Hour',
			'name' => 'price_per_hour',
			'type' => 'number',
			'instructions' => 'insert a number with max 2 decimals separated by ".", e.g. "100.56" ',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
            'max' => '',
            'step' => '0.01',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'occupations',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

?>