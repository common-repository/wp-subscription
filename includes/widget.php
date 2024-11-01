<?php
// Creating the widget 
class wpspwidget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'wpspwidget', 

// Widget name will appear in UI
__('WP-Subscription', 'wp-subscription'), 

// Widget description
array( 'description' => __( 'Subscription Form', 'wp-subscription' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
 $form_id= $index= $atts['id']= $instance['wp_subscription_title'];
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];
global $wpdb;
$page_id=$post_page_title_ID->ID;
// This is where you run the code and display the output

 include('user/formSetting.php');
 include('user/assets.php');
 echo '<style>' . $wp_subscription_appearance_custom_css . '</style>';
  echo '<div class="bootstrap-wrapper support_bs">';
  include('user/views/ajax/defualt.php');
   echo '</div>';
   include('user/script.php');     
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Subscription ', 'wp-subscription' );
}
if ( isset( $instance[ 'wp_subscription_title' ] ) ) {
$wp_subscription_title = $instance[ 'wp_subscription_title' ];
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
global $wpdb;
		$clistings_dp = $wpdb->get_results("SELECT id,wp_subscription_title FROM {$wpdb->prefix}wpsp_forms");       
		
		$return_dp='<select name="'.$this->get_field_name( 'wp_subscription_title' ).' " class="widefat" id="'.$this->get_field_id( '	wp_subscription_title' ).'" >';               
		foreach ($clistings_dp as $clisting_dp){		
		$selected= ($wp_subscription_title==$clisting_dp->id) ? 'selected' :'';
			$return_dp.='<option '.$selected.' value="'.$clisting_dp->id.'">'.$clisting_dp->wp_subscription_title.'</option>';      
		  
		}
			$return_dp.='</select>';       
		echo $return_dp;
		
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['wp_subscription_title'] = ( ! empty( $new_instance['wp_subscription_title'] ) ) ? strip_tags( $new_instance['wp_subscription_title'] ) : '';
return $instance;
}
} // Class wpbdpwidget ends here




// Register and load the widget
function wpbdpwidget_form() {
	register_widget( 'wpspwidget' );       
}

add_action( 'widgets_init', 'wpbdpwidget_form' );