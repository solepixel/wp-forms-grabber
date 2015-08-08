<?php

add_filter( 'wpfg_schemas', 'wpfg_ninjaforms_schema' );

function wpfg_ninjaforms_schema( $schemas = array() ){
	$schemas['ninjaforms'] = array(
		'callback' => 'wpfg_lookup_ninjaform',
		'menus' => array(
			'edit' => array(
				'url' => admin_url() . '?page=ninja-forms&tab=builder&form_id={0}',
				'label' => 'Edit Form'
			),
			'settings' => array(
				'url' => admin_url() . '?page=ninja-forms&tab=form_settings&form_id={0}',
				'label' => 'Form Settings'
			),
			'submissions' => array(
				'url' => admin_url() . 'edit.php?post_status=all&post_type=nf_sub&form_id={0}',
				'label' => 'Form Submissions'
			)
		)
	);
	return $schemas;
}

function wpfg_lookup_ninjaform( $form_id ){
	if( ! function_exists( 'ninja_forms_get_form_by_field_id' ) )
		return false;

	$form = ninja_forms_get_form_by_field_id( $form_id );
	if( isset( $form['data']['form_title'] ) && $form['data']['form_title'] )
		return $form['data']['form_title'];

	return false;
}
