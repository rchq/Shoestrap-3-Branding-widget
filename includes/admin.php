<?php

if ( ! defined( 'ABSPATH' ) ) { 
 exit; // Exit if accessed directly
}

/*
 * Shoestrap 3 Branding Widget options
 */
if ( !function_exists( 'shoestrap_hw_module_options' ) ) {
 function shoestrap_hw_module_options( $sections ) {
  $section = array(
   'title' => __( 'Branding Widget', 'shoestrap_hw' ),
   'icon'  => 'el-icon-check-empty  '
  );
		
  $fields[] = array(
   'title'       => __( 'Branding Background Color', 'shoestrap_hw' ),
   'desc'        => __( 'Select the background color for your branding. Default: #EEEEEE.', 'shoestrap_hw' ),
   'id'          => 'branding_widget_bg',
   'default'     => '#eeeeee',
   'compiler'    => true,
   'transparent' => true,
   'type'        => 'color'
  );
			
  $fields[] = array(
   'title'      => __('Branding logo URL', 'shoestrap_hw'),
   'desc'       => __('Set a custom URL', 'shoestrap_hw'),
   'id'         => 'branding_widget_url',
   'validate'   => 'url',
   'type'       => 'text',
  );

  $section['fields'] = $fields;
  $section = apply_filters( 'shoestrap_hw_module_options_modifier', $section );
  $sections[] = $section;
  return $sections;
 }
}
add_filter( 'redux/options/' . SHOESTRAP_OPT_NAME . '/sections', 'shoestrap_hw_module_options', 17 );