<?php

add_filter( 'wpfg_schemas', 'wpfg_visualformbuilder_schema' );

function wpfg_visualformbuilder_schema( $schemas = array() ){
	$schemas['visualformbuilder'] = array(
		'callback' => 'wpfg_lookup_visualformbuilder',
		'menus' => array(
			'edit' => array(
				'url' => admin_url() . 'admin.php?page=visual-form-builder&action=edit&form={0}',
				'label' => 'Edit Form'
			),
			'entries' => array(
				'url' => admin_url() . 'admin.php?page=vfb-entries&form-filter={0}',
				'label' => 'Form Entries'
			)
		),
		'js' => "$(function(){
				$.each( $('.visual-form-builder'), function( i, el ){
					var form_id = $('input[name=\"form_id\"]').val();
					WPFG.add_menu( { form_id: form_id, schema: 'visualformbuilder' } );
				});
			});"
	);

	return $schemas;
}

function wpfg_lookup_visualformbuilder( $form_id ){
	global $wpdb;

	$form_table_name = $wpdb->prefix . 'visual_form_builder_forms';
	$order = sanitize_sql_orderby( 'form_id DESC' );
	$form = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $form_table_name WHERE form_id = %d ORDER BY $order", $form_id ) );

	if( isset( $form->form_title ) && $form->form_title )
		return $form->form_title;

	return false;
}
