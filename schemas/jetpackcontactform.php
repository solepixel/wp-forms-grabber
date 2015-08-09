<?php

add_filter( 'wpfg_schemas', 'wpfg_jetpackcontactform_schema' );

function wpfg_jetpackcontactform_schema( $schemas = array() ){
	$schemas['jetpackcontactform'] = array(
		'menus' => array(
			'edit' => array(
				'url' => admin_url() . 'post.php?post={0}&action=edit',
				'label' => 'Edit Form'
			),
			'entries' => array(
				'url' => admin_url() . 'edit.php?post_type=feedback',
				'label' => 'Form Entries'
			)
		),
		'js' => "$(function(){
				if( $('input[name=\"contact-form-id\"]').length ){
					var page_id = $('input[name=\"contact-form-id\"]').val();
					WPFG.add_menu( { form_id: page_id, schema: 'jetpackcontactform', title: 'Jetpack Contact Form' } );
				}
			});"
	);

	return $schemas;
}
