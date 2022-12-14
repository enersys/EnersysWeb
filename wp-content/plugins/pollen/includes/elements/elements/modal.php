<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Modal
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_pollen_modal extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'trigger' => 'trigger-button',
			'title' => 'Title',
			'title_tag' => 'span',
			'text_color' => '',
			'alignment' => 'trigger-left',
			'initial_height' => '',
			'button_shape' => 'pollen-rounded',
			'button_outline_shape' => '',
			'button_color' => '',
			'button_title_color' => '',
			'button_background_color' => '',
			'button_outline_color' => '',
			'button_size' => 'button-size-small',
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
			'animations' => '',
			'animation_delay' => '',
			'animation_speed' => 'slower animated infinite',
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
		
		$uniqid = md5(uniqid(rand(), true));
		$uniqid = preg_replace('/[0-9]+/', '', $uniqid);
		
		// End Default Extra Class, CSS and CSS animation	
		
		// Start Trigger Mode
		
		$output .= '<div class="pollen-modal-trigger '.$alignment.'">';
		
		if ($trigger == 'trigger-button') {
			
			if (!empty($button_color)) {
				
				// Button Background Color
				
				if ( empty($button_background_color) && !empty($button_outline_color)  ) {
					
					$button_background_color = $pollen_global_background_color = "";
					
				} else if ( !empty($button_background_color) ) {
					
					$button_background_color = 'background-color: '.$button_background_color.';';
					
				}
				
				// Text Color
				
				if (!empty($button_title_color)) {
					$button_title_color = 'color: '.$button_title_color.';'; 
				} else {
					$button_title_color = ''; 
				}
				
				// Border Color
				
				if (!empty($button_outline_color)) {
					$button_outline_color = 'border-color: '.$button_outline_color.';'; 
				} else {
					$button_outline_color = ''; 
				}
				
			} else {
				$button_title_color = '';
				$button_background_color = '';
				$button_outline_color = '';
			}
			
			
			$output .= '<div style="'.$button_background_color .' '.$button_title_color.' '.$button_outline_color.'" class="pollen-modal-button '.$button_size.' '.$trigger.' '.$button_shape.' '.$button_outline_shape.' '.$pollen_global_background_color.'" data-modal="'.$uniqid.'">'.$title.'</div>';	
		} else if ($trigger == 'trigger-image') {
			
			// Image
			
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
				
				$icon_content = '<div class="pollen-modal-svg" style="height:'.$height.';width:'.$width.';"><img class="pollen-svg-img" src="'.$custom_src.'" ></div>';
				
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
					
					$shape_render_start = '<div class="pollen-modal-icon-inner '.$shape.' '.$default_color_shape.'" style="'.$color_shape.''.$icon_spacing.'">';
					$shape_render_finish = '</div>';
					
				} else {
					$shape_render_start = '';
					$shape_render_finish = '';
				}
				
				$icon_content = ''.$shape_render_start.'<span style="'.$custom_icon_color.' '.$icon_size.'" class="pollen-modal-image '.$global_icon_color.' '.$iconClass.'"></span>'.$shape_render_finish.'';
			}
			
			$output .= '<div data-modal="'.$uniqid.'" class="pollen-modal-icon '.$animations.' '.$animation_delay.' '.$animation_speed.'" '.$icon_gap.'>';
			$output .= $icon_content;
			$output .= '</div>';
			
		} else if ($trigger == 'trigger-text') {
			
			// Title Color
			
			if (!empty($text_color)) {
				$text_color = 'color: '.$text_color.';'; 
			} else {
				$text_color = ''; 
			}
			
			$output .= '<'.$title_tag.' style="'.$text_color .'" class="pollen-modal-text" data-modal="'.$uniqid.'">'.$title.'</'.$title_tag.'>';
		}
		
		$output .= '</div>';
		
		// End Trigger Mode

		// Start Modal Height

		if (!empty($initial_height)) {
			$initial_height = 'style="height:'.$initial_height.';"';
		}

		// End Modal Height
		
		$output .= '<div id="'.$uniqid.'" class="pollen-modal">';
		$output .= '<div id="'.$uniqid.'" class="pollen-modal-inner' .$css_class.'">';
		$output .= '<a class="pollen-modal-close">&times;</a>';
		$output .= '<div id="'.$el_id.'" '.$initial_height.' class="pollen-modal-content">'.wpb_js_remove_wpautop($content).'</div>';
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}


