<?php

add_filter( 'wpfg_schemas', 'wpfg_formcraft_schema' );

function wpfg_formcraft_schema( $schemas = array() ){
	$schemas['formcraft'] = array(
		'callback' => 'wpfg_lookup_formcraft',
		'menus' => array(
			'edit' => array(
				'url' => admin_url() . 'admin.php?page=formcraft_basic_dashboard&id={0}',
				'label' => 'Edit Form'
			),
			'entries' => array(
				'url' => admin_url() . 'admin.php?page=formcraft_basic_dashboard',
				'label' => 'Form Submissions'
			)
		),
		'js' => "$(function(){
				$.each( $('.fcb_form'), function( i, el ){
					var form_id = $(el).data('id');
					WPFG.add_menu( { form_id: form_id, schema: 'formcraft' } );
				});
			});"
	);

	return $schemas;
}

function wpfg_lookup_formcraft( $form_id ){
	global $wpdb, $forms_table;
	$form = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $forms_table WHERE id = '%s'", $form_id ) );
	if( isset( $form->name ) && $form->name )
		return $form->name;

	return false;
}
