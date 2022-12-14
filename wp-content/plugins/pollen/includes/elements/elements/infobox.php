<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Infobox
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_pollen_infobox extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'link' => '',
			'icon_display' => '',
			'custom_image_icon' => '',
			'custom_svg_icon' => '',
			'icon' => '',
			'icon_color' => '',
			'custom_icon_color' => '',
			'shape' => '',
			'color_shape' => '',
			'icon_size' => '',
			'icon_spacing' => '',
			'icon_gap' => '0',
			'height' => 'auto',
			'width' => '100px',
			'style' => 'column',
			'alignment' => 'flex-start',
			'animations' => '',
			'animation_delay' => '',
			'animation_speed' => 'slower animated infinite',
			'title_tag' => 'h3',
			'title_size' => '',
			'title_line_height' => '',
			'title_spacing' => '',
			'title_alignment' => '',
			'title_color' => '',	
			//Static	
			'el_id' => '',
			'el_class' => '',
			'css' => '',
			'css_animation' => ''
		), $atts ) );
		$output = '';
		$pollen_global_color = 'pollen-global-color'; //General Color
		$pollen_global_border_color = 'pollen-global-border-color'; //Border Color
		$pollen_global_background_color = 'pollen-global-background-color'; //Background Color
		
		
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
		
		// Title
		if($link != '') {
			$link = vc_build_link( $link );
			$link_start = '<a href="'.esc_attr( $link['url'] ).'">';
			$link_finish = '</a>';
		} else {
			$link_start = '';
			$link_finish = '';
		}
		
		if ($title_color == '') {
			$title_color = '';
			$default_title_color = $pollen_global_color;
		} else {
			$title_color = 'color:'.$title_color.';';
			$default_title_color = '';
		}
		
		if ($title_size != '') {
			$title_size = 'font-size:'.$title_size.';';
		} else {
			$title_size = '';
		}
		
		if ($title_line_height != '') {
			$title_line_height = 'line-height:'.$title_line_height.';';
		} else {
			$title_line_height = '';
		}
		
		if ($title_spacing != '') {
			$title_spacing = 'margin:'.$title_spacing.';';
		} else {
			$title_spacing = '';
		}
		
		if ($title_alignment != '') {
			$title_alignment = 'text-align:'.$title_alignment.';';
		} else {
			$title_alignment = '';
		}
		
		$title_content = ''.$link_start.'<'.$title_tag.' class="'.$default_title_color.'" style="'.$title_size.$title_line_height.$title_spacing.$title_alignment.$title_color.'">'.$title.'</'.$title_tag.'>'.$link_finish.'';	
		
		// Icon
		if ($icon_display == 'image_icon') {
			
			$default_src = vc_asset_url( 'vc/no_image.png' );
			$img = wp_get_attachment_image_src( $custom_image_icon );
			$src = $img[0];
			$custom_src = $src ? esc_attr( $src ) : $default_src;
			
			$icon_content = '<img src="'.$custom_src.'" >';
			
		} elseif ($icon_display == 'svg_icon') {
			
			$default_src = vc_asset_url( 'vc/no_image.png' );
			$img = wp_get_attachment_image_src( $custom_svg_icon );
			$src = $img[0];
			$custom_src = $src ? esc_attr( $src ) : $default_src;
			
			$icon_content = '<div class="pollen-infobox-svg" style="height:'.$height.';width:'.$width.';"><img class="pollen-svg-img" src="'.$custom_src.'" ></div>';
			
		} else {
			
			$iconClass = isset( $icon ) ? esc_attr( $icon ) : 'fa fa-adjust';
			
			if($icon_color != '') {
				$custom_icon_color = 'color:'.$custom_icon_color.';';
				$global_icon_color = '';
			} else {
				$icon_color = '';
				$global_icon_color = 'pollen-global-color';
			}
			
			$font_size_reference = $icon_size;
			
			if($icon_size != '') {
				$icon_size = 'font-size:'.$icon_size.';';
			}
			
			if($shape != '') {
				
				if($shape == 'rounded' || $shape == 'square' || $shape == 'round') {
					
					if($color_shape != '') {
						$color_shape = 'background-color:'.$color_shape.';';
						$default_color_shape = '';
					} else {
						$color_shape = '';
						$default_color_shape = 'pollen-global-background-color';
					}
					
				} else {
					
					if($color_shape != '') {    
						$color_shape = 'border-color:'.$color_shape.';';
						$default_color_shape = '';
					} else {
						$color_shape = '';
						$default_color_shape = 'pollen-global-border-color';
					}
					
				}
				
				if($icon_spacing != '') {
					$icon_spacing = 'height:'.$icon_spacing.'; width:'.$icon_spacing.';';
				} else {
					$icon_spacing = 'height:calc('.$font_size_reference.' + 2em); width:calc('.$font_size_reference.' + 2em);';
				}
				
				$shape_render_start = '<div class="icon-infobox '.$shape.' '.$default_color_shape.'" style="'.$color_shape.''.$icon_spacing.'">';
				$shape_render_finish = '</div>';
				
			} else {
				$shape_render_start = '';
				$shape_render_finish = '';
			}
			
			$icon_content = ''.$shape_render_start.'<span style="'.$custom_icon_color.' '.$icon_size.'" class="pollen-infobox-icon-item '.$global_icon_color.' '.$iconClass.'"></span>'.$shape_render_finish.'';
		}
		
		// Gap
		
		$icon_gap = 'style="margin:'.$icon_gap.';"';
		
		// Style
		
		$style_alignment = 'style="flex-direction:'.$style.'; align-items:'.$alignment.';"';
		
		//Output
		$output .= '<div '.$el_id.' class="pollen-infobox '.$css_class.'" '.$style_alignment.'>';
		$output .= '<div class="infobox-icon '.$animations.' '.$animation_delay.' '.$animation_speed.'" '.$icon_gap.'>';
		$output .= $icon_content;
		$output .= '</div>';
		$output .= '<div class="infobox-content">';
		$output .= $title_content;
		$output .= $content;
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

