<?php
/**
 * This file adds the Front Page to the Showcase Pro Theme.
 *
 * @author JT Grauke
 * @package Showcase Pro
 * @subpackage Customizations
 */

/*
Template Name: Home
*/

add_action( 'genesis_meta', 'showcase_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function showcase_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-hero' ) || is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2-app-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4') ) {

		//* Enqueue scripts
		add_action( 'wp_enqueue_scripts', 'showcase_enqueue_digital_script' );
		function showcase_enqueue_digital_script() {

			wp_enqueue_style( 'showcase-front-styles', get_stylesheet_directory_uri() . '/style-front.css', array(), CHILD_THEME_VERSION );

		}

		//* Add front-page body class
		add_filter( 'body_class', 'showcase_body_class' );
		function showcase_body_class( $classes ) {

			$classes[] = 'front-page';
			return $classes;

		}

		//* Force full width content layout
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Add widgets on front page
		add_action( 'genesis_after_header', 'showcase_front_page_content' );

		//* Add resources section on front page
		add_action( 'genesis_before_footer', 'showcase_front_page_resources', 1 );

		//* Remove the Before Footer Widget Area
		remove_action( 'genesis_before_footer', 'showcase_before_footer_widget_area', 5 );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Remove .site-inner
		add_filter( 'genesis_markup_site-inner', '__return_null' );
		add_filter( 'genesis_markup_content-sidebar-wrap_output', '__return_false' );
		add_filter( 'genesis_markup_content', '__return_null' );
		add_theme_support( 'genesis-structural-wraps', array( 'header', 'footer-widgets', 'footer' ) );

	}

}

//* Add widgets on front page
function showcase_front_page_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'showcase' ) . '</h2>';

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1 flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area' . showcase_widget_area_class( 'front-page-1' ) . '">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3 bg-primary flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area' . showcase_widget_area_class( 'front-page-3' ) . '">',
		'after'  => '</div></div></div>
		',
	) );

	genesis_widget_area( 'front-page-feature', array(
		'before' => '<div class="front-page-feature flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area' . showcase_halves_widget_area_class( 'front-page-feature' ) . '">
		',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4 flexible-widget-area"><div class="wrap"><div class="widget-area">',
		'after'  => '</div></div></div>',
	) );
}

//* Frontpage content
function showcase_front_page_content() {
	echo '<div class="front-page-content front-page-2 flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area">';

	while ( have_posts() ) : the_post();
	the_content();
	endwhile; //resetting the page loop
	wp_reset_query(); //resetting the page query

	echo '</div></div></div>';
}

//* Frontpage content
function showcase_front_page_resources() {
	echo '<div class="front-page-content front-page-resources"><div class="wrap"><div class="flexible-widgets widget-area">';

	echo '<h3 style="text-align: center;">Resources, guides, & inspiration</h3>';

	// Most recent blog post 
	$argsBlog = array(
		'numberposts' => 1,
		'category' => 0,
		'post_status' => 'publish',
	);
	$recent_posts = wp_get_recent_posts( $argsBlog );
	foreach( $recent_posts as $recent ){
		if ( has_post_thumbnail($recent["ID"]) ) {
			
			$thumb_id = get_post_thumbnail_id($recent["ID"]);
			$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'showcase_featured_posts', true);
			$thumb_url = $thumb_url_array[0];

      		echo '<a href="' . get_permalink($recent["ID"]) . '" class="front-page-resources-column">';
      		echo '<div class="front-page-resources-image" style="background-image: url(' . $thumb_url .')"><span class="front-page-resources-type">Latest Blog</span></div>';
      		echo $recent["post_title"];
      		echo '<span class="front-page-resources-link">View blog post &rarr;</span></a>';
    	}
		
	}
	wp_reset_query();

	// Employee handbook template
	echo '<a href="https://joinair.staging.wpengine.com/free-employee-handbook-template/" class="front-page-resources-column">';
	echo '<div class="front-page-resources-image" style="background-image: url(https://joinair.staging.wpengine.com/wp-content/uploads/2017/05/front-page-resources-employee-handbook-template.jpg)"><span class="front-page-resources-type">Free Template</span></div>';
	echo 'Improve onboarding and engagement of new employees with our Employee Handbook template.';
	echo '<span class="front-page-resources-link">View template &rarr;</span></a>';

	// All resources
	echo '<a href="https://joinair.staging.wpengine.com/resources" class="front-page-resources-column">';
	echo '<div class="front-page-resources-image" style="background-image: url(https://joinair.staging.wpengine.com/wp-content/uploads/2017/05/front-page-resources-view-all.jpg)"><span class="front-page-resources-type">Resources & Guides</span></div>';
	echo 'Policies & templates covering all the needs of a growing company. Customizable and downloadable.';
	echo '<span class="front-page-resources-link">View resources &rarr;</span></a>';

	echo '</div></div></div>';
}


//* Run the Genesis function
genesis();
