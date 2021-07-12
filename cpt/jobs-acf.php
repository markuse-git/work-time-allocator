<?php

function cptui_register_my_cpts_jobs() {

	/**
	 * Post Type: Jobs.
	 */

	$labels = [
		"name" => __( "Jobs", "twentyseventeen" ),
		"singular_name" => __( "Job", "twentyseventeen" ),
	];

	$args = [
		"label" => __( "Jobs", "twentyseventeen" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
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
		"rewrite" => [ "slug" => "jobs", "with_front" => false ],
		"query_var" => true,
		"menu_icon" => "dashicons-hammer",
		"supports" => false,
	];

	register_post_type( "jobs", $args );
}

add_action( 'init', 'cptui_register_my_cpts_jobs' );

//----------------------ACF------------------------------------------

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5f679f138d20f',
	'title' => 'Job Details',
	'fields' => array(
		array(
			'key' => 'field_5f679f2ae3151',
			'label' => 'Client',
			'name' => 'client',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'clients',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'object',
			'ui' => 1,
		),
		array(
			'key' => 'field_5f679fb4e3152',
			'label' => 'Job Title',
			'name' => 'job_title',
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
			'key' => 'field_5f679ff4e3153',
			'label' => 'Price',
			'name' => 'price',
			'type' => 'number',
			'instructions' => 'Enter a number with max 2 decimals separated by ".", e.g. "103.45"',
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
		array(
			'key' => 'field_5f67a037e3154',
			'label' => 'closed?',
			'name' => 'closed',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'jobs',
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