return array(
	'name' => __( 'Infobox', 'pollen' ),
	'base' => 'pollen_infobox',
	'icon' => plugins_url('../images/infobox.png', __FILE__),
	'show_settings_on_create' => true,
	'category' => __( 'Pollen', 'pollen' ),
	'description' => __( 'Create nice looking infoboxes', 'pollen' ),
	'params' => array(
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'pollen' ),
			'param_name' => 'title',
			'description' => __( 'Enter the title here.', 'pollen' ),
		),
		
		array(
			'type' => 'vc_link',
			'heading' => __( 'URL (Link)', 'pollen' ),
			'param_name' => 'link',
			'description' => __( 'Add link to infobox title.', 'pollen' ),
		),
		
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => __( 'Description', 'pollen' ),
			'param_name' => 'content',
			'description' => __( 'Provide the description for this Infobox.', 'pollen' ),
			'value' => __( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'pollen' ),
		),
		
		/*
		* Icon Tab
		*/
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon to display', 'pollen' ),
			'param_name' => 'icon_display',
			'value' => array(
				__( 'Icon Manager', 'pollen' ) => 'icon_manager',
				__( 'Image Icon', 'pollen' ) => 'image_icon',
				__( 'SVG Icon', 'pollen' ) => 'svg_icon',
			),
			'description' => __( 'Enable Icon Library.', 'pollen' ),
			'group' => 'Icon',
		),
		
		array(
			'type' => 'attach_image',
			'heading' => __( 'Upload Image Icon', 'pollen' ),
			'param_name' => 'custom_image_icon',
			'description' => __( 'Upload the custom image icon.', 'pollen' ),
			'group' => 'Icon',
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'image_icon' ),
			),
		),
		
		array(
			'type' => 'attach_image',
			'heading' => __( 'Upload SVG Icon', 'pollen' ),
			'param_name' => 'custom_svg_icon',
			'description' => __( 'Upload the custom svg icon.', 'pollen' ),
			'group' => 'Icon',
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'svg_icon' ),
			),
		),
		
		array(
			'type' => 'iconmanager',
			'heading' => __( 'Icon', 'pollen' ),
			'param_name' => 'icon',
			'description' => __( 'Select icon from library.', 'pollen' ),
			'group' => 'Icon',
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
			),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon color', 'pollen' ),
			'param_name' => 'icon_color',
			'value' => array(
				__( 'Preset Color', 'pollen' ) => '',
				__( 'Custom Color', 'pollen' ) => 'custom',
			),
			'description' => __( 'Select icon color.', 'pollen' ),
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
			),
			'group' => 'Icon',
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom Icon Color', 'pollen' ),
			'param_name' => 'custom_icon_color',
			'description' => __( 'Select custom icon color.', 'pollen' ),
			'group' => 'Icon',
			'dependency' => array(
				'element' => 'icon_color',
				'value' => array( 'custom' ),
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Shape', 'pollen' ),
			'description' => __( 'Select icon shape.', 'pollen' ),
			'param_name' => 'shape',
			'group' => 'Icon',
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
			),
			'value' => array(
				__( 'None', 'pollen' ) => '',
				__( 'Rounded', 'pollen' ) => 'rounded',
				__( 'Square', 'pollen' ) => 'square',
				__( 'Round', 'pollen' ) => 'round',
				__( 'Outline Rounded', 'pollen' ) => 'outline-rounded',
				__( 'Outline Square', 'pollen' ) => 'outline-square',
				__( 'Outline Round', 'pollen' ) => 'outline-round',
			),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Color Shape', 'pollen' ),
			'param_name' => 'color_shape',
			'description' => __( 'Select custom shape background color.', 'pollen' ),
			'group' => 'Icon',
			'dependency' => array(
				'element' => 'shape',
				'value' => array( 'rounded','square','round','outline-rounded','outline-square','outline-round',  ),
			),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Size', 'pollen' ),
			'param_name' => 'icon_size',
			'description' => __( 'Icon size. Default value is 16px.', 'pollen' ),
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
			),
			'group' => 'Icon',
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Spacing', 'pollen' ),
			'param_name' => 'icon_spacing',
			'description' => __( 'Select icon spacing. e.g. 16px.', 'pollen' ),
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
			),
			'group' => 'Icon',
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Height', 'pollen' ),
			'param_name' => 'height',
			'description' => __( 'Insert the SVG height.', 'pollen' ),
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'svg_icon' ),
			),
			'group' => 'Icon',
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Width', 'pollen' ),
			'param_name' => 'width',
			'description' => __( 'Insert the SVG width.', 'pollen' ),
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'svg_icon' ),
			),
			'group' => 'Icon',
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Gap', 'pollen' ),
			'param_name' => 'icon_gap',
			'description' => __( 'Select icon gap. e.g. 16px.', 'pollen' ),
			'group' => 'Icon',
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'pollen' ),
			'param_name' => 'style',
			'value' => array(
				__( 'Icon at Top', 'pollen' ) => 'column',
				__( 'Icon at Bottom', 'pollen' ) => 'column-reverse',
				__( 'Icon at Left', 'pollen' ) => 'row',
				__( 'Icon at Right', 'pollen' ) => 'row-reverse',
			),
			'description' => __( 'Select icon position. Icon box style will be changed according to the icon position.', 'pollen' ),
			'group' => 'Icon',
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Alignment', 'pollen' ),
			'param_name' => 'alignment',
			'value' => array(
				__( 'Start', 'pollen' ) => 'flex-start',
				__( 'Center', 'pollen' ) => 'center',
				__( 'End', 'pollen' ) => 'flex-end',
			),
			'description' => __( 'Select icon alignment.', 'pollen' ),
			'group' => 'Icon',
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Animations', 'pollen' ),
			'param_name' => 'animations',
			'value' => array(
				__( 'No Animation', 'pollen' ) => '',
				__( 'Bounce', 'pollen' ) => 'bounce',
				__( 'Flash', 'pollen' ) => 'flash',
				__( 'Pulse', 'pollen' ) => 'pulse',
				__( 'Rubber Band', 'pollen' ) => 'rubberBand',
				__( 'Shake', 'pollen' ) => 'shake',
				__( 'Head Shake', 'pollen' ) => 'headShake',
				__( 'Swing', 'pollen' ) => 'swing',
				__( 'Tada', 'pollen' ) => 'tada',
				__( 'Wobble', 'pollen' ) => 'wobble',
				__( 'Jello', 'pollen' ) => 'jello',
				__( 'Bounce In', 'pollen' ) => 'bounceIn',
				__( 'Bounce In Down', 'pollen' ) => 'bounceInDown',
				__( 'Bounce In Left', 'pollen' ) => 'bounceInLeft',
				__( 'Bounce In Right', 'pollen' ) => 'bounceInRight',
				__( 'Bounce In Up', 'pollen' ) => 'bounceInUp',
				__( 'Bounce Out', 'pollen' ) => 'bounceOut',
				__( 'Bounce Out Down', 'pollen' ) => 'bounceOutDown',
				__( 'Bounce Out Left', 'pollen' ) => 'bounceOutLeft',
				__( 'Bounce Out Right', 'pollen' ) => 'bounceOutRight',
				__( 'Bounce Out Up', 'pollen' ) => 'bounceOutUp',
				__( 'Fade In', 'pollen' ) => 'fadeIn',
				__( 'Fade In Down', 'pollen' ) => 'fadeInDown',
				__( 'Fade In Down Big', 'pollen' ) => 'fadeInDownBig',
				__( 'Fade In Left', 'pollen' ) => 'fadeInLeft',
				__( 'Fade In Left Big', 'pollen' ) => 'fadeInLeftBig',
				__( 'Fade In Right', 'pollen' ) => 'fadeInRight',
				__( 'Fade In Right Big', 'pollen' ) => 'fadeInRightBig',
				__( 'Fade In Up', 'pollen' ) => 'fadeInUp',
				__( 'Fade In Up Big', 'pollen' ) => 'fadeInUpBig',
				__( 'Fade Out', 'pollen' ) => 'fadeOut',
				__( 'Fade Out Down', 'pollen' ) => 'fadeOutDown',
				__( 'Fade Out Down Big', 'pollen' ) => 'fadeOutDownBig',
				__( 'Fade Out Left', 'pollen' ) => 'fadeOutLeft',
				__( 'Fade Out Left Big', 'pollen' ) => 'fadeOutLeftBig',
				__( 'Fade Out Right', 'pollen' ) => 'fadeOutRight',
				__( 'Fade Out Right Big', 'pollen' ) => 'fadeOutRightBig',
				__( 'Fade Out Up', 'pollen' ) => 'fadeOutUp',
				__( 'Fade Out Up Big', 'pollen' ) => 'fadeOutUpBig',
				__( 'Flip In X', 'pollen' ) => 'flipInX',
				__( 'Flip In Y', 'pollen' ) => 'flipInY',
				__( 'Flip Out X', 'pollen' ) => 'flipOutX',
				__( 'Flip Out Y', 'pollen' ) => 'flipOutY',
				__( 'Light Speed In', 'pollen' ) => 'lightSpeedIn',
				__( 'Light Speed Out', 'pollen' ) => 'lightSpeedOut',
				__( 'Rotate In', 'pollen' ) => 'rotateIn',
				__( 'Rotate In Down Left', 'pollen' ) => 'rotateInDownLeft',
				__( 'Rotate In Down Right', 'pollen' ) => 'rotateInDownRight',
				__( 'Rotate In Up Left', 'pollen' ) => 'rotateInUpLeft',
				__( 'Rotate In Up Right', 'pollen' ) => 'rotateInUpRight',
				__( 'Rotate Out', 'pollen' ) => 'rotateOut',
				__( 'Rotate Out Down Left', 'pollen' ) => 'rotateOutDownLeft',
				__( 'Rotate Out Down Right', 'pollen' ) => 'rotateOutDownRight',
				__( 'Rotate Out Up Left', 'pollen' ) => 'rotateOutUpLeft',
				__( 'Rotate Out Up Right', 'pollen' ) => 'rotateOutUpRight',
				__( 'Hinge', 'pollen' ) => 'hinge',
				__( 'Jack In The Box', 'pollen' ) => 'jackInTheBox',
				__( 'Roll In', 'pollen' ) => 'rollIn',
				__( 'Roll Out', 'pollen' ) => 'rollOut',
				__( 'Zoom In', 'pollen' ) => 'zoomIn',
				__( 'Zoom In Down', 'pollen' ) => 'zoomInDown',
				__( 'Zoom In Left', 'pollen' ) => 'zoomInLeft',
				__( 'Zoom In Right', 'pollen' ) => 'zoomInRight',
				__( 'Zoom In Up', 'pollen' ) => 'zoomInUp',
				__( 'Zoom Out', 'pollen' ) => 'zoomOut',
				__( 'Zoom Out Down', 'pollen' ) => 'zoomOutDown',
				__( 'Zoom Out Left', 'pollen' ) => 'zoomOutLeft',
				__( 'Zoom Out Right', 'pollen' ) => 'zoomOutRight',
				__( 'Zoom Out Up', 'pollen' ) => 'zoomOutUp',
				__( 'Slide In Down', 'pollen' ) => 'slideInDown',
				__( 'Slide In Left', 'pollen' ) => 'slideInLeft',
				__( 'Slide In Right', 'pollen' ) => 'slideInRight',
				__( 'Slide In Up', 'pollen' ) => 'slideInUp',
				__( 'Slide Out Down', 'pollen' ) => 'slideOutDown',
				__( 'Slide Out Left', 'pollen' ) => 'slideOutLeft',
				__( 'Slide Out Right', 'pollen' ) => 'slideOutRight',
				__( 'Slide Out Up', 'pollen' ) => 'slideOutUp',
				__( 'Heart Beat', 'pollen' ) => 'heartBeat',
				
			),
			'description' => __( 'Select the type of animation you want on hover.', 'pollen' ),
			'group' => 'Icon',
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Animation Delay', 'pollen' ),
			'param_name' => 'animation_delay',
			'value' => array(
				__( 'No Delay', 'pollen' ) => '',
				__( 'Delay 1 second', 'pollen' ) => 'delay-1s',
				__( 'Delay 2 seconds', 'pollen' ) => 'delay-2s',
				__( 'Delay 3 seconds', 'pollen' ) => 'delay-3s',
				__( 'Delay 4 seconds', 'pollen' ) => 'delay-4s',
				__( 'Delay 5 seconds', 'pollen' ) => 'delay-5s',
				
			),
			'dependency' => array(
				'element' => 'animations',
				'value' => array( 'bounce','flash','pulse','rubberBand','shake','headShake','swing','tada','wobble','jello','bounceIn','bounceInDown','bounceInLeft','bounceInRight','bounceInUp','bounceOut','bounceOutDown','bounceOutLeft','bounceOutRight','bounceOutUp','fadeIn','fadeInDown','fadeInDownBig','fadeInLeft','fadeInLeftBig','fadeInRight','fadeInRightBig','fadeInUp','fadeInUpBig','fadeOut','fadeOutDown','fadeOutDownBig','fadeOutLeft','fadeOutLeftBig','fadeOutRight','fadeOutRightBig','fadeOutUp','fadeOutUpBig','flipInX','flipInY','flipOutX','flipOutY','lightSpeedIn','lightSpeedOut','rotateIn','rotateInDownLeft','rotateInDownRight','rotateInUpLeft','rotateInUpRight','rotateOut','rotateOutDownLeft','rotateOutDownRight','rotateOutUpLeft','rotateOutUpRight','hinge','jackInTheBox','rollIn','rollOut','zoomIn','zoomInDown','zoomInLeft','zoomInRight','zoomInUp','zoomOut','zoomOutDown','zoomOutLeft','zoomOutRight','zoomOutUp','slideInDown','slideInLeft','slideInRight','slideInUp','slideOutDown','slideOutLeft','slideOutRight','slideOutUp','heartBeat' ),
			),
			'description' => __( 'Select delay for animation.', 'pollen' ),
			'group' => 'Icon',
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Animation Speed', 'pollen' ),
			'param_name' => 'animation_speed',
			'value' => array(
				__( 'Slower - 3s', 'pollen' ) => 'slower animated infinite',
				__( 'Slow - 2s', 'pollen' ) => 'slow animated infinite',
				__( 'Fast - 800ms', 'pollen' ) => 'fast animated infinite',
				__( 'Faster - 500ms', 'pollen' ) => 'faster animated infinite',
				
			),
			'dependency' => array(
				'element' => 'animations',
				'value' => array( 'bounce','flash','pulse','rubberBand','shake','headShake','swing','tada','wobble','jello','bounceIn','bounceInDown','bounceInLeft','bounceInRight','bounceInUp','bounceOut','bounceOutDown','bounceOutLeft','bounceOutRight','bounceOutUp','fadeIn','fadeInDown','fadeInDownBig','fadeInLeft','fadeInLeftBig','fadeInRight','fadeInRightBig','fadeInUp','fadeInUpBig','fadeOut','fadeOutDown','fadeOutDownBig','fadeOutLeft','fadeOutLeftBig','fadeOutRight','fadeOutRightBig','fadeOutUp','fadeOutUpBig','flipInX','flipInY','flipOutX','flipOutY','lightSpeedIn','lightSpeedOut','rotateIn','rotateInDownLeft','rotateInDownRight','rotateInUpLeft','rotateInUpRight','rotateOut','rotateOutDownLeft','rotateOutDownRight','rotateOutUpLeft','rotateOutUpRight','hinge','jackInTheBox','rollIn','rollOut','zoomIn','zoomInDown','zoomInLeft','zoomInRight','zoomInUp','zoomOut','zoomOutDown','zoomOutLeft','zoomOutRight','zoomOutUp','slideInDown','slideInLeft','slideInRight','slideInUp','slideOutDown','slideOutLeft','slideOutRight','slideOutUp','heartBeat' ),
			),
			'description' => __( 'Select Speed for animation.', 'pollen' ),
			'group' => 'Icon',
		),
		
		/*
		* Typography Tab
		*/
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Title Tag', 'pollen' ),
			'param_name' => 'title_tag',
			'group' => 'Typography',
			'value' => array(
				__( 'H1', 'pollen' ) => 'h1',
				__( 'H2', 'pollen' ) => 'h2',
				__( 'H3', 'pollen' ) => 'h3',
				__( 'H4', 'pollen' ) => 'h4',
				__( 'H5', 'pollen' ) => 'h5',
				__( 'H6', 'pollen' ) => 'h6',
				__( 'p', 'pollen' ) => 'p',
				__( 'div', 'pollen' ) => 'div',
			),
			'default' => 'h3',
			'description' => __( 'Select title tag.', 'pollen' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Title Font Size', 'pollen' ),
			'param_name' => 'title_size',
			'description' => __( 'Enter font size.', 'pollen' ),
			'group' => 'Typography',
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Title Line Height', 'pollen' ),
			'param_name' => 'title_line_height',
			'description' => __( 'Enter line height.', 'pollen' ),
			'group' => 'Typography',
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Title Spacing', 'pollen' ),
			'param_name' => 'title_spacing',
			'description' => __( 'Select title spacing. e.g. 16px.', 'pollen' ),
			'group' => 'Typography',
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Title Alignment', 'pollen' ),
			'param_name' => 'title_alignment',
			'value' => array(
				__( 'Left', 'pollen' ) => 'left',
				__( 'Right', 'pollen' ) => 'right',
				__( 'Center', 'pollen' ) => 'center',
			),
			'description' => __( 'Select title alignment.', 'pollen' ),
			'group' => 'Typography',
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Title Color', 'pollen' ),
			'param_name' => 'title_color',
			'description' => __( 'Select custom color for the title.', 'pollen' ),
			'group' => 'Typography',
		),
		
		// Animation
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
	);
	