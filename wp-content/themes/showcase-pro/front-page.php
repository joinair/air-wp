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
		add_action( 'genesis_after_header', 'showcase_front_page_widgets' );

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
		<div class="testimonials-logo">
		<img src="https://joinair.com/wp-content/themes/showcase-pro/images/air_hr_software_customers_zest.png" alt="Air HR software customer zest digital">
		<img src="https://joinair.com/wp-content/themes/showcase-pro/images/air_hr_software_customers_powershift.png" alt="Air HR software customer powershift">
		<img src="https://joinair.com/wp-content/themes/showcase-pro/images/air_hr_software_customers_clive_reeves.png" alt="Air HR software customer clive reeves">
		<img src="https://joinair.com/wp-content/themes/showcase-pro/images/air_hr_software_customers_blu_tel.png" alt="Air HR software customer blu tel">
		<img src="https://joinair.com/wp-content/themes/showcase-pro/images/air_hr_software_customers_jc_social_media.png" alt="Air HR software customer jc social media">
		</div>
		',
	) );

	genesis_widget_area( 'front-page-feature', array(
		'before' => '<div class="front-page-feature flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area' . showcase_halves_widget_area_class( 'front-page-feature' ) . '">
		',
		'after'  => '</div></div></div>',
	) );

echo '<div class="front-page-content front-page-2 flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area">';

while ( have_posts() ) : the_post();
the_content();
endwhile; //resetting the page loop
wp_reset_query(); //resetting the page query

echo '</div></div></div>',



	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4 flexible-widget-area"><div class="wrap"><div class="widget-area">',
		'after'  => '</div></div></div>',
	) );

}



//* Run the Genesis function
genesis();
