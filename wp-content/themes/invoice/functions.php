<?php
/**
 * invoice functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package invoice
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'invoice_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function invoice_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on invoice, use a find and replace
		 * to change 'invoice' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'invoice', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'invoice' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
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

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'invoice_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'invoice_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function invoice_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'invoice_content_width', 640 );
}
add_action( 'after_setup_theme', 'invoice_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function invoice_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'invoice' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'invoice' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'invoice_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function invoice_scripts() {
	wp_enqueue_style( 'invoice-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'invoice-style', 'rtl', 'replace' );

	wp_enqueue_script( 'invoice-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	// wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.6.0.min.js', array( 'jquery' ), '3.6.0', true );
	wp_enqueue_style( 'wpb-fa', get_stylesheet_directory_uri() . '/style/all.css' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if( is_archive('invoices') ){
		wp_enqueue_script('momentjs', get_template_directory_uri() . '/js/moment.min.js', array('jquery'), '', false);
		wp_enqueue_script('daterangepicker', get_template_directory_uri() . '/js/daterangepicker.js', array('jquery'), '', false);
		wp_enqueue_script('archive-invoices', get_template_directory_uri() . '/custom-js/archive-invoices.js', array('jquery'), '', false);
		wp_enqueue_style( 'daterangepicker-style', get_template_directory_uri() . '/style/daterangepicker.css', array(), _S_VERSION );
	} 
}
add_action( 'wp_enqueue_scripts', 'invoice_scripts' );
/**
 * Create Custom Post Types
 */
add_action( 'init', 'custom_post_types');
require get_template_directory() . '/custom-post-types/custom-post-type.php';
/**
 * Create Custom Taxonomies
 */
add_action( 'init', 'custom_taxonomies');
require get_template_directory() . '/custom-taxonomies/custom-taxonomies.php';
/**
 * Additional class for header menu items
 */
function add_additional_class_on_header_menu_item($classes, $item, $args) {
	if(isset($args->add_li_class)) {
			$classes[] = $args->add_li_class;
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_header_menu_item', 1, 3);
/**
 * Set invoice title
 */
function change_invoice_title($data, $postarr){
	if($postarr['post_type'] == 'invoices'){
		$data['post_title'] = 'Invoice #' . $postarr['ID'];
	}
	return $data;
}
add_filter('wp_insert_post_data', 'change_invoice_title', 99, 2);
/**
 * APIs
 */
require get_template_directory() . '/api/router.php';
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

