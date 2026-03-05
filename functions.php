<?php
/**
 * Resplandor Theme functions and definitions
 */

if ( ! function_exists( 'resplandor_setup' ) ) :
	function resplandor_setup() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Register Navigation Menus (Optional, for future use)
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'resplandor' ),
			)
		);

		// Switch default core markup for HTML5 features
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'resplandor_setup' );

/**
 * Enqueue scripts and styles.
 */
function resplandor_scripts() {
	// Enqueue Google Fonts
	wp_enqueue_style( 'resplandor-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null );

	// Enqueue Theme Main CSS
	wp_enqueue_style( 'resplandor-style', get_template_directory_uri() . '/css/web.css', array(), filemtime( get_template_directory() . '/css/web.css' ) );
    
    // Theme stylesheet (style.css)
    wp_enqueue_style( 'resplandor-main-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );

	// Enqueue Theme Main JS
	wp_enqueue_script( 'resplandor-scripts', get_template_directory_uri() . '/js/scripts.js', array(), filemtime( get_template_directory() . '/js/scripts.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'resplandor_scripts' );

/**
 * Custom Nav Walker
 */
require get_template_directory() . '/inc/class-resplandor-nav-walker.php';
require get_template_directory() . '/inc/class-resplandor-mobile-no-children-walker.php';

/**
 * Add WooCommerce Support
 */
function add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'add_woocommerce_support' );

/**
 * Handle WooCommerce AJAX Cart Fragments
 */
function resplandor_cart_fragments( $fragments ) {
    $count = WC()->cart->get_cart_contents_count();
    $fragments['span.cart-count-dynamic'] = '<span class="cart-badge cart-count-dynamic">' . $count . '</span>';
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'resplandor_cart_fragments' );