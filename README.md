# WP Forms Grabber

Originally written to find Gravity Forms and provide one-click access to the form edit screen, this plugin will find forms in all your favorite WordPress forms plugins and create Admin Bar menus for easy access to edit, adjust settings and view submissions.

Most form plugins use a shortcode or custom PHP code to embed forms into posts, pages or custom templates. This sometimes makes it difficult for users and administrators to locate specifically which form is embedded, especially when there a great number of forms sometimes with similar names. This plugin was written to provide quick access to the administration of these forms.

## Supported Plugins

 - Gravity Forms
 - Ninja Forms
 - Contact Form 7
 - Formidable (this adds functionality to the menu already existing in Formidable)
 - Visual Form Builder
 - Visual Form Builder Pro
 - Jetpack Contact Form
 - Form Maker
 - Contact Form Manager (XYZ Contact)
 - FormCraft

## Upcoming Plugins Support

 - ~~Breezing Forms~~ (use the docs to add support)

## Documentation

If you're using a forms plugin not supported by this plugin, adding your own custom implementation is pretty simple.

First, add a new filter to add your personal schema

	add_filter( 'wpfg_schemas', 'myprefix_mycustomform_schema' );

Then, append your schema to the schema array that's passed into the array.

	function myprefix_mycustomform_schema( $schemas ){
		$schemas['mycustomform'] = array(
			'callback' => 'myprefix_mycustomform_callback',
			'menus' => array(
				'edit' => array(
					'url' => admin_url() . 'admin.php?page=mycustomform&id={0}&action=edit',
					'label' => __( 'Edit Form' )
				),
				'settings' => array(
					'url' => admin_url() . 'admin.php?page=mycustomform&id={0}&action=settings',
					'label' => __( 'Form Settings' )
				),
				'submissions' => array(
					'url' => admin_url() . 'admin.php?page=mycustomform&id={0}&action=submissions',
					'label' => __( 'Form Submissions' )
				)
			),
			'js' => "$(function(){
				$.each( $('.my-custom-form-class'), function(i, el){
					WPFG.add_menu({ form_id: $(el).find('input:hidden[name="form_id"]').val(), schema: 'mycustomform' });
				});
			});"
		);
		
		return $schemas;
	}

Here are some important things to note about the schema:

 - $schemas['unqiuename']: Each schema needs a unique identifier that is used for the menu IDs as well as distinguishing them from other forms. The array index will hold this unique name. Dashes, underscores and numbers are allowed, but no special characters and no spaces.
 - Array Structure: Note how the array is structured. There are 3 array indexes used: "callback", "menus" and "js".
   - The value for "callback" needs to be a string (see below).
   - The value for "menus" should be an array. More information on the "menus" below.
   - The value for "js" should be a string of javascript to detect your forms. More info below.
 - Be sure to return the $schemas variable, since this is a filter.

### Schema Callback

The callback is what will populate the form title in the Admin Menu Bar. The callback needs to be a callable function that accepts 1 parameter ($form_id) and returns a string for the form title. Here's an example of the Gravity Forms callback:

	function function wpfg_lookup_gravityform( $form_id ){
		if( ! class_exists( 'GFAPI' ) )
			return false;
			
		$form = GFAPI::get_form( $form_id );
		
		if( $form['title'] )
			return $form['title'];
	
		return false;
	}

### Menus Array

The menus array allows you to provide a custom set of menus for each form. If you choose to use this functionality, it is required to have at minimum an "edit" menu. The menu is structured as follows:

 - Key: Unique key to identify the menu ("edit" is required)
 - Value: Array containing the properties of the menu item (URL and Label)
 	- URL: The URL to the desired destination. The Form ID will be formatted into the URL using a {0} placeholder
 	- Label: This is the text that appears in the menu. ("edit" label isn't used when no other menus exist)

### Javascript API

In order to create a menu, you need to call WPFG.add_menu(); This method accepts 1 parameter. It should be an object that contains the following properties:

- form_id (required): This is the ID of the form that will be passed into the menus and callback.
- schema (required): This will identify which schema to use. Make sure this matches your array key uniquename above
- title (optional): If provided, callback is not needed, and the menu will use this value for the title of the form.
