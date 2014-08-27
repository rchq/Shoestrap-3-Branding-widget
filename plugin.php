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

if ( !defined( 'REDUX_OPT_NAME' ) )
 define( 'REDUX_OPT_NAME', 'shoestrap' );

// plugin folder url
if ( !defined( 'S3HW_PLUGIN_URL' ) )
 define( 'S3HW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// plugin folder path
if ( !defined( 'S3HW_PLUGIN_DIR' ) )
 define( 'S3HW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// plugin root file
if ( !defined( 'S3HW_PLUGIN_FILE' ) )
 define( 'S3HW_PLUGIN_FILE', __FILE__ );

function shoestrap_hw_include_files() {
 include_once( S3HW_PLUGIN_DIR . 'includes/admin.php' );
 //include_once( S3HW_PLUGIN_DIR . 'includes/functions.php' );
}
add_action( 'shoestrap_include_files', 'shoestrap_hw_include_files' );

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

		// Add style to the shoestrap compiler
		add_filter( 'shoestrap_compiler', array( $this, 'styles' ) );
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

  ob_start();
  include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
  $widget_string .= ob_get_clean();
  $widget_string .= $after_widget;

  $cache[ $args['widget_id'] ] = $widget_string;

  wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

  print $widget_string;

 } // end widget

	
 /**
	 * Register widget less styles
  */
 public function styles( $bootstrap ) {
  global $ss_settings;
	
  $bg = $ss_settings['branding_widget_bg'];

  return $bootstrap . '
	  .' . $this->get_widget_slug() . '-wrapper {
    background: ' . $bg . ';
   }';
 }
	
	
}

add_action( 'widgets_init', create_function( '', 'register_widget("ss_branding_widget");' ) );