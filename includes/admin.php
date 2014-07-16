<?php


/*
 * Shoestrap 3 Header Widget options
 */
if ( !function_exists( 'shoestrap_hw_module_options' ) ) :
function shoestrap_hw_module_options( $sections ) {


	$section = array(
		'title' => __( 'Header Widget', 'shoestrap_hw' ),
		'icon'  => 'el-icon-check-empty  '
	);

    $fields[] = array(
      "title"      => __("Header Background Color", "shoestrap_hw"),
      "desc"      => __("Select the background color for your header. Default: #EEEEEE.", "shoestrap_hw"),
      "id"        => "header_widget_bg",
      "std"       => "#EEEEEE",
      "customizer"=> array(),
      "type"      => "color",
			"fold"      => "header_widget_toggle"
    );

    $fields[] = array(
      "title"      => __("Header Text Color", "shoestrap_hw"),
      "desc"      => __("Select the text color for your header. Default: #333333.", "shoestrap_hw"),
      "id"        => "header_widget_color",
      "std"       => "#333333",
      "customizer"=> array(),
      "type"      => "color",
			"fold"      => "header_widget_toggle"
    );
		
	$section['fields'] = $fields;

	$section = apply_filters( 'shoestrap_hw_module_options_modifier', $section );
	
	$sections[] = $section;
	return $sections;
}
add_filter( 'redux/options/' . REDUX_OPT_NAME . '/sections', 'shoestrap_hw_module_options' );
endif;
