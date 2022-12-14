<?php
/**
 * Pollen Shortcodes settings Lazy mapping
 *
 * @package Pollen
 *
 */



$options = get_option('pollen');
$pollen_elements_root = dirname(__FILE__);
$pollen_element_path = $pollen_elements_root . "/elements/";
require_once $pollen_elements_root . '/custom-default-elements.php';

/*-----------------------------------------------------------------------------------*/
/*	Essencial Elements
/*-----------------------------------------------------------------------------------*/
if ( $options['pollen_element_alert'] == true ) { vc_lean_map( 'pollen_alert', null, $pollen_element_path . 'alert.php' ); }

if ( $options['pollen_element_circular_progress_bar'] == true ) { vc_lean_map( 'pollen_circular_progress_bar', null, $pollen_element_path . 'circular-progress-bar.php' ); }

if ( $options['pollen_element_counter'] == true ) { vc_lean_map( 'pollen_counter', null, $pollen_element_path . 'counter.php' ); }

if ( $options['pollen_element_icon'] == true ) { vc_lean_map( 'pollen_icon', null, $pollen_element_path . 'icon.php' ); }

if ( $options['pollen_element_infobox'] == true ) { vc_lean_map( 'pollen_infobox', null, $pollen_element_path . 'infobox.php' ); }

if ( $options['pollen_element_progress_bar'] == true ) { vc_lean_map( 'pollen_progress_bar', null, $pollen_element_path . 'progress-bar.php' ); }

if ( $options['pollen_element_semi_circular_progress_bar'] == true ) { vc_lean_map( 'pollen_semi_circular_progress_bar', null, $pollen_element_path . 'semi-circular-progress-bar.php' ); }

if ( $options['pollen_element_svg'] == true ) { vc_lean_map( 'pollen_svg', null, $pollen_element_path . 'svg.php' ); }

/*-----------------------------------------------------------------------------------*/
/*	Essencial Nested Elements
/*-----------------------------------------------------------------------------------*/
if ( $options['pollen_element_icon_group'] == true ) { require_once $pollen_element_path . 'icon-group.php'; }

if ( $options['pollen_element_list_group'] == true ) { require_once $pollen_element_path . 'list-group.php'; }

if ( $options['pollen_element_modal'] == true ) { require_once $pollen_element_path . 'modal.php' ; }

if ( $options['pollen_element_pricing'] == true ) { require_once $pollen_element_path . 'pricing.php' ; }

if ( $options['pollen_element_testimonial'] == true ) { require_once $pollen_element_path . 'testimonial.php' ; }

/*-----------------------------------------------------------------------------------*/
/*	Premium Elements
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Premium Nested Elements
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Unlimited Elements
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Unlimited Nested Elements
/*-----------------------------------------------------------------------------------*/