<?php

add_filter( 'wpfg_schemas', 'wpfg_xyzcontact_schema' );

function wpfg_xyzcontact_schema( $schemas = array() ){
	$schemas['xyzcontact'] = array(
		'menus' => array(
			'edit' => array(
				'url' => admin_url() . 'admin.php?page=contact-form-manager-managecontactforms&action=form-edit&id={0}&pageno=1',
				'label' => 'Edit Form'
			),
			'settings' => array(
				'url' => admin_url() . 'admin.php?page=contact-form-manager-manage',
				'label' => 'Settings'
			)
		),
		'js' => "$(function(){
				$.each( $('form[id^=\"xyz_cfm_\"]'), function( i, el ){
					var form_input = $(el).find('input[name^=\"xyz_cfm_frmName_\"]'),
						form_title = form_input.val(),
						form_id = form_input.attr('name').replace( 'xyz_cfm_frmName_','' );
					WPFG.add_menu( { form_id: form_id, schema: 'xyzcontact', title: form_title } );
				});
			});"
	);

	return $schemas;
}
