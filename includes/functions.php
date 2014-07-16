<?php
/**
 * Adds jb_header_widget widget.
 */
class jb_header_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'jb_header_widget', // Base ID
			__('Shoestrap: Header', 'text_domain'), // Name
			array( 'description' => __( 'Displays the logo from Shoestrap', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $ss_settings;

		echo $args['before_widget'];
		
		if ( shoestrap_getVariable( 'header_widget_toggle' ) == 1 ) :
			echo '<div class="before-main-wrapper">';
	
			if ( $ss_settings['site_style'] == 'boxed' ) :
				echo '<div class="container header-boxed">';
			endif;
	
			echo '<div class="header-widget-wrapper">';
	
			if ( $ss_settings['site_style'] == 'wide' ) :
				echo '<div class="container">';
			endif;
	
			if ( $ss_settings['header_branding'] == 1 ) :
				echo '<a class="brand-logo" href="' . home_url() . '/">' . Shoestrap_Branding::logo() . '</a>';
			endif;
	
			if ( $ss_settings['header_branding'] == 1 ) :
				$pullclass = ' class="pull-right"';
			else :
				$pullclass = null;
			endif;
	
			if ( $ss_settings['site_style'] == 'wide' ) :
				echo '</div >';
			endif;
	
			echo '</div >';
	
			if ( $ss_settings['site_style'] == 'boxed' ) :
				echo '</div >';
			endif;
	
			echo '</div >';
		endif;
		
		echo $args['after_widget'];
	}

} // class jb_header_widget


// register jb_header_widget widget
function jb_header_widget_register() {
    register_widget( 'jb_header_widget' );
}
add_action( 'widgets_init', 'jb_header_widget_register' );


// register shoestrap jb_header_widget widget css styles
function shoestrap_header_widget_css() {
  $bg = shoestrap_getVariable( 'header_widget_bg');
  $cl = shoestrap_getVariable( 'header_widget_color' );
  
  $header_margin_top    = shoestrap_getVariable( 'header_widget_margin_top' );
  $header_margin_bottom = shoestrap_getVariable( 'header_widget_margin_bottom' );
	
	if ( shoestrap_getVariable( 'header_widget_toggle' ) == 1 ) {
		$style = '.header-widget-wrapper{';
			$style .= 'color: '.$cl.';';
			$style .= 'background: '.$bg.';';
			if ( shoestrap_getVariable( 'header_margin_widget_toggle' ) == 1 ) {
				$style .= 'margin-top:'.$header_margin_top.'px;';
				$style .= 'margin-bottom:'.$header_margin_bottom.'px;';
			}
		$style .= '}';
	}

	wp_add_inline_style( 'shoestrap_css', $style );

}
add_action( 'wp_enqueue_scripts', 'shoestrap_header_widget_css', 102 );
