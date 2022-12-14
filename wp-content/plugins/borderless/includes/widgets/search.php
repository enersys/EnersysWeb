<?php
 
/**
 * Adds Borderless_Widget_Search widget.
 */
class Borderless_Widget_Search extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {

        parent::__construct(
			'borderless_search', // Base ID
			__( 'Borderless - Search', 'borderless' ), // Name
			array( 'description' => __( 'A search form for your site.', 'borderless' ), ) // Args
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
        $button = apply_filters( 'widget_button', $instance['button'] );
        $sizing = apply_filters( 'widget_sizing', $instance['sizing'] );
        $button_text = apply_filters( 'widget_button_text', $instance['button_text'] );
        $button_color = apply_filters( 'widget_button_color', $instance['button_color'] );
        $input_color = apply_filters( 'widget_input_color', $instance['input_color'] );
        $type = apply_filters( 'widget_type', $instance['type'] );
        $placeholder_text = apply_filters( 'widget_placeholder_text', $instance['placeholder_text'] );
        $shape = apply_filters( 'widget_shape', $instance['shape'] );
        $title = apply_filters( 'widget_title', $instance['title'] );

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
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        } ?>
        
        <form method="get" id="borderlesssearchform" class="borderless-search <?php echo $button.' '.$shape.' '.$sizing;?>" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
            
            <?php if ($button == 'borderless-search--left-button') { ?>
                <input class="submit borderless-btn <?php echo $button_color. ' '.$type; ?>" id="searchsubmit" name="submit" type="submit"
                    value="<?php echo $button_text; ?>">
            <?php } ?>
            
            <input class="borderless-search--input <?php echo $input_color; ?>" id="s" name="s" type="text"
                    placeholder="<?php echo $placeholder_text; ?>" value="<?php the_search_query(); ?>">
            
            <?php if ($button == 'borderless-search--right-button') { ?>
                <input class="submit borderless-btn <?php echo $button_color. ' '.$type; ?>" id="searchsubmit" name="submit" type="submit"
                    value="<?php echo $button_text; ?>">
            <?php } ?>
        </form>

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
        $type = isset( $instance['type'] ) ? $instance['type'] : ''; 
        // Button
        if ( isset( $instance[ 'button' ] ) ) {
            $button = $instance[ 'button' ];
        }
        else {
            $button = 'borderless-search--right-button';
        }

        // Button Text
        if ( isset( $instance[ 'button_text' ] ) ) {
            $button_text = $instance[ 'button_text' ];
        }
        else {
            $button_text = __( 'Search', 'borderless' );
        }

        // Button Text
        if ( isset( $instance[ 'sizing' ] ) ) {
            $sizing = $instance[ 'sizing' ];
        }
        else {
            $sizing = '';
        }

        // Color
        if ( isset( $instance[ 'button_color' ] ) ) {
            $button_color = $instance[ 'button_color' ];
        }
        else {
            $button_color = 'borderless-search--btn-primary';
        }

        if ( isset( $instance[ 'input_color' ] ) ) {
            $input_color = $instance[ 'input_color' ];
        }
        else {
            $input_color = 'borderless-search--input-light';
        }

        // Placeholder Text
        if ( isset( $instance[ 'placeholder_text' ] ) ) {
            $placeholder_text = $instance[ 'placeholder_text' ];
        }
        else {
            $placeholder_text = __( 'Search...', 'borderless' );
        }

        // Shape
        if ( isset( $instance[ 'shape' ] ) ) {
            $shape = $instance[ 'shape' ];
        }
        else {
            $shape = 'borderless-search--rounded';
        }

