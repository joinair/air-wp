<?php
/**
 * This file adds the Landing page template to the Showcase Pro Theme.
 *
 * @author JT Grauke
 * @package Showcase Pro Theme
 * @subpackage Customizations
 */

/*
Template Name: App
*/


//* Add full-width body class to the head
add_filter( 'body_class', 'showcase_add_body_class' );
function showcase_add_body_class( $classes ) {

	$classes[] = 'app-page';
	return $classes;

}

//* Run the Genesis loop
genesis();
