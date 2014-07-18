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
		
		if ( shoestrap_getVariable( 'header_widget_toggle' ) == 1 ) {
		?>
	
			<div class="header-widget-wrapper">
				<div class=<?php echo apply_filters( 'shoestrap_navbar_container_class', 'container' ); ?>
					<div class="col-sm-12">
						<?php
            if ( $ss_settings['header_branding'] == 1 ) {
              echo '<a class="brand-logo" href="' . home_url() . '/">' . Shoestrap_Branding::logo() . '</a>';
						}
            ?>
						</div >
				</div >
			</div >
	
		<?php
		}
		
		echo $args['after_widget'];
	}

} // class jb_header_widget


// register jb_header_widget widget
function jb_header_widget_register() {
    register_widget( 'jb_header_widget' );
}
add_action( 'widgets_init', 'jb_header_widget_register' );


// register shoestrap jb_header_widget widget less styles
function jb_header_widget_styles( $bootstrap ) {
	$bg = shoestrap_getVariable( 'header_widget_bg');
	$cl = shoestrap_getVariable( 'header_widget_color' );
	
	return $bootstrap . '
	.header-widget-wrapper {
		color:' .$cl. ';
		background:' .$bg. ';
	}';
}
if ( is_active_widget( '', '', 'jb_header_widget' ) ) {
	add_filter( 'shoestrap_compiler', 'jb_header_widget_styles' );
}
