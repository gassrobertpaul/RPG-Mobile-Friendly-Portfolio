<?php

/*
	
@package RPG Mobile Friendly Portfolio
	
	========================
		FRONT THEME SUPPORT FUNCTIONS
	========================
*/

/* Activate Nav Menu Options */
function rpg_portfolio_register_nav_menu() {
	register_nav_menu( 'rpg-profile-primary-menu', 'Header Navigation Menu' );
}
add_action( 'init', 'rpg_portfolio_register_nav_menu' );

function rpg_portfolio_register_mobile_sidebar_nav_menu() {
	register_nav_menu( 'rpg-profile-mobile-sidebar-menu', 'Mobile Sidebar Navigation Menu' );
}
add_action( 'init', 'rpg_portfolio_register_mobile_sidebar_nav_menu' );

/* Sidebar Functions */
function rpg_portfolio_sidebar_init() {

	register_sidebar(
		array(
			'name' => esc_html__( 'Portfolio Sidebar', 'rpgportfoliotheme'),
			'id' => 'rpg-portfolio-sidebar',
			'description' => 'Mobile Friendly Left Sidebar',
			'before_widget' => '<section id="%1$s" class="rpg-portfolio-widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="rpg-portfolio-widget-title">',
			'after_title' => '</h2>'
		)
	);
}
add_action( 'widgets_init', 'rpg_portfolio_sidebar_init' );

/* Post Index Loop Functions */
function get_featured_posts_for_index() {
    $args = array(
        'post_type' => 'featuredPosts',
        'orderby' => 'ID',
        'order' => 'DESC',
    );

    // if it's the first page and it's not a category or an archive then display any featured posts first
    $featuredPosts = new WP_Query($args);
    return $featuredPosts;
}

function get_featured_posts_by_category($category_id) {

    $args = array(
        'post_type' => 'featuredPosts', 
        'cat' => $category_id, 
        'orderby' => 'ID',
        'order' => 'DESC'
    );

    $featuredPosts = new WP_Query($args);
    return $featuredPosts;
}

function get_featured_posts_by_tag($tag_name) {
    $args = array(
        'post_type' => 'featuredPosts', 
        'tag' => $tag_name, 
        'orderby' => 'ID',
        'order' => 'DESC'
    );

    $featuredPosts = new WP_Query($args);
    return $featuredPosts;
}

function get_featured_posts_by_date($year, $monthnum) {
    $args = array(
        'post_type' => 'featuredPosts', 
        'date_query' => array(
            array(
                'year'  => $year,
                'month' => $monthnum
            ),
        ),
        'orderby' => 'ID',
        'order' => 'DESC'
    );

    $featuredPosts = new WP_Query($args);
    return $featuredPosts;
}

/* Post Content Functions */
function rpg_portfolio_posted_meta() {
	$posted_on = human_time_diff( get_the_time('U'), current_time('timestamp') );
	$categories = get_the_category();
	$separator = ', ';
	$output = '';
	$i = 1;

	if( !empty($categories) ):
		foreach( $categories as $category ):

			if ( $i > 1 ): $output .= $separator; endif;

			$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( 'View all posts in %s', $category->name ) . '">' . esc_html( $category->name ) . '</a>';
			$i++;
		endforeach;
	endif;

	return '<span class="posted-on"> Posted <a href="' . esc_url( get_permalink() ) . '">' . $posted_on . '</a> ago / </span><span class="posted-in">' . $output . '</span>';
}

function rpg_portfolio_get_attachment( $num = 1 ){
	$output = '';
	if( has_post_thumbnail() && $num == 1): 
		$output = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
	else: 
		$attachments = get_posts( array( 
			'post_type' => 'attachment',
			'posts_per_page' => $num,
			'post_parent' => get_the_ID() 
		) );

		if ( $attachments && $num == 1 ):
			foreach ( $attachments as $attachment ):
				$output = wp_get_attachment_url( $attachment->ID );
			endforeach;
		elseif ( $attachments && $num > 1 ):
			$output = $attachments;
		endif;	

	endif; 
	return $output;
}

function rpg_portfolio_tags() {

	return '<div class="post-footer-container">' . get_the_tag_list( '<div class="rpg-profile-icon-footer dashicons-before dashicons-tag"></span>', ' ', '</div>' ) . '</div>';
}

function rpg_portfolio_get_embedded_media( $type = array() ) {
	$content = do_shortcode( apply_filters( 'the_content', get_the_content() ) );
	$embed = get_media_embedded_in_content( $content, $type );

	if( in_array( 'audio', $type ) ):
		$output = str_replace( '?visual=true', '?visual=false', $embed[0] );
	else:
		$output = $embed[0];
	endif;
	return	$output;
}

function rpg_portfolio_get_slides($attachments) {

	$output = array();
	$count = count($attachments)-1;

	for ( $i = 0; $i <= $count; $i++ ): 

		$active = ( $i == 0 ? ' active' : '' );

		$output[$i] = array( 
			'class' 	=> $active,  
			'url' 		=> wp_get_attachment_url( $attachments[$i]->ID ),
			'caption' 	=> $attachments[$i]->post_excerpt
		);

	endfor; 

	return $output;
}

function rpg_portfolio_grab_url() {
	if (!preg_match('/<a\s[^>]*?href=[\'"](.+?)[\'"]/i', get_the_content(), $links))
	{
		return false;
	}
	return esc_url_raw( $links[1] );
}

/* Regular Post Type Functions */
function get_oldest_featured_post_id()
{
	global $wpdb;
	$oldest_result_set = $wpdb->get_results("SELECT id FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'featuredposts' ORDER BY id ASC LIMIT 1");
	return $oldest_result_set;
}

function get_newer_post_id($current_post_id)
{
	global $wpdb;
	$newer_result_set = $wpdb->get_results("SELECT id FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND id > $current_post_id LIMIT 1");
	return $newer_result_set;
}


/* Single Custom Post Type Functions */
function get_most_recent_regular_post_id()
{
	global $wpdb;
	$most_recent_result_set = $wpdb->get_results("SELECT id FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY id DESC LIMIT 1");
	return $most_recent_result_set;
}

function get_earlier_featured_post_id($current_post_id)
{
	global $wpdb;
	$earlier_result_set = $wpdb->get_results("SELECT id FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'featuredposts' AND id < $current_post_id LIMIT 1");
	return $earlier_result_set;
}


/* Footer Functions */
function rpg_portfolio_footer_one_init() {

	register_sidebar(
		array(
			'name' => esc_html__( 'Portfolio Footer One', 'rpgportfoliotheme'),
			'id' => 'rpg-portfolio-footer-one',
			'description' => 'Mobile Friendly Footer Widget Area One',
			'before_widget' => '<section id="%1$s" class="rpg-portfolio-widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="rpg-portfolio-widget-title">',
			'after_title' => '</h2>'
		)
	);
}
add_action( 'widgets_init', 'rpg_portfolio_footer_one_init' );

