<?php

add_filter( 'wpfg_schemas', 'wpfg_formmaker_schema' );

function wpfg_formmaker_schema( $schemas = array() ){
	$schemas['formmaker'] = array(
		'callback' => 'wpfg_lookup_formmaker',
		'menus' => array(
			'edit' => array(
				'url' => admin_url() . 'admin.php?page=manage_fm',
				'label' => 'Edit Form'
			)
		),
		'js' => "$(function(){
				$.each( $('.wdform_preload'), function( i, el ){
					var form = $(el).parents('form:first')
						form_id = form.attr('id').replace('form','');
					WPFG.add_menu( { form_id: form_id, schema: 'formmaker' } );
				});
			});"
	);

	return $schemas;
}

function wpfg_lookup_formmaker( $form_id ){
	if( ! defined( 'WD_FM_DIR' ) )
		return false;

	global $wpdb;

	$form = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'formmaker WHERE id="%d" AND id NOT IN (' . (get_option('contact_form_forms', '') != '' ? get_option('contact_form_forms') : 0) . ')', $form_id));

	if( isset( $form->title ) && $form->title )
		return $form->title;

	return false;
}
