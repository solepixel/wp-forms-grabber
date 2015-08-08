<?php
/*
Plugin Name: WP Forms Grabber
Plugin URI: https://briandichiara.com
Description: Adds a simple "Edit Form" link to admin bar for popular forms plugins
Version: 0.0.1
Author: Brian DiChiara
Author URI: http://briandichiara.com
*/

define( 'WPFG_VERSION', '0.0.1' );
define( 'WPFG_URL', plugin_dir_url( __FILE__ ) );
define( 'WPFG_PATH', plugin_dir_path( __FILE__ ) );

add_action( 'admin_bar_init', 'wpfg_enqueue_script' );

/**
 * Enqueue the JS needed to detect forms and setup the admin menus
 * @return void
 */
function wpfg_enqueue_script(){
	wp_register_script( 'wpfg-admin-bar', WPFG_URL . 'js/admin-bar.js', array( 'admin-bar', 'jquery' ), WPFG_VERSION );
	wp_localize_script( 'wpfg-admin-bar', 'wpfg_vars', array(
		'schemas' => json_encode( wpfg_get_schemas(), JSON_FORCE_OBJECT ),
		'ajax_url' => admin_url() . 'admin-ajax.php'
	));

	wp_enqueue_script( 'wpfg-admin-bar' );
}

/**
 * Get WPFG Form Schemas
 * @param  string $schema  Schema identifier (array index)
 * @return array           Array of Schemas or individual Schema if specified
 */
function wpfg_get_schemas( $schema = false ){
	$schemas = apply_filters( 'wpfg_schemas', array() );

	if( $schema && isset( $schemas[ $schema ] ) )
		return $schemas[ $schema ];

	return $schemas;
}

add_action( 'wp_ajax_wpfg_get_title', 'wpfg_get_title' );
add_action( 'wp_ajax_nopriv_wpfg_get_title', 'wpfg_get_title' );

/**
 * AJAX function to retrieve form title from schema callback function
 * @return void
 */
function wpfg_get_title(){
	$response = array();

	$form_id = isset( $_GET['form_id'] ) ? sanitize_text_field( $_GET['form_id'] ) : '';
	$lookup_schema = isset( $_GET['schema'] ) ? sanitize_text_field( $_GET['schema'] ) : '';

	if( ! $form_id || ! $lookup_schema )
		wp_send_json( $response );

	if( $schema = wpfg_get_schemas( $lookup_schema ) ){
		if( isset( $schema['callback'] ) && function_exists( $schema['callback'] ) ){
			$form_title = call_user_func( $schema['callback'], $form_id );
			if( $form_title )
				$response['form_title'] = $form_title;
		}
	}

	wp_send_json( $response );
}

/**
 * Include some base schemas
 */
include_once( WPFG_PATH . 'schemas/gravityforms.php' );
include_once( WPFG_PATH . 'schemas/cf7.php' );
include_once( WPFG_PATH . 'schemas/ninjaforms.php' );
include_once( WPFG_PATH . 'schemas/formidable.php' );
