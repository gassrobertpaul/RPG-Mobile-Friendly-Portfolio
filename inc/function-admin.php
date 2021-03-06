<?php

/*
	
@package RPG Mobile Friendly Portfolio
	
	========================
		ADMIN PAGE
	========================
*/

/**
 * Post Formats
 */
$formats = array( 'gallery', 'link', 'image', 'video', 'audio' );
add_theme_support( 'post-formats', $formats );
add_theme_support( 'post-thumbnails' );
add_post_type_support( 'page', 'excerpt' );

/* Activate HTML5 features */
add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption' ) );

/**
 * Custom Post Type
 */
function register_featured_post_content_type() {
	$post_labels = array(
		'name' 			    => 'Featured Posts',
		'singular_name' 	=> 'Featured Post',
		'add_new' 		    => 'Add New',
		'add_new_item'  	=> 'Add New Featured Post',
		'edit'		        => 'Edit',
		'edit_item'	        => 'Edit Featured Post (To convert a Featured Post to a Post install the Post Type Switcher plugin)',
		'new_item'	        => 'New Featured Post',
		'view' 			    => 'View Featured Post',
		'view_item' 		=> 'View Featured Post',
		'search_item' 		=> 'Search Featured Posts',
		'search_term'   	=> 'Search Featured Posts',
		'parent' 		    => 'Parent Featured Post',
		'not_found' 		=> 'No Featured Posts found',
		'not_found_in_trash' 	=> 'No Featured Posts in Trash', 
		'parent_item_colon' => 'Parent Featured Posts:'
	);
	$args = array (
		'labels' => $post_labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true, 
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'supports' => array(
			'title',
			'editor',
			'post-formats', 
			'excerpt',
			'thumbnail',
			'revisions',
		),
		'taxonomies' => array('category', 'post_tag'),
		'menu_position' => 5, 
		'menu_icon' => 'dashicons-admin-post',
		'exclude_from_search' => false
	);
	register_post_type( 'featuredPosts', $args );
}
add_action( 'init', 'register_featured_post_content_type' );




/**
 * Enqueue admin css and js
 */
function rpg_portfolio_enqueue_custom_admin_style( $hook ) {

	if ( $hook == 'toplevel_page_rpg_portfolio_admin' ) {
	        wp_register_style( 'rpg_portfolio_wp_admin_css', get_template_directory_uri() . '/css/rpg_admin_style.css', false, '1.0.0' );
	        wp_enqueue_style( 'rpg_portfolio_wp_admin_css' );	

	        wp_register_script( 'rpg-portfolio-admin-script', get_template_directory_uri() . '/js/rpgprofile.admin.js', array('jquery'), '1.0.0', true );
	        wp_enqueue_media();
	        wp_enqueue_script( 'rpg-portfolio-admin-script' );
	}


}
add_action( 'admin_enqueue_scripts', 'rpg_portfolio_enqueue_custom_admin_style' );
/**
 * Set up admin menu page
 */

function rpg_portfolio_add_admin_page() {

	// Generate RPG Mobile Friendly Portfolio Admin Page
	add_menu_page( 'Portfolio Personal Data', 'Personal Data', 'manage_options', 'rpg_portfolio_admin', 'rpg_portfolio_admin_create_page', 'dashicons-businessman', 110 );
}
add_action( 'admin_menu', 'rpg_portfolio_add_admin_page', 'rpg_portfolio_sidebar_name' );

// Template submenu functions
function rpg_portfolio_admin_create_page() {
	require_once( get_template_directory() . '/inc/templates/rpg-portfolio-admin-options.php' );
}

//Activate custom settings
add_action( 'admin_init', 'sunset_custom_settings' );

function sunset_custom_settings() {
	//Sidebar Options
	register_setting( 'rpg-profile-settings-group', 'profile_picture' );
	register_setting( 'rpg-profile-settings-group', 'profile_name' );
	register_setting( 'rpg-profile-settings-group', 'profile_email' );
	register_setting( 'rpg-profile-settings-group', 'profile_phone' );
	register_setting( 'rpg-profile-settings-group', 'profile_location' );
	register_setting( 'rpg-profile-settings-group', 'profile_intro' );
	register_setting( 'rpg-profile-settings-group', 'github_handler' );
	register_setting( 'rpg-profile-settings-group', 'twitter_handler' );
	register_setting( 'rpg-profile-settings-group', 'facebook_handler' );
	register_setting( 'rpg-profile-settings-group', 'gplus_handler' );	
	
	add_settings_section( 'rpg-profile-sidebar-options', 'Portfolio Personal Data Form', 'rpg_profile_sidebar_options', 'rpg_profile');
	
	add_settings_field( 'sidebar-profile-picture', 'Profile Picture', 'rpg_profile_sidebar_profile_picture', 'rpg_profile', 'rpg-profile-sidebar-options');
	add_settings_field( 'sidebar-profile-name', 'Full Name', 'rpg_profile_sidebar_name', 'rpg_profile', 'rpg-profile-sidebar-options');
	add_settings_field( 'sidebar-profile-email', 'Email', 'rpg_profile_sidebar_email', 'rpg_profile', 'rpg-profile-sidebar-options');
	add_settings_field( 'sidebar-profile-phone', 'Phone', 'rpg_profile_sidebar_phone', 'rpg_profile', 'rpg-profile-sidebar-options');
	add_settings_field( 'sidebar-profile-location', 'Location', 'rpg_profile_sidebar_location', 'rpg_profile', 'rpg-profile-sidebar-options');
	add_settings_field( 'sidebar-profile-intro', 'Introduction', 'rpg_profile_sidebar_intro', 'rpg_profile', 'rpg-profile-sidebar-options');
	add_settings_field( 'sidebar-profile-github', 'Github Link', 'rpg_profile_sidebar_github', 'rpg_profile', 'rpg-profile-sidebar-options');
	add_settings_field( 'sidebar-profile-twitter', 'Twitter Link', 'rpg_profile_sidebar_twitter', 'rpg_profile', 'rpg-profile-sidebar-options');
	add_settings_field( 'sidebar-profile-facebook', 'Facebook Link', 'rpg_profile_sidebar_facebook', 'rpg_profile', 'rpg-profile-sidebar-options');
	add_settings_field( 'sidebar-profile-gplus', 'Google+ Link', 'rpg_profile_sidebar_gplus', 'rpg_profile', 'rpg-profile-sidebar-options');

}

