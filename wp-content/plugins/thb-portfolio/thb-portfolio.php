<?php
/*
Plugin Name: THB Portfolio
Plugin URI: http://
Version: 1.0.8
Author: THBThemes
Description: Portfolio.
Text Domain: thb-portfolio
*/

/**
 * Plugin key.
 * -----------------------------------------------------------------------------
 */
define( 'THB_PORTFOLIO_KEY', 'thb-portfolio' );

/**
 * Plugin base directory.
 * -----------------------------------------------------------------------------
 */
define( 'THB_PORTFOLIO_DIR', plugin_dir_path( __FILE__ ) );
define( 'THB_PORTFOLIO_TEMPLATES_DIR', THB_PORTFOLIO_DIR . 'templates' );

/**
 * Plugin initialization.
 * -----------------------------------------------------------------------------
 */
function thb_portfolio_init() {
	load_plugin_textdomain( THB_PORTFOLIO_KEY, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'init', 'thb_portfolio_init' );

/**
 * Plugin activation.
 * -----------------------------------------------------------------------------
 */
function thb_portfolio_activation() {
	add_action( 'wp_loaded', 'flush_rewrite_rules' );
}

register_activation_hook( __FILE__, 'thb_portfolio_activation' );

/**
 * Plugin deactivation.
 * -----------------------------------------------------------------------------
 */
function thb_portfolio_deactivation() {
	flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'thb_portfolio_deactivation' );

/**
 * Plugin configuration.
 * -----------------------------------------------------------------------------
 */
function thb_portfolio_config( $key=null ) {
	$config = apply_filters( 'thb_portfolio_config', array(
		/**
		 * Enable the creation of an option tab in the main options page.
		 */
		'options' => true,

		/**
		 * Enable the creation of an option for the works navigation inside the main
		 * work options tab.
		 */
		'works_navigation' => true,

		/**
		 * Enable the creation of an option for set the index for the Portfolio page.
		 */
		'portfolio_index' => true,

		/**
		 * Enable the creation of an options metabox in the pages editing screens
		 * of the page templates associated to the post type.
		 */
		'metabox' => true,

		/**
		 * Enable the creation of an options metabox in the work editing screen
		 * (related works).
		 */
		'single' => true,

		/**
		 * Enable the creation of an external URL field for works entries.
		 */
		'work_external_url' => true,

		/**
		 * Enable the creation of a details options metabox in the work editing
		 * screen. Possible values: false, 'text', 'keyvalue'
		 */
		'work_details' => false,

		/**
		 * Enable the creation of a work slideshow configuration metabox in the work
		 * editing screen.
		 * Was: "thb_slideshows_configuration_container".
		 */
		'work_slides_config' => false,

		/**
		 * Enable the creation of a work slides metabox in the work editing screen.
		 */
		'work_slides' => false,

		/**
		 * The key of the work slides duplicable items.
		 */
		'work_slides_key' => 'work_slide',

		/**
		 * Set to true to automatically create a sidebar for the Portfolio.
		 */
		'sidebars' => false,

		/**
		 * A list of page templates that implement the Portfolio module.
		 */
		'templates' => array(),

		/**
		 * A list of page templates that implement AJAX filtering and pagination.
		 */
		'ajax' => array(),

		/**
		 * A list of page templates that implement the Portfolio module in a grid format.
		 */
		'grid_templates' => array(),

		/**
		 * A list of columns available for grid templates.
		 */
		'grid_templates_columns' => array(),

		/**
		 * A list of columns available for grid builder blocks.
		 */
		'grid_builder_columns' => array(),

		/**
		 * A list of page templates that do not implement pagination.
		 */
		'pagination_disabled_templates' => array(),

		/**
		 * Portfolio layouts enable for builder blocks
		 */
		'builder_portfolio_layouts' => array()
	) );

	if( !empty($key) && isset($config[$key]) ) {
		return $config[$key];
	}

	return $config;
}

/**
 * Plugin configuration.
 * -----------------------------------------------------------------------------
 */
function thb_portfolio_framework_check() {
	return class_exists('THB_Theme');
}

/**
 * Post type creation
 * -----------------------------------------------------------------------------
 */
require_once dirname(__FILE__) . '/inc/posttype.php';

/**
 * Page templates
 * -----------------------------------------------------------------------------
 */
function thb_portfolio_page_templates() {
	if( thb_portfolio_framework_check() ) {
		$thb_works = thb_theme()->getPostType('works');

		foreach( thb_portfolio_config('templates') as $template ) {
			$thb_works->addPageTemplate($template);
		}
	}
}

add_action( 'init', 'thb_portfolio_page_templates' );

/**
 * Sidebars
 * -----------------------------------------------------------------------------
 */
function thb_portfolio_sidebars() {
	if( thb_portfolio_framework_check() && thb_portfolio_config('sidebars') ) {
		$thb_theme = thb_theme();
		$thb_works = $thb_theme->getPostType('works');

		$thb_theme->addSidebar( __('Portfolio sidebar', 'thb-portfolio'), 'works-sidebar' );
		$thb_works->setSidebar('works-sidebar');
	}
}

add_action( 'init', 'thb_portfolio_sidebars' );

/**
 * Portfolio general options
 * -----------------------------------------------------------------------------
 */
require_once dirname(__FILE__) . '/inc/options.php';

/**
 * Portfolio frontend utilities
 * -----------------------------------------------------------------------------
 */
require_once dirname(__FILE__) . '/inc/frontend.php';

/**
 * Portfolio builder block
 * -----------------------------------------------------------------------------
 */
if( ! function_exists('thb_portfolio_builder_blocks') ) {
	function thb_portfolio_builder_blocks() {
		if ( function_exists( 'thb_builder_instance' ) ) {
			require_once dirname(__FILE__) . '/inc/builder_blocks.php';
		}
	}

	add_action( 'wp_loaded', 'thb_portfolio_builder_blocks' );
}