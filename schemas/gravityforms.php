<?php

add_filter( 'wpfg_schemas', 'wpfg_gravityforms_schema' );

function wpfg_gravityforms_schema( $schemas = array() ){
	$schemas['gravityforms'] = array(
		'callback' => 'wpfg_lookup_gravityform',
		'menus' => array(
			'edit' => array(
				'url' => admin_url() . '?page=gf_edit_forms&id={0}',
				'label' => 'Edit Form'
			),
			'settings' => array(
				'url' => admin_url() . '?page=gf_edit_forms&view=settings&id={0}',
				'label' => 'Form Settings'
			),
			'entries' => array(
				'url' => admin_url() . '?page=gf_entries&id={0}',
				'label' => 'Form Entries'
			)
		)
	);
	return $schemas;
}

function wpfg_lookup_gravityform( $form_id ){
	if( ! class_exists( 'GFAPI' ) )
		return false;

	$form = GFAPI::get_form( $form_id );

	if( $form['title'] )
		return $form['title'];

	return false;
}
