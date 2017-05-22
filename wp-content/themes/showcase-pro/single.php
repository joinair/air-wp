<?php

/**
 * Edits to the single page
 *
 * @package Showcase Pro
 * @author  JT Grauke
 * @link    http://my.studiopress.com/themes/showcase/
 * @license GPL2-0+
 */

$categories=get_the_category();
if(isset($categories[0]->cat_ID) && !empty($categories[0]->cat_ID) && $categories[0]->cat_ID==33){
    
  
remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action( 'genesis_before_post_content', 'genesis_post_info' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );
add_filter( 'genesis_post_info', 'remove_post_info_multiple_pages' );
add_action( 'genesis_entry_content', 'custom_entry_content_policy' );// Add custom loop
add_shortcode('get_related_posts', 'get_related_posts_data');
add_action( 'genesis_before_footer', 'places_to_work_before_footer_widget_area', 4 );
//remove_action( 'genesis_footer', 'genesis_do_footer' );



}else{
//* Remove the entry meta
remove_action( 'genesis_entry_header', 'genesis_post_info', 8 );

}
function custom_entry_content_policy() {

echo '<script>var catObj =jQuery(".entry-categories");var a_data = catObj.find("a")[0];catObj.html(a_data);catObj.show();jQuery(".show-small-description button").on("click", function() {jQuery(".small-box-description").toggleClass("open");jQuery(".small-box-description button").hide() });</script>';    
echo '<style>header.entry-header{display:none;}.entry-categories{display:none;}.bg-primary a{color: #64adf5;}.small-box-description>div:before{display: none;}.page-template-page_blog .entry, .blog .entry, .archive .entry, .single-post .entry {margin-bottom: 0px;padding: 40px 0 0px;border-bottom:none;}</style>';
    the_content();
    
}
function places_to_work_before_footer_widget_area() {
	
echo'<div class="work_block"><div class="wrap"><div class="heading"><h4>Build great places to work</h4><p>Smart HR software designed for small & medium businesses. <a href="'.get_site_url().'/features/">Learn More</a></p></div><div class="work_details_image"><img src="'.get_site_url().'/wp-content/uploads/2017/05/work.png" alt=""/></div></div></div>';
	
}
function get_related_posts_data() {
//Create a standard wordpress loop

$categories = get_the_category(get_the_ID());
if ( $categories ) {
    $category_ids = array();
    foreach ( $categories as $individual_category ) {
        $cat_name=$individual_category->name;
        $category_ids[] = $individual_category->term_id;
    }
}   
$args=array(
        'category__in' => $category_ids,
        'post__not_in' => array(0),
        'showposts'=>3 // Number of related posts that will be shown.
        
    );
    $related = new wp_query( $args );
    
if( $related ) {
   $each_post_data='<div class="policies_block"><div class="policies_heading"><h4>Related: <span>'. strtoupper($cat_name).'</span></h4></div><div class="vc_row wpb_row column_row-fluid clearfix">';
   while( $related->have_posts() ) {  
   $related->the_post();
   // setup_postdata($post); 
   $content_data=wp_trim_words( get_the_content(), 18, '');
   $the_content = array("[vc_row]","[vc_column]","[vc_column_text]","[/VC_COLUMN]");
   $is_found=0;
   foreach($the_content as $taggs){
       if(strpos($content_data,$taggs)!=false){
          $content_data= str_replace($taggs,"",$content_data);
          
           $is_found=1;
       }
   }
   if($is_found==0){
       $content_data=wp_trim_words( get_the_content(), 15, '');
   }else{
        $content_data= str_replace("[vc_row]","",$content_data);
   }
    $each_post_data.='<div class="wpb_column vc_col-sm-4"><div class="vc_column-inner blog_box resources_archive_block"><div class="wpb_wrapper"><div class=""><a href="'.get_the_permalink().'"><div class="blog_thumnail">'
        . '<img class="aligncenter" height="65px" src="'.get_site_url().'/wp-content/uploads/2017/05/file_icon.png" />
       </div><div class="blog_details"><span class="time"></span><h5 class="p1" style="margin-bottom: 10px;">'.wp_trim_words( get_the_title(), 9, '').'</h5>
<p class="p1" style="margin-bottom: 10px;">'.$content_data.'</p></div></a></div></div></div></div>';			

    }
//wp_reset_postdata();
}
echo $each_post_data.'</div></div>';
//echo'<div class="work_block"><div class="heading"><h4>Build great places to work</h4><p>Smart HR software designed for small & medium businesses. <a href="#">Learn More</a></p></div></div>';
}

function remove_post_info_multiple_pages($post_info) {

	$post_info = '[post_categories]';
	return $post_info;
  

}




genesis();