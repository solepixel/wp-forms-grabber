<?php

add_filter( 'wpfg_schemas', 'wpfg_cf7_schema' );

function wpfg_cf7_schema( $schemas = array() ){
	$schemas['cf7'] = array(
		'callback' => 'wpfg_lookup_cf7',
		'menus' => array(
			'edit' => array(
				'url' => admin_url() . 'admin.php?page=wpcf7&post={0}&action=edit',
				'label' => 'Edit Form'
			)
		)
	);
	return $schemas;
}

function wpfg_lookup_cf7( $form_id ){
	if( $form_title = get_the_title( $form_id ) )
		return $form_title;

	return false;
}
