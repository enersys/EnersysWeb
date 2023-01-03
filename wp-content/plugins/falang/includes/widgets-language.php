<?php

use Falang\Model\Falang_Model;
/**
 * The language switcher widget
 *
 * @since 0.1
 */
class Falang_Widget_Language_Switcher extends WP_Widget {

	/**
	 * Holds widget settings defaults options, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;


	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct(
			'falang',
			__( 'Falang Language Switcher', 'falang' ),
			array(
				'description'                 => __( 'Displays a language switcher', 'falang' ),
				'customize_selective_refresh' => true,
			)
		);

		//set up default options
		$this->defaults = array(
			'title'         => '',
			'display_name'	=> 1,
			'display_flags' => 0,
			'positioning'   => 'h', // vertical|horizontal
			'display_type'  => 'list', // types: list: vertical or horizontal list, select: selectbox
			'hide_current'  => 1
		);

	}

	/**
	 * Displays the widget
	 *
	 * @since 0.1
	 *
	 * @param array $args     Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {
		//TODO display message if language switcher not activated (see sublanguage)

		extract( $args );

		$fswicher = new \Falang\Core\Language_Switcher($instance);

		/** Merge with defaults */
		$this->instance = wp_parse_args( (array) $instance, $this->defaults );


		$title = empty( $instance['title'] ) ? '' : $instance['title'];
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo $fswicher->display_switcher();

		echo $args['after_widget'];
	}

	/**
	 * Displays the widget form
	 *
	 * @since 1.0
	 *
	 * @param array $instance Current settings
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags( $instance['title'] );

		?>
		<!-- title -->
		<p>
           <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo esc_html__( 'Title', 'falang' ); ?>:</label>
			<input class="widefat"  type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<!-- display type -->
		<p>
			<label for="<?php echo $this->get_field_id( 'display_type' ); ?>"><?php _e( 'Display as', 'falang' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'display_type' ); ?>" name="<?php echo $this->get_field_name( 'display_type' ); ?>">
				<option value="list" <?php selected( 'list', $instance['display_type'] ); ?>><?php _e( 'List (vertical or horizontal)', 'falang' ); ?></option>
<!--				<option value="select" --><?php //selected( 'select', $instance['display_type'] ); ?><!-->--><?php //_e( 'Select Box', 'falang' ); ?><!--</option>-->
			</select>
		</p>

		<!-- positioning -->
		<p <?php echo ($instance['display_type'] == 'select' ? 'style="display: none;"' : ''); ?>>
			<label for="<?php echo $this->get_field_id( 'positioning' ); ?>"><?php _e( 'Positioning', 'falang' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'positioning' ); ?>" name="<?php echo $this->get_field_name( 'positioning' ); ?>">
				<option value="h" <?php selected( 'h', $instance['positioning'] ); ?>><?php _e( 'Horizontally', 'falang' ); ?></option>
				<option value="v" <?php selected( 'v', $instance['positioning'] ); ?>><?php _e( 'Vertically', 'falang' ); ?></option>
			</select>
		</p>

		<!-- display name  -->
		<p <?php echo ($instance['display_type'] == 'select' ? 'style="display: none;"' : ''); ?>>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'display_name' ); ?>" name="<?php echo $this->get_field_name( 'display_name' ); ?>" value="1" <?php checked('1',$instance['display_name']); ?>/>

			<label for="<?php echo $this->get_field_id( 'display_name' ); ?>"><?php _e( 'Display Language Names', 'falang' ); ?>:</label>
		</p>

		<!-- display flag  -->
		<p class="option_display_list"  <?php echo ($instance['display_type'] == 'select' ? 'style="display: none;"' : ''); ?>>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'display_flags' ); ?>" name="<?php echo $this->get_field_name( 'display_flags' ); ?>" value="1" <?php checked('1',$instance['display_flags']); ?>/>

			<label for="<?php echo $this->get_field_id( 'display_flags' ); ?>"><?php _e( 'Display Flags', 'falang' ); ?>:</label>
		</p>

		<!-- hide current language  -->
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'hide_current' ); ?>" name="<?php echo $this->get_field_name( 'hide_current' ); ?>" value="1" <?php checked('1',$instance['hide_current']); ?>/>

			<label for="<?php echo $this->get_field_id( 'hide_current' ); ?>"><?php _e( 'Hides the current language', 'falang' ); ?>:</label>
		</p>


		<?php

		// FIXME echoing script in form is not very clean
		// but it does not work if enqueued properly :
		// clicking save on a widget makes this code unreachable for the just saved widget ( ?! )
		$this->admin_print_script();

	}

	/**
	 * Updates the widget options
	 *
	 * @since 1.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {
		$new_instance['title'] = strip_tags( $new_instance['title'] );


		$new_instance['positioning'] = strip_tags( $new_instance['positioning'] );
		$new_instance['display_name'] = strip_tags( $new_instance['display_name'] );
		$new_instance['display_flags'] = strip_tags( $new_instance['display_flags'] );
		$new_instance['display_type'] = strip_tags( $new_instance['display_type'] );
		$new_instance['hide_current'] = strip_tags( $new_instance['hide_current'] );

		return $new_instance;
	}

	/**
	 * Add javascript to control the switcher widget options
	 *
	 * @since 1.0
	 */
	public function admin_print_script() {
		static $done = false;

		if ( $done ) {
			return;
		}

		$done = true;
		?>
		<script type='text/javascript'>
            //<![CDATA[
            jQuery( document ).ready( function( $ ) {

                function checkSwitchOn(check1,check2) {
                    if (check1.prop('checked') == false && check2.prop('checked') == false) {
                        check2.prop('checked',true);
                    }
                }

//                $('.widgets-sortables,.control-section-sidebar').on('change','.sublanguagesw_display_type',function() {
//                    var displayType = $(this).val();
//                    if (displayType == 'select') {
//                        $(this).parent().parent().find('.option_display_list').hide();
//                    } else {
//                        $(this).parent().parent().find('.option_display_list').show();
//                    }
//                });
//
//                $('.widgets-sortables,.control-section-sidebar').on('change','.sublanguagesw_option_display_flags',function() {
//                    checkSwitchOn($(this),$(this).parent().parent().find('.sublanguagesw_option_display_name'));
//                });
//
//                $('.widgets-sortables,.control-section-sidebar').on('change','.sublanguagesw_option_display_name',function() {
//                    checkSwitchOn($(this),$(this).parent().parent().find('.sublanguagesw_option_display_flags'));
//                });

            } );
            //]]>
		</script>
		<?php
	}


}