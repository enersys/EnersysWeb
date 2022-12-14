<?php
/**
* Add Button widget.
*/
class Borderless_Widget_Button extends WP_Widget {
    
    /**
    * Register widget with WordPress.
    */
    function __construct() {
        parent::__construct(
            'borderless_button', // Base ID
            __( 'Borderless - Button', 'borderless' ), // Name
            array( 'description' => __( 'Create an infinite styles buttons.', 'borderless' ), ) // Args
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
        $color = apply_filters( 'widget_color', $instance['color'] );
        $type = apply_filters( 'widget_type', $instance['type'] );
        $shape = apply_filters( 'widget_shape', $instance['shape'] );
        $size = apply_filters( 'widget_size', $instance['size'] );
        $button_title = apply_filters( 'widget_button_title', $instance['button_title'] );
        $url = apply_filters( 'widget_url', $instance['url'] );
        $block = apply_filters( 'widget_block', $instance['block'] );
        $no_follow = apply_filters( 'widget_no_follow', $instance['no_follow'] );
        $blank = apply_filters( 'widget_blank', $instance['blank'] );
        
        $button_title = $button_title ?: 'Borderless';
        $url = $url ?: 'https://wpborderless.com';
        $no_follow = ( $no_follow == '1' ) ? 'rel="nofollow"' : '';
        $block = ( $block == '1' ) ? 'borderless-btn--block' : '';
        $blank = ( $blank == '1' ) ? 'target="_blank"' : '';
        
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
        
        echo $before_widget; ?>
        
        <!-- front display here -->
        <a href="<?php echo $url; ?>" <?php echo $blank.' '.$no_follow; ?> class="borderless-btn borderless-widget-button <?php echo $type.' '.$shape.' '.$size.' '.$color.' '.$block; ?>" role="button"><?php echo $button_title; ?></a>
        
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
        $color = isset( $instance['color'] ) ? $instance['color'] : '';
        $shape = isset( $instance['shape'] ) ? $instance['shape'] : '';
        $size = isset( $instance['size'] ) ? $instance['size'] : '';
        $url = isset( $instance['url'] ) ? $instance['url'] : '';
        $block = isset( $instance['block'] ) ? $instance['block'] : '';
        $blank = isset( $instance['blank'] ) ? $instance['blank'] : ''; 
        $no_follow = isset( $instance['no_follow'] ) ? $instance['no_follow'] : ''; 
        $button_title = isset( $instance['button_title'] ) ? $instance['button_title'] : '';  
        
        ?>
        
        <p>
        <label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Color:', 'borderless') ?></label>
        <select id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>" class="widefat">
        <option value='borderless-btn--primary'<?php selected( $color, 'borderless-btn--primary'); ?>><?php _e( 'Primary Color', 'borderless' ); ?></option>
        <option value='borderless-btn--secondary'<?php selected( $color, 'borderless-btn--secondary'); ?>><?php _e( 'Secondary Color', 'borderless' ); ?></option> 
        <option value='borderless-btn--tertiary'<?php selected( $color, 'borderless-btn--tertiary'); ?>><?php _e( 'Tertiary Color', 'borderless' ); ?></option> 
        <option value='borderless-btn--light'<?php selected( $color, 'borderless-btn--light'); ?>><?php _e( 'Light Color', 'borderless' ); ?></option> 
        <option value='borderless-btn--dark'<?php selected( $color, 'borderless-btn--dark'); ?>><?php _e( 'Dark Color', 'borderless' ); ?></option> 
        </select>
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type:', 'borderless') ?></label>
        <select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" class="widefat">
        <option value='borderless-btn--contained'<?php selected( $type, 'borderless-btn--contained'); ?>><?php _e( 'Contained', 'borderless' ); ?></option>
        <option value='borderless-btn--outline'<?php selected( $type, 'borderless-btn--outline'); ?>><?php _e( 'Outline', 'borderless' ); ?></option> 
        <option value='borderless-btn--text'<?php selected( $type, 'borderless-btn--text'); ?>><?php _e( 'Text', 'borderless' ); ?></option> 
        </select>
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('shape'); ?>"><?php _e('Shape:', 'borderless') ?></label>
        <select id="<?php echo $this->get_field_id('shape'); ?>" name="<?php echo $this->get_field_name('shape'); ?>" class="widefat">
        <option value='borderless-btn--rounded'<?php selected( $shape, 'borderless-btn--rounded'); ?>><?php _e( 'Rounded', 'borderless' ); ?></option>
        <option value='borderless-btn--round'<?php selected( $shape, 'borderless-btn--round'); ?>><?php _e( 'Round', 'borderless' ); ?></option> 
        <option value='borderless-btn--square'<?php selected( $shape, 'borderless-btn--square'); ?>><?php _e( 'Square', 'borderless' ); ?></option> 
        </select>
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Size:', 'borderless') ?></label>
        <select id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" class="widefat">
        <option value=''<?php selected( $size, ''); ?>><?php _e( 'Default', 'borderless' ); ?></option>
        <option value='borderless-btn--sm'<?php selected( $size, 'borderless-btn--sm'); ?>><?php _e( 'Small', 'borderless' ); ?></option> 
        <option value='borderless-btn--lg'<?php selected( $size, 'borderless-btn--lg'); ?>><?php _e( 'Large', 'borderless' ); ?></option> 
        <option value='borderless-btn--block'<?php selected( $size, 'borderless-btn--block'); ?>><?php _e( 'Block', 'borderless' ); ?></option> 
        </select>
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_name( 'button_title' ); ?>"><?php _e( 'Title:', 'borderless' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'button_title' ); ?>" name="<?php echo $this->get_field_name( 'button_title' ); ?>" type="text" value="<?php echo esc_attr( $button_title ); ?>" />
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_name( 'url' ); ?>"><?php _e( 'URL:', 'borderless' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
        </p>
        
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'block' ) ); ?>"><?php _e( 'Full Width', 'borderless' ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'block' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'block' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $block ); ?> />
        </p>
        
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'no_follow' ) ); ?>"><?php _e( 'No Follow', 'borderless' ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'no_follow' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no_follow' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $no_follow ); ?> />
        </p>
        
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'blank' ) ); ?>"><?php _e( 'Open in new window', 'borderless' ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'blank' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'blank' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $blank ); ?> />
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
            $instance['type'] = ( !empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
            $instance['color'] = ( !empty( $new_instance['color'] ) ) ? strip_tags( $new_instance['color'] ) : '';
            $instance['button_title'] = ( !empty( $new_instance['button_title'] ) ) ? strip_tags( $new_instance['button_title'] ) : '';
            $instance['shape'] = ( !empty( $new_instance['shape'] ) ) ? strip_tags( $new_instance['shape'] ) : '';
            $instance['size'] = ( !empty( $new_instance['size'] ) ) ? strip_tags( $new_instance['size'] ) : '';
            $instance['url'] = ( !empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
            $instance['block'] = ( !empty( $new_instance['block'] ) ) ? strip_tags( $new_instance['block'] ) : '';
            $instance['no_follow'] = ( !empty( $new_instance['no_follow'] ) ) ? strip_tags( $new_instance['no_follow'] ) : '';
            $instance['blank'] = ( !empty( $new_instance['blank'] ) ) ? strip_tags( $new_instance['blank'] ) : '';
            return $instance;
        }
    }
    
    // register Borderless_Widget_Button widget
    add_action( 'widgets_init', 'register_borderless_button' );
    
    function register_borderless_button() {
        register_widget( 'Borderless_Widget_Button' );
    }