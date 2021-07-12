<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5f6663acae081',
	'title' => 'Client Details',
	'fields' => array(
		array(
			'key' => 'field_5f6663bc0cc72',
			'label' => 'Name',
			'name' => 'name',
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
			'key' => 'field_5f6663df0cc73',
			'label' => 'Shortcut',
			'name' => 'shortcut',
			'type' => 'text',
			'instructions' => 'Use 3 to 4 capitals, e.g. "ABC" oder "ABCD"',
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
			'maxlength' => 4,
		),
		array(
			'key' => 'field_5f6664680cc74',
			'label' => 'Monthly Fee',
			'name' => 'monthly_fee',
			'type' => 'number',  
			'instructions' => 'insert a number with max 2 decimals sparated by ".", e.g. "2450.55" ',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 0,
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
				'value' => 'clients',
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