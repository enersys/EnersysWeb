<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	List Group
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_pollen_list_group extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			//Static
			'mode' => 'pollen-list-group-item-text',
			'appearance' => '',
			'direction' => 'pollen-direction-vertical',
			'alignment' => 'pollen-align-left',
			'el_id' => '',
			'el_class' => '',
			'css' => '',
			'css_animation' => ''
		), $atts ) );
		$output = '';
		
		// Start Default Extra Class, CSS and CSS animation
		
		$css = isset( $atts['css'] ) ? $atts['css'] : '';
		$el_id = isset( $atts['el_id'] ) ? 'id="' . esc_attr( $el_id ) . '"' : '';
		$el_class = isset( $atts['el_class'] ) ? $atts['el_class'] : '';
		
		if ( '' !== $css_animation ) {
			wp_enqueue_script( 'waypoints' );
			$css_animation_style = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
		}
		
		$class_to_filter = vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
		
		// End Default Extra Class, CSS and CSS animation
		
		
		$output .= '<div '.$el_id.' class="pollen-list-group '.$css_class.' '.$direction.' '.$appearance.' '.$alignment.' '.$mode.'">'.wpb_js_remove_wpautop($content).'</div>';
		
		return $output;
	}
}

class WPBakeryShortCode_pollen_list_group_item extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'link' => '',
			'icon' => '',
			'colors' => '',
			'icon_color' => '',
			'title_color' => '',
			//Static
			'el_id' => '',
			'el_class' => '',
			'css' => '',
			'css_animation' => ''
		), $atts ) );
		$output = '';
		
		// URL Builder
		
		$link = vc_build_link( $link );
		
		// Start Default Extra Class, CSS and CSS animation
		
		$css = isset( $atts['css'] ) ? $atts['css'] : '';
		$el_id = isset( $atts['el_id'] ) ? 'id="' . esc_attr( $el_id ) . '"' : '';
		$el_class = isset( $atts['el_class'] ) ? $atts['el_class'] : '';
		
		if ( '' !== $css_animation ) {
			wp_enqueue_script( 'waypoints' );
			$css_animation_style = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
		}
		
		$class_to_filter = vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
		
		// End Default Extra Class, CSS and CSS animation

		// Start Custom Colors

		$icon_color = $icon_color ? 'style=color:'.$icon_color.'' : '';
		$title_color = $title_color ? 'style=color:'.$title_color.'' : '';

		// End Custom Colors

		// Start Icon

		$icon = $icon ? '<i class="'.$icon.'" '.$icon_color.' aria-hidden="true"></i>' : '';
		
		//End Icon

		// Start Link		
		if($link['url'] != ''){
			$tag = 'a';
			$href = 'href="'.esc_attr( $link['url'] ).'"';
		} else {
			$tag = 'span';
			$href = '';
		}
		// End Link
		
		$output .= '<'.$tag.' '.$href.' '.$el_id.' class="pollen-list-group-item '.$css_class.'" '.$title_color.'>'.$icon.$title.'</'.$tag.'>';

		
		return $output;
	}
}

