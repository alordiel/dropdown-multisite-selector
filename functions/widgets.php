<?php
// Creating the widget 
class dms_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID
		'dms_widget', 

		// Widget name
		__('Dropdown Multisite Selector', 'dropdown-multisite-selector'), 

		// Widget description
		array( 'description' => __( 'Shows a select options with site/multisites.', 'dropdown-multisite-selector' ), ) 
		);
	}

	// This is where the action happens
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo do_shortcode('[dms]');
		echo $args['after_widget'];
		
	}

	public function form( $instance ) {
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}

		else {
			$title = __( 'New title', 'dropdown-multisite-selector' );}
		?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

} 

// Register and load the widget
add_action( 'widgets_init', 'dms_load_widget' );
function dms_load_widget() {
	register_widget( 'dms_widget' );
}