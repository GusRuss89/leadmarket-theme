<?php
/*
This file handles the admin area and functions.
You can use this file to make changes to the
dashboard. 

Author: Angus Russell
Many thanks: Eddie Machado

*/

/************* DASHBOARD WIDGETS *****************/

/************* TINY MCE *****************/
// Insert 'styleselect' into the $buttons array
function branch_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter('mce_buttons_2', 'branch_mce_buttons_2');

// Filter the MCE settings
function branch_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'Leading Paragraph',  
			'block' => 'div',  
			'classes' => 'lede',
			'wrapper' => true,
			
		),  
		array(  
			'title' => 'Emphasis',  
			'inline' => 'span',  
			'classes' => 'zomg',
			'wrapper' => false,
		)
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
} 
add_filter( 'tiny_mce_before_init', 'branch_mce_before_init_insert_formats' );  

/************* CUSTOM LOGIN PAGE *****************/

// Custom login CSS
function branch_login_css() {
	wp_enqueue_style( 'branch_login_css', get_template_directory_uri() . '/library/css/login.css', false );
}

// Changing the logo link from wordpress.org to your site
function branch_login_url() {  return home_url(); }

// Changing the alt text on the logo to show your site name
function branch_login_title() { return get_option('blogname'); }

// Calling it only on the login page
add_action( 'login_enqueue_scripts', 'branch_login_css', 10 );
add_filter('login_headerurl', 'branch_login_url');
add_filter('login_headertitle', 'branch_login_title');


/************* CUSTOMIZE ADMIN *******************/

// Custom Backend Footer
function branch_custom_admin_footer() {
	echo 'Created by Branch Digital. <a href="mailto:info@branchdigital.com.au">info@branchdigital.com.au</a>.';
}

// adding it to the admin area
add_filter('admin_footer_text', 'branch_custom_admin_footer');

/************* CONTEXTUAL HELP *******************/

// Shortcodes
function branch_shortcodes_help() {

	global $shortcodes_help;
    $screen = get_current_screen();

    if ( $screen->base != 'post' )
        return;

    // Add help tab
    $screen->add_help_tab( array(
        'id' => 'branch-shortcodes-help',
        'title'	=> 'Available Shortcodes',
        'content' => $shortcodes_help,
    ) );

}
add_action( 'load-post.php', 'branch_shortcodes_help' );
add_action( 'load-post-new.php', 'branch_shortcodes_help' );

?>
