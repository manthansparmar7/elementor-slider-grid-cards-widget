<?php
/**
 * Plugin Name: Cards Slider / Grid Elementor Widget
 * Description: Create a versatile 'Cards Slider / Grid' widget for Elementor with advanced customization and seamless functionality.
 * Version:     1.0.0
 * Author:      Manthan Parmar
 * Text Domain: elementor-slider-grid-cards-widget
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.21.0
 * Elementor Pro tested up to: 3.21.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Slider/Grid Cards Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_slider_grid_cards_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/slider-grid-cards-widget.php' );

	$widgets_manager->register( new \Elementor_Slider_Grid_Cards_Widget() );

}
add_action( 'elementor/widgets/register', 'register_slider_grid_cards_widget' );


// Enqueue the CSS in your plugin's main file or within the widget class constructor
function cards_slider_grid_widget_dependencies() {
	wp_enqueue_script( 'swiper-js', plugin_dir_url( __FILE__ ) . 'assets/js/swiper-bundle.min.js', [], '1.0.0', true );
	wp_enqueue_style( 'slider-grid-cards-widget-elementor-editor-style', plugin_dir_url( __FILE__ ) . 'assets/css/custom-style.css', array(), '1.0.0' );
	wp_enqueue_script( 'slider-grid-cards-widget-elementor-editor-script', plugin_dir_url( __FILE__ ) . 'assets/js/custom-scripts.js', array('jquery'), '1.0.0', true );

}
add_action('wp_enqueue_scripts', 'cards_slider_grid_widget_dependencies');