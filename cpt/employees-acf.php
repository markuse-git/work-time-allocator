<?php

function cptui_register_my_cpts_employees() {

	/**
	 * Post Type: Employees.
	 */

	$labels = [
		"name" => __( "Employees", "twentyseventeen" ),
		"singular_name" => __( "Employee", "twentyseventeen" ),
	];

	$args = [
		"label" => __( "Employees", "twentyseventeen" ),
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
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "employees", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-buddicons-buddypress-logo",
		"supports" => false,
	];

	register_post_type( "employees", $args );
}

add_action( 'init', 'cptui_register_my_cpts_employees' );

//--------------ACF-------------------------------------------

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5f65057cd8301',
	'title' => 'Employees Details',
	'fields' => array(
		array(
			'key' => 'field_5f8a0c6792e45',
			'label' => 'Display Name',
			'name' => 'display_name',
			'type' => 'user',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'role' => array(
				0 => 'employee',
				1 => 'administrator',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'array',
		),
		array(
			'key' => 'field_5f65089dbbe1d',
			'label' => 'Occupation',
			'name' => 'occupation',
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
				0 => 'occupations',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'object',
			'ui' => 1,
		),
		array(
			'key' => 'field_5f8b42ca6c4c6',
			'label' => 'Costs per Hour',
			'name' => 'costs_per_hour',
			'type' => 'number',
			'instructions' => 'Enter a number with max 2 decimals, separated by ".", e.g. "35.46"',
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
				'value' => 'employees',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

?>