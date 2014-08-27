<?php
if ( ! defined( 'ABSPATH' ) ) { 
 exit; // Exit if accessed directly
}

global $ss_settings;

if ( !empty($ss_settings['branding_widget_url']) ) {
 $url = $ss_settings['branding_widget_url'];
} else {
 $url = home_url();
} 

?>
<div class="<?php echo ss_branding_widget::get_widget_slug();?>-wrapper">
 <div class="<?php echo apply_filters( 'shoestrap_navbar_container_class', 'container' ); ?>">
  <div class="col-sm-12">
   <a class="brand-logo" href="<?php echo $url; ?>/"><?php echo Shoestrap_Branding::logo();?></a>
  </div >
 </div >
</div >