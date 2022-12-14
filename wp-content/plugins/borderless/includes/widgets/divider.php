<?php
/**
 * Adds Borderless_Widget_Divider widget.
 */
class Borderless_Widget_Divider extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'borderless_divider', // Base ID
			__( 'Borderless - Divider', 'borderless' ), // Name
			array( 'description' => __( 'Divider allows add horizontal or vertical line between elements.', 'borderless' ), ) // Args
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
		$axis = apply_filters('widget_axis', $instance['axis']);
		$color = apply_filters('widget_color', $instance['color']);
		$size = apply_filters('widget_size', $instance['size']);
		$space = apply_filters('widget_space', $instance['space']);

		// Retrieve data from the database.
        $options = get_option( 'borderless' );
        $borderless_primary_color = isset( $options['primary_color'] ) ? $options['primary_color'] : '#0000FF'; //Primary Color
        $borderless_secondary_color = isset( $options['secondary_color'] ) ? $options['secondary_color'] : '#FF6819'; //Secondary Color
        $borderless_tertiary_color = isset( $options['tertiary_color'] ) ? $options['tertiary_color'] : '#3FCC14'; //Accent Color
        $borderless_text_color = isset( $options['text_color'] ) ? $options['text_color'] : '#333333'; //Text Color
        
        ?>
        <style type="text/css">
        :root {
            --borderless-color-primary-lighter: <?php echo luminanceLight ( $borderless_primary_color, 0.4 ); ?>;
            --borderless-color-primary-light: <?php echo luminanceLight ( $borderless_primary_color, 0.2 ); ?>;
            --borderless-color-primary: <?php echo $borderless_primary_color; ?>;
            --borderless-color-primary-dark: <?php echo luminanceDark ( $borderless_primary_color, 0.2 ); ?>;
            --borderless-color-primary-darker: <?php echo luminanceDark ( $borderless_primary_color, 0.4 ); ?>;
            
            --borderless-color-secondary-lighter: <?php echo luminanceLight ( $borderless_secondary_color, 0.4 ); ?>;
            --borderless-color-secondary-light: <?php echo luminanceLight ( $borderless_secondary_color, 0.2 ); ?>;
            --borderless-color-secondary: <?php echo $borderless_secondary_color; ?>;
            --borderless-color-secondary-dark: <?php echo luminanceDark ( $borderless_secondary_color, 0.2 ); ?>;
            --borderless-color-secondary-darker: <?php echo luminanceDark ( $borderless_secondary_color, 0.4 ); ?>;
            
            --borderless-color-tertiary-lighter: <?php echo luminanceLight ( $borderless_tertiary_color, 0.4 ); ?>;
            --borderless-color-tertiary-light: <?php echo luminanceLight ( $borderless_tertiary_color, 0.2 ); ?>;
            --borderless-color-tertiary: <?php echo $borderless_tertiary_color; ?>;
            --borderless-color-tertiary-dark: <?php echo luminanceDark ( $borderless_tertiary_color, 0.2 ); ?>;
            --borderless-color-tertiary-darker: <?php echo luminanceDark ( $borderless_tertiary_color, 0.4 ); ?>;
            
            --borderless-text-color: <?php echo $borderless_text_color; ?>;
        }
        </style>
        <?php
		
		echo $before_widget;
		
		if ( $axis == 'borderless-divider--horizontal' ) {
		$size = 'width:'.$size.';';
		$space = 'margin:'.$space.' 0;';
		} else if ( $axis == 'borderless-divider--vertical' ) {
			$size = 'height:'.$size.';';
			$space = 'margin:0 '.$space.';';
		} ?>
			
		<div class="borderless-divider <?php echo $axis.' '.$color; ?>" style="<?php echo $size.' '.$space; ?>"></div>

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
			$axis = isset( $instance['axis'] ) ? $instance['axis'] : 'divider--horizontal';
			$color = isset( $instance['color'] ) ? $instance['color'] : 'borderless-divider--primary';
			$size = isset( $instance['size'] ) ? $instance['size'] : '2rem';
			$space = isset( $instance['space'] ) ? $instance['space'] : '1rem';        	
        	?>

			<p>
        		<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Size - CSS measurement units allowed', 'borderless' ); ?></label> 
        		<input class="widefat" id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" type="text" value="<?php echo esc_attr( $size ); ?>" />
			</p>
        	<p>
        		<label for="<?php echo $this->get_field_id( 'space' ); ?>"><?php _e( 'Space - CSS measurement units allowed', 'borderless' ); ?></label> 
        		<input class="widefat" id="<?php echo $this->get_field_id( 'space' ); ?>" name="<?php echo $this->get_field_name( 'space' ); ?>" type="text" value="<?php echo esc_attr( $space ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('axis'); ?>"><?php _e('Axis:', 'borderless') ?></label>
				<select id="<?php echo $this->get_field_id('axis'); ?>" name="<?php echo $this->get_field_name('axis'); ?>" class="widefat">
					<option value='borderless-divider--horizontal'<?php selected( $axis, 'divider--horizontal'); ?>><?php _e( 'Horizontal', 'borderless' ); ?></option>
					<option value='borderless-divider--vertical'<?php selected( $axis, 'divider--vertical'); ?>><?php _e( 'Vertical', 'borderless' ); ?></option> 
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Color:', 'borderless') ?></label>
				<select id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>" class="widefat">
					<option value='borderless-divider--primary'<?php selected( $color, 'borderless-divider--primary'); ?>><?php _e( 'Primary Color', 'borderless' ); ?></option>
					<option value='borderless-divider--secondary'<?php selected( $color, 'borderless-divider--secondary'); ?>><?php _e( 'Secondary Color', 'borderless' ); ?></option> 
					<option value='borderless-divider--tertiary'<?php selected( $color, 'borderless-divider--tertiary'); ?>><?php _e( 'Tertiary Color', 'borderless' ); ?></option> 
					<option value='borderless-divider--light'<?php selected( $color, 'borderless-divider--light'); ?>><?php _e( 'Light Color', 'borderless' ); ?></option> 
					<option value='borderless-divider--dark'<?php selected( $color, 'borderless-divider--dark'); ?>><?php _e( 'Dark Color', 'borderless' ); ?></option> 
				</select>
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
		$instance['axis'] = ( !empty( $new_instance['axis'] ) ) ? strip_tags( $new_instance['axis'] ) : '';
		$instance['color'] = ( !empty( $new_instance['color'] ) ) ? strip_tags( $new_instance['color'] ) : '';
		$instance['size'] = ( !empty( $new_instance['size'] ) ) ? strip_tags( $new_instance['size'] ) : '';
   		$instance['space'] = ( !empty( $new_instance['space'] ) ) ? strip_tags( $new_instance['space'] ) : '';
   	
   	return $instance;
   }
   
} // class Borderless_Widget_Divider ends



// register Borderless_Widget_Divider widget
function register_borderless_divider() {
	register_widget( 'Borderless_Widget_Divider' );
}
add_action( 'widgets_init', 'register_borderless_divider' );