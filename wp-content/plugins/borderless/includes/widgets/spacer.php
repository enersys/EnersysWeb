<?php
/**
 * Adds Borderless_Widget_Spacer widget.
 */
class Borderless_Widget_Spacer extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'borderless_spacer', // Base ID
			__( 'Borderless - Spacer', 'borderless' ), // Name
			array( 'description' => __( 'Blank space with custom height.', 'borderless' ), ) // Args
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
		extract( $args );
		$space = apply_filters('widget_space', $instance['space']);
		
		echo $before_widget;
		
		if ( ! empty( $space ) ) { ?>
			
			<div class="borderless-widget borderless-widget--spacer" style="height:<?php echo $instance['space'] ?>;"></div>

		<?php } ?>
		<?php echo $after_widget;
	}
	
	
        /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
        public function form( $instance ) {
			$space = ! empty( $instance['space'] ) ? $instance['space'] : '';        	
        	?>
        	<p>
        		<label for="<?php echo $this->get_field_id( 'space' ); ?>"><?php _e( 'Space - CSS measurement units allowed', 'borderless' ); ?></label> 
        		<input class="widefat" id="<?php echo $this->get_field_id( 'space' ); ?>" name="<?php echo $this->get_field_name( 'space' ); ?>" type="text" value="<?php echo esc_attr( $space ); ?>" />
        	</p>
        <?php }


   /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
   public function update( $new_instance, $old_instance ) {
   	$instance = array();
	$instance['space']    = sanitize_text_field( strip_tags( $new_instance['space'] ) );
   	
   	return $instance;
   }
   
} // class Borderless_Widget_Spacer ends



// register Borderless_Widget_Spacer widget
function register_borderless_spacer() {
	register_widget( 'Borderless_Widget_Spacer' );
}

add_action( 'widgets_init', 'register_borderless_spacer' );