vc_map( array(
	'name' => __( 'List Group', 'pollen' ),
	'base' => 'pollen_list_group',
	'icon' => plugins_url('../images/list-group.png', __FILE__),
	"as_parent" => array('only' => 'pollen_list_group_item'),
	"content_element" => true,
	"show_settings_on_create" => false,
	"is_container" => true,
	'category' => __( 'Pollen', 'pollen' ),
	'description' => __( 'Show a flexible and powerful list', 'pollen' ),
	'params' => array(
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'List Mode', 'pollen' ),
			'param_name' => 'mode',
			'value' => array(
				__( 'Text', 'pollen' ) => 'pollen-list-group-item-text',
				__( 'Link', 'pollen' ) => 'pollen-list-group-item-link',
			),
			'description' => __( 'Choose a mode for list group.', 'pollen' ),
		),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Appearance', 'pollen' ),
			'param_name' => 'appearance',
			'value' => array(
				__( 'No Borders and Separator Lines', 'pollen' ) => '',
				__( 'Separator Lines', 'pollen' ) => 'pollen-separator-lines',
				__( 'Borders and Separator Lines', 'pollen' ) => 'pollen-borders-separator-lines',
				__( 'Borders With Rounded Corners and Separator Lines', 'pollen' ) => 'pollen-borders-rounded-corners-separator-lines',
			),
			'description' => __( 'Choose a appearance for list group.', 'pollen' ),
		),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Direction', 'pollen' ),
			'param_name' => 'direction',
			'value' => array(
				__( 'Vertical', 'pollen' ) => 'pollen-direction-vertical',
				__( 'Horizontal', 'pollen' ) => 'pollen-direction-horizontal',
			),
			'description' => __( 'Choose the direction for list group.', 'pollen' ),
		),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Alignment', 'pollen' ),
			'param_name' => 'alignment',
			'value' => array(
				__( 'Left', 'pollen' ) => 'pollen-align-left',
				__( 'Right', 'pollen' ) => 'pollen-align-right',
				__( 'Center', 'pollen' ) => 'pollen-align-center',
			),
			'description' => __( 'Choose the alignment for list group.', 'pollen' ),
		),
		
		vc_map_add_css_animation(),
		
		array(
			'type' => 'el_id',
			'heading' => __( 'Element ID', 'pollen' ),
			'param_name' => 'el_id',
			'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'pollen' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
			),
			
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'pollen' ),
				'param_name' => 'el_class',
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'pollen' ),
			),
			
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS box', 'pollen' ),
				'param_name' => 'css',
				'group' => __( 'Design Options', 'pollen' ),
			),
		),
		"js_view" => 'VcColumnView'
		) );
		
		vc_map( array(
			"name" => __("List Item", 'pollen'),
			'description' => __( 'Display List Group Item', 'pollen' ),
			"base" => "pollen_list_group_item",
			'icon' => plugins_url('../images/list-item.png', __FILE__),
			"content_element" => true,
			"as_child" => array('only' => 'pollen_list_group'), 
			"params" => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Title', 'pollen' ),
					'param_name' => 'title',
				),
				
				array(
					'type' => 'vc_link',
					'heading' => __( 'URL (Link)', 'pollen' ),
					'param_name' => 'link',
					'description' => __( 'Add link to List Item.', 'pollen' ),
				),
				
				array(
					'type' => 'iconmanager',
					'heading' => __( 'Icon', 'pollen' ),
					'param_name' => 'icon',
					'description' => __( 'Select icon from library.', 'pollen' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => __( 'Colors', 'pollen' ),
					'param_name' => 'colors',
					'value' => array(
						__( 'Preset Colors', 'pollen' ) => '',
						__( 'Custom Colors', 'pollen' ) => 'custom',
					),
					'description' => __( 'Choose a color for icons and titles.', 'pollen' ),
				),
				
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Icon Color', 'pollen' ),
					'param_name' => 'icon_color',
					'description' => __( 'Select custom color for icons.', 'pollen' ),
					'dependency' => array(
						'element' => 'colors',
						'value' => array( 'custom' ),
					),
				),

				array(
					'type' => 'colorpicker',
					'heading' => __( 'Title Color', 'pollen' ),
					'param_name' => 'title_color',
					'description' => __( 'Select custom color for titles.', 'pollen' ),
					'dependency' => array(
						'element' => 'colors',
						'value' => array( 'custom' ),
					),
				),
				
				vc_map_add_css_animation(),
				
				array(
					'type' => 'el_id',
					'heading' => __( 'Element ID', 'pollen' ),
					'param_name' => 'el_id',
					'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'pollen' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
					),
					
					array(
						'type' => 'textfield',
						'heading' => __( 'Extra class name', 'pollen' ),
						'param_name' => 'el_class',
						'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'pollen' ),
					),
					
					array(
						'type' => 'css_editor',
						'heading' => __( 'CSS box', 'pollen' ),
						'param_name' => 'css',
						'group' => __( 'Design Options', 'pollen' ),
					),
					)
					) );