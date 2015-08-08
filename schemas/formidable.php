<?php

add_filter( 'wpfg_schemas', 'wpfg_formidable_schema' );

function wpfg_formidable_schema( $schemas = array() ){
	$schemas['formidable'] = array(
		'callback' => 'wpfg_lookup_formidable',
		'menus' => array(
			'edit' => array(
				'url' => admin_url() . 'admin.php?page=formidable&frm_action=edit&id={0}',
				'label' => 'Edit Form'
			),
			'settings' => array(
				'url' => admin_url() . 'admin.php?page=formidable&frm_action=settings&id={0}',
				'label' => 'Form Settings'
			),
			'entries' => array(
				'url' => admin_url() . 'admin.php?page=formidable-entries&frm_action=list&form={0}',
				'label' => 'Form Entries'
			)
		)
	);
	return $schemas;
}

function wpfg_lookup_formidable( $form_id ){
	if( ! class_exists( 'FrmField' ) )
		return false;

	$form = FrmField::get_all_for_form( $form_id );
	if( is_array( $form ) )
		$form = reset( $form );
	if( isset( $form->form_name ) && $form->form_name )
		return $form->form_name;

	return false;
}
