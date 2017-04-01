<?php
/**
 * This file adds the Landing page template to the Showcase Pro Theme.
 *
 * @author JT Grauke
 * @package Showcase Pro Theme
 * @subpackage Customizations
 */

/*
Template Name: App Placeholder
*/


//* Add full-width body class to the head
add_filter( 'body_class', 'showcase_add_body_class' );
function showcase_add_body_class( $classes ) {

	$classes[] = 'app-placeholder	';
	return $classes;

}

get_header();

echo '<div class="content-sidebar-wrap">';

while ( have_posts() ) : the_post();
the_content();
endwhile; //resetting the page loop
wp_reset_query(); //resetting the page query

genesis_widget_area( 'app-vote-button', array(
	'before' => '',
	'after'  => '',
) );

echo '</div>';

get_footer();
