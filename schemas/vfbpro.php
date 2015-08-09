<?php

add_filter( 'wpfg_schemas', 'wpfg_vfbpro_schema' );

function wpfg_vfbpro_schema( $schemas = array() ){
	$schemas['vfbpro'] = array(
		'callback' => 'wpfg_lookup_vfbpro',
		'menus' => array(
			'edit' => array(
				'url' => admin_url() . 'admin.php?page=vfb-pro&vfb-tab=fields&form={0}&vfb-action=edit',
				'label' => 'Edit Form'
			),
			'settings' => array(
				'url' => admin_url() . 'admin.php?page=vfb-pro&vfb-tab=settings&form={0}&vfb-action=edit',
				'label' => 'Form Settings'
			),
			'entries' => array(
				'url' => admin_url() . 'edit.php?form-id={0}&post_type=vfb_entry',
				'label' => 'Form Entries'
			)
		),
		'js' => "$(function(){
				$('#wp-admin-bar-vfbp-toolbar-edit-form').hide();
				$.each( $('.vfbp-form'), function( i, el ){
					var form_id = $('input[name=\"_vfb-form-id\"]').val();
					WPFG.add_menu( { form_id: form_id, schema: 'vfbpro' } );
				});
			});"
	);

	return $schemas;
}

function wpfg_lookup_vfbpro( $form_id ){
	global $wpdb;

	$form_table_name = $wpdb->prefix . 'vfb_pro_forms';
	$order = sanitize_sql_orderby( 'form_id DESC' );
	$form = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $form_table_name WHERE form_id = %d ORDER BY $order", $form_id ) );

	if( isset( $form->form_title ) && $form->form_title )
		return $form->form_title;

	return false;
}