vc_map( array(
	'name' => __( 'Modal', 'pollen' ),
	'base' => 'pollen_modal',
	'icon' => plugins_url('../images/modal.png', __FILE__),
	"content_element" => true,
	"show_settings_on_create" => false,
	"is_container" => true,
	'category' => __( 'Pollen', 'pollen' ),
	'description' => __( 'Add and manage multiple icons', 'pollen' ),
	'params' => array(
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Start From', 'pollen' ),
			'param_name' => 'trigger',
			'value' => array(
				__( 'Button', 'pollen' ) => 'trigger-button',
				__( 'Image', 'pollen' ) => 'trigger-image',
				__( 'Text', 'pollen' ) => 'trigger-text',
			),
			'description' => __( 'Select start mode.', 'pollen' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'pollen' ),
			'param_name' => 'title',
			'description' => __( 'Enter Title.', 'pollen' ),
			'dependency' => array(
				'element' => 'trigger',
				'value' => array( 'trigger-button','trigger-text' ),
			),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Title Tag', 'pollen' ),
			'param_name' => 'title_tag',
			'value' => array(
				__( 'span', 'pollen' ) => 'span',
				__( 'h1', 'pollen' ) => 'h1',
				__( 'h2', 'pollen' ) => 'h2',
				__( 'h3', 'pollen' ) => 'h3',
				__( 'h4', 'pollen' ) => 'h4',
				__( 'h5', 'pollen' ) => 'h5',
				__( 'h6', 'pollen' ) => 'h6',
				__( 'p', 'pollen' ) => 'p',
				__( 'div', 'pollen' ) => 'div',
			),
			'description' => __( 'Select element tag.', 'pollen' ),
			'dependency' => array(
				'element' => 'trigger',
				'value' => array( 'trigger-text' ),
			),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Title Color', 'pollen' ),
			'param_name' => 'text_color',
			'description' => __( 'Select custom title color.', 'pollen' ),
			'dependency' => array(
				'element' => 'trigger',
				'value' => array( 'trigger-text' ),
			),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Alignment', 'pollen' ),
			'param_name' => 'alignment',
			'value' => array(
				__( 'Left', 'pollen' ) => 'trigger-left',
				__( 'Right', 'pollen' ) => 'trigger-right',
				__( 'Center', 'pollen' ) => 'trigger-center',
			),
			'description' => __( 'Select alignment.', 'pollen' ),
		),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Initial Height', 'pollen' ),
			'param_name' => 'initial_height',
			'value' => array(
				__( 'None', 'pollen' ) => '',
				__( '5', 'pollen' ) => '5vh',
				__( '10', 'pollen' ) => '10vh',
				__( '15', 'pollen' ) => '15vh',
				__( '20', 'pollen' ) => '20vh',
				__( '25', 'pollen' ) => '25vh',
				__( '30', 'pollen' ) => '30vh',
				__( '35', 'pollen' ) => '35vh',
				__( '40', 'pollen' ) => '40vh',
				__( '45', 'pollen' ) => '45vh',
				__( '50', 'pollen' ) => '50vh',
			),
			'description' => __( 'Select the initial height for modal.', 'pollen' ),
		),
		
		/*
		* Button Tab
		*/
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Shape', 'pollen' ),
			'description' => __( 'Select shape.', 'pollen' ),
			'param_name' => 'button_shape',
			'value' => array(
				__( 'Rounded', 'pollen' ) => 'pollen-rounded',
				__( 'Square', 'pollen' ) => 'pollen-square',
				__( 'Round', 'pollen' ) => 'pollen-round',
			),
			'dependency' => array(
				'element' => 'trigger',
				'value' => array( 'trigger-button' ),
			),
			'group' => 'Button',
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Outline Shape', 'pollen' ),
			'description' => __( 'Select outilne shape.', 'pollen' ),
			'param_name' => 'button_outline_shape',
			'value' => array(
				__( 'None', 'pollen' ) => '',
				__( 'Outline', 'pollen' ) => 'pollen-outline',
				__( 'Outline 2x', 'pollen' ) => 'pollen-outline-2',
				__( 'Outline 3x', 'pollen' ) => 'pollen-outline-3',
				__( 'Outline 4x', 'pollen' ) => 'pollen-outline-4',
				__( 'Outline 5x', 'pollen' ) => 'pollen-outline-5',
			),
			'dependency' => array(
				'element' => 'trigger',
				'value' => array( 'trigger-button' ),
			),
			'group' => 'Button',
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Button Color', 'pollen' ),
			'param_name' => 'button_color',
			'value' => array(
				__( 'Preset Color', 'pollen' ) => '',
				__( 'Custom Color', 'pollen' ) => 'custom',
			),
			'description' => __( 'Select icon color.', 'pollen' ),
			'dependency' => array(
				'element' => 'trigger',
				'value' => array( 'trigger-button' ),
			),
			'group' => 'Button',
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Title Color', 'pollen' ),
			'param_name' => 'button_title_color',
			'description' => __( 'Select color.', 'pollen' ),
			'group' => 'Button',
			'dependency' => array(
				'element' => 'button_color',
				'value' => array( 'custom' ),
			),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Background Color', 'pollen' ),
			'param_name' => 'button_background_color',
			'description' => __( 'Select color.', 'pollen' ),
			'group' => 'Button',
			'dependency' => array(
				'element' => 'button_color',
				'value' => array( 'custom' ),
			),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Outline Color', 'pollen' ),
			'param_name' => 'button_outline_color',
			'description' => __( 'Select color.', 'pollen' ),
			'group' => 'Button',
			'dependency' => array(
				'element' => 'button_color',
				'value' => array( 'custom' ),
			),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Size', 'pollen' ),
			'description' => __( 'Select button size.', 'pollen' ),
			'param_name' => 'button_size',
			'value' => array(
				__( 'Small', 'pollen' ) => 'button-size-small',
				__( 'Normal', 'pollen' ) => 'button-size-normal',
				__( 'Large', 'pollen' ) => 'button-size-large',
				__( 'Block', 'pollen' ) => 'button-size-block',
			),
			'dependency' => array(
				'element' => 'trigger',
				'value' => array( 'trigger-button' ),
			),
			'group' => 'Button',
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
			'dependency' => array(
				'element' => 'trigger',
				'value' => array( 'trigger-image' ),
			),
			'group' => 'Image',
		),
		
		array(
			'type' => 'attach_image',
			'heading' => __( 'Upload Image Icon', 'pollen' ),
			'param_name' => 'custom_image_icon',
			'description' => __( 'Upload the custom image icon.', 'pollen' ),
			'group' => 'Image',
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
			'group' => 'Image',
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
			'group' => 'Image',
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
			'group' => 'Image',
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom Icon Color', 'pollen' ),
			'param_name' => 'custom_icon_color',
			'description' => __( 'Select custom icon color.', 'pollen' ),
			'group' => 'Image',
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
			'group' => 'Image',
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
			'group' => 'Image',
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
			'group' => 'Image',
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
			'group' => 'Image',
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
			'group' => 'Image',
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
			'group' => 'Image',
		),
		
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Animations', 'pollen' ),
			'param_name' => 'animations',
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager', 'image_icon', 'svg_icon' ),
			),
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
			'group' => 'Image',
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
			'group' => 'Image',
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
			'group' => 'Image',
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
		"js_view" => 'VcColumnView'
		) );