        // Title
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'borderless' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', 'borderless' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_name( 'button_text' ); ?>"><?php _e( 'Button Text:', 'borderless' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_name( 'placeholder_text' ); ?>"><?php _e( 'Placeholder Text:', 'borderless' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'placeholder_text' ); ?>" name="<?php echo $this->get_field_name( 'placeholder_text' ); ?>" type="text" value="<?php echo esc_attr( $placeholder_text ); ?>" />
         </p>
         <p>
			<label for="<?php echo $this->get_field_id('button'); ?>"><?php _e('Button:', 'borderless') ?></label>
			<select id="<?php echo $this->get_field_id('button'); ?>" name="<?php echo $this->get_field_name('button'); ?>" class="widefat">
                <option value='borderless-search--no-button'<?php selected( $button, 'borderless-search--no-button'); ?>><?php _e( 'No Button', 'borderless' ); ?></option>
                <option value='borderless-search--left-button'<?php selected( $button, 'borderless-search--left-button'); ?>><?php _e( 'Left Button', 'borderless' ); ?></option> 
                <option value='borderless-search--right-button'<?php selected( $button, 'borderless-search--right-button'); ?>><?php _e( 'Right Button', 'borderless' ); ?></option> 
			</select>
        </p>
        <p>
        <label for="<?php echo $this->get_field_id('input_color'); ?>"><?php _e('Input Color:', 'borderless') ?></label>
            <select id="<?php echo $this->get_field_id('input_color'); ?>" name="<?php echo $this->get_field_name('input_color'); ?>" class="widefat">
                <option value='borderless-search--input-primary'<?php selected( $input_color, 'borderless-search--input-primary'); ?>><?php _e( 'Primary Color', 'borderless' ); ?></option>
                <option value='borderless-search--input-secondary'<?php selected( $input_color, 'borderless-search--input-secondary'); ?>><?php _e( 'Secondary Color', 'borderless' ); ?></option> 
                <option value='borderless-search--input-tertiary'<?php selected( $input_color, 'borderless-search--input-tertiary'); ?>><?php _e( 'Tertiary Color', 'borderless' ); ?></option> 
                <option value='borderless-search--input-light'<?php selected( $input_color, 'borderless-search--input-light'); ?>><?php _e( 'Light Color', 'borderless' ); ?></option> 
                <option value='borderless-search--input-dark'<?php selected( $input_color, 'borderless-search--input-dark'); ?>><?php _e( 'Dark Color', 'borderless' ); ?></option> 
            </select>
        </p>
        <p>
        <label for="<?php echo $this->get_field_id('button_color'); ?>"><?php _e('Button Color:', 'borderless') ?></label>
            <select id="<?php echo $this->get_field_id('button_color'); ?>" name="<?php echo $this->get_field_name('button_color'); ?>" class="widefat">
                <option value='borderless-btn--primary'<?php selected( $button_color, 'borderless-btn--primary'); ?>><?php _e( 'Primary Color', 'borderless' ); ?></option>
                <option value='borderless-btn--secondary'<?php selected( $button_color, 'borderless-btn--secondary'); ?>><?php _e( 'Secondary Color', 'borderless' ); ?></option> 
                <option value='borderless-btn--tertiary'<?php selected( $button_color, 'borderless-btn--tertiary'); ?>><?php _e( 'Tertiary Color', 'borderless' ); ?></option> 
                <option value='borderless-btn--light'<?php selected( $button_color, 'borderless-btn--light'); ?>><?php _e( 'Light Color', 'borderless' ); ?></option> 
                <option value='borderless-btn--dark'<?php selected( $button_color, 'borderless-btn--dark'); ?>><?php _e( 'Dark Color', 'borderless' ); ?></option> 
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sizing'); ?>"><?php _e('Sizing:', 'borderless') ?></label>
            <select id="<?php echo $this->get_field_id('sizing'); ?>" name="<?php echo $this->get_field_name('sizing'); ?>" class="widefat">
                <option value='borderless-search--sizing-default'<?php selected( $sizing, 'borderless-search--sizing-default'); ?>><?php _e( 'Default', 'borderless' ); ?></option>
                <option value='borderless-search--sizing-sm'<?php selected( $sizing, 'borderless-search--sizing-sm'); ?>><?php _e( 'Small', 'borderless' ); ?></option>
                <option value='borderless-search--sizing-lg'<?php selected( $sizing, 'borderless-search--sizing-lg'); ?>><?php _e( 'Large', 'borderless' ); ?></option> 
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type:', 'borderless') ?></label>
            <select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" class="widefat">
                <option value='borderless-btn--contained'<?php selected( $type, 'borderless-btn--contained'); ?>><?php _e( 'Contained', 'borderless' ); ?></option>
                <option value='borderless-btn--outline'<?php selected( $type, 'borderless-btn--outline'); ?>><?php _e( 'Outline', 'borderless' ); ?></option> 
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('shape'); ?>"><?php _e('Shape:', 'borderless') ?></label>
            <select id="<?php echo $this->get_field_id('shape'); ?>" name="<?php echo $this->get_field_name('shape'); ?>" class="widefat">
                <option value='borderless-search--rounded'<?php selected( $shape, 'borderless-search--rounded'); ?>><?php _e( 'Rounded', 'borderless' ); ?></option>
                <option value='borderless-search--round'<?php selected( $shape, 'borderless-search--round'); ?>><?php _e( 'Round', 'borderless' ); ?></option> 
                <option value='borderless-search--square'<?php selected( $shape, 'borderless-search--square'); ?>><?php _e( 'Square', 'borderless' ); ?></option> 
            </select>
        </p>
    <?php
    }
 
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
        $instance['type'] = ( !empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
        $instance['button'] = ( !empty( $new_instance['button'] ) ) ? strip_tags( $new_instance['button'] ) : '';
        $instance['sizing'] = ( !empty( $new_instance['sizing'] ) ) ? strip_tags( $new_instance['sizing'] ) : '';
        $instance['button_text'] = ( !empty( $new_instance['button_text'] ) ) ? strip_tags( $new_instance['button_text'] ) : '';
        $instance['button_color'] = ( !empty( $new_instance['button_color'] ) ) ? strip_tags( $new_instance['button_color'] ) : '';
        $instance['input_color'] = ( !empty( $new_instance['input_color'] ) ) ? strip_tags( $new_instance['input_color'] ) : '';
        $instance['placeholder_text'] = ( !empty( $new_instance['placeholder_text'] ) ) ? strip_tags( $new_instance['placeholder_text'] ) : '';
        $instance['shape'] = ( !empty( $new_instance['shape'] ) ) ? strip_tags( $new_instance['shape'] ) : '';
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
 
        return $instance;
    }
 
} // class Borderless_Widget_Search
 
// register Borderless_Widget_Search widget
add_action( 'widgets_init', 'register_borderless_search' );

function register_borderless_search() {
    register_widget( 'Borderless_Widget_Search' );
}