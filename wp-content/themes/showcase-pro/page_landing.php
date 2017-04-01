<?php
/**
 * This file adds the Landing page template to the Showcase Pro Theme.
 *
 * @author JT Grauke
 * @package Showcase Pro Theme
 */

/*
Template Name: Landing
*/

//* Add landing body class to the head
add_filter( 'body_class', 'showcase_add_body_class' );
function showcase_add_body_class( $classes ) {

	$classes[] = 'showcase-landing';
	return $classes;

}

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

?>

<div class="landing-header">
	<a href="<?php echo get_home_url(); ?>" class="landing-logo"><img src="<?php echo( get_header_image() ); ?>" alt="<?php echo( get_bloginfo( 'title' ) ); ?>" width="130" height="55" /></a>
</div>

<?php

//* Remove navigation
remove_theme_support( 'genesis-menus' );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the Before Footer Widget Area
remove_action( 'genesis_before_footer', 'showcase_before_footer_widget_area', 5 );

//* Remove site footer widgets
remove_theme_support( 'genesis-footer-widgets' );

//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );


//* Run the Genesis loop
genesis();

?>

<div class="landing-footer">
	<h4>Build great places to work</h4>
	<p>Smart HR software designed for small &amp; medium businesses. <a href="<?php echo get_home_url(); ?>">Learn more &rarr;</a></p>
	<a href="<?php echo get_home_url(); ?>" class="landing-logo"><img src="<?php echo( get_stylesheet_directory_uri() ); ?>/images/air-hr-software-dashboard-people-directory.png" alt="<?php echo( get_bloginfo( 'title' ) ); ?>" width="710" height="229" /></a>
</div>

<?php
