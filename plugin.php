<?php
/**
 * Plugin Name: Shoestrap Branding widget
 * Plugin URI:  http://wpmu.io
 * Description: Adds branding widget to the Shoestrap theme.
 * 
 * Version:     0.2
 * Author:      Jon Brim
 * Author URI:  http://rchq.com
	*
	* @copyright 2014 Jon Brim
	*
*/

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

class ss_branding_widget extends WP_Widget {
	
	// Sets the widgets slug
	protected $widget_slug = 'branding_widget';

	public function __construct() {
  parent::__construct(
   $this->get_widget_slug(),
   __( 'Shoestrap: Branding', $this->get_widget_slug() ),
   array(
    'classname'   => $this->get_widget_slug().'-class',
    'description' => __( 'Displays the logo from Shoestrap.', $this->get_widget_slug() )
   )
  );
		
		// Refreshing the widget's cached output with each new post
		add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

 }
	
	
 /**
  * Return the widget slug.
  */
 public function get_widget_slug() {
  return $this->widget_slug;
 }


 /**
  * Outputs the content of the widget.
  *
  */
 public function widget( $args, $instance ) {
		
  // Check if there is a cached output
  $cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

  if ( !is_array( $cache ) ) {
   $cache = array();
  }

  if ( ! isset ( $args['widget_id'] ) ) {
   $args['widget_id'] = $this->id;
		}

  if ( isset ( $cache[ $args['widget_id'] ] ) ) {
   return print $cache[ $args['widget_id'] ];
		}
		
  extract( $args, EXTR_SKIP );

  $widget_string = $before_widget;
		
  // pull urll from backend
		if ( !empty( $instance['url'] ) ) {
			$url = $instance['url'];
		} else {
			$url = home_url();
		} 
		
  ob_start();
  include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
  $widget_string .= ob_get_clean();
  $widget_string .= $after_widget;

  $cache[ $args['widget_id'] ] = $widget_string;

  wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

  print $widget_string;

 } // end widget
	
	
 public function flush_widget_cache() 
 {
  wp_cache_delete( $this->get_widget_slug(), 'widget' );
 }
	
	
 /**
  * Processes the widget's options to be saved.
  *
  */
 public function update( $new_instance, $old_instance ) {

  $instance = $old_instance;

  $instance['url'] = strip_tags( $new_instance['url'] );

  return $instance;

 } // end widget
	
	
 /**
  * Generates the administration form for the widget.
  *
  */
 public function form( $instance ) {

  $url = get_site_url();
		
  //Set up some default widget settings.
  $defaults = array( 
		 'title'       => 'URL:',
		 'url'         => '',
			'placeholder' => $url,
		);

  $instance = wp_parse_args(
   (array) $instance, $defaults
  );

  // Display the admin form
  include( plugin_dir_path(__FILE__) . 'views/admin.php' );

 } // end form
	
	
}
add_action( 'widgets_init', create_function( '', 'register_widget("ss_branding_widget");' ) );