// Sidebar Options Functions
function rpg_profile_sidebar_options() {
	echo '<h3 class="title">Customize your personal data for the portfolio.</h3>';
}

// HTML for Sidebar Profile Picture
function rpg_profile_sidebar_profile_picture() {
	$picture = esc_attr( get_option( 'profile_picture' ) );
	if( empty($picture) ){
		echo '<button type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button"><span class="rpg-profile-icon-button dashicons-before dashicons-format-image"></span> Upload Profile Picture</button><input type="hidden" id="profile-picture" name="profile_picture" value="" /><p>A square image is recommended.</p>';
	} else {
		echo '<button type="button" class="button button-secondary" value="Replace Profile Picture" id="upload-button"><span class="rpg-profile-icon-button dashicons-before dashicons-format-image"></span> Replace Profile Picture</button><input type="hidden" id="profile-picture" name="profile_picture" value="'.$picture.'" /><p>A square image is recommended.</p><button type="button" class="button button-secondary" value="Remove" id="remove-picture"><span class="rpg-profile-icon-button dashicons-before dashicons-no"></span> Remove</button>';
	}
	
}

// HTML for Sidebar Name
function rpg_profile_sidebar_name() {
	$profilename = esc_attr( get_option( 'profile_name' ) );
	echo '<input type="text" name="profile_name" value="'.$profilename.'" placeholder="Full Name" class="txtProfile" />';
}

// HTML for Sidebar Email
function rpg_profile_sidebar_email() {
	$profileemail = esc_attr( get_option( 'profile_email' ) );
	echo '<input type="text" name="profile_email" value="'.$profileemail.'" placeholder="Email" class="txtProfile" />';
}

// HTML for Sidebar Phone
function rpg_profile_sidebar_phone() {
	$profilephone = esc_attr( get_option( 'profile_phone' ) );
	echo '<input type="text" name="profile_phone" value="'.$profilephone.'" placeholder="Phone" class="txtProfile" />';
}

// HTML for Sidebar Location
function rpg_profile_sidebar_location() {
	$profilelocation = esc_attr( get_option( 'profile_location' ) );
	echo '<input type="text" name="profile_location" value="'.$profilelocation.'" placeholder="Location" class="txtProfile" />';
}

// HTML for Sidebar Intro
function rpg_profile_sidebar_intro() {
	$profileintro = esc_attr( get_option( 'profile_intro' ) );
	echo '<textarea name="profile_intro" placeholder="Introduction" class="txtProfile">'.$profileintro.'</textarea>';
}

// HTML for Sidebar Github icon
function rpg_profile_sidebar_github() {
	$github = esc_attr( get_option( 'github_handler' ) );
	echo '<input type="text" name="github_handler" value="'.$github.'" placeholder="Github account URL" class="txtProfile" />';
}

// HTML for Sidebar Twitter icon
function rpg_profile_sidebar_twitter() {
	$twitter = esc_attr( get_option( 'twitter_handler' ) );
	echo '<input type="text" name="twitter_handler" value="'.$twitter.'" placeholder="Twitter account URL" class="txtProfile" />';
}

// HTML for Sidebar Facebook icon
function rpg_profile_sidebar_facebook() {
	$facebook = esc_attr( get_option( 'facebook_handler' ) );
	echo '<input type="text" name="facebook_handler" value="'.$facebook.'" placeholder="Facebook account URL" class="txtProfile" />';
}

// HTML for Sidebar Google+ icon
function rpg_profile_sidebar_gplus() {
	$gplus = esc_attr( get_option( 'gplus_handler' ) );
	echo '<input type="text" name="gplus_handler" value="'.$gplus.'" placeholder="Google+ account URL" class="txtProfile" />';
}