<?php

/**
 * Portfolio custom post type.
 *
 * ---
 *
 * The Happy Framework: WordPress Development Framework
 * Copyright 2012, Andrea Gandino & Simone Maranzana
 *
 * Licensed under The MIT License
 * Redistribuitions of files must retain the above copyright notice.
 *
 * @package THB Portfolio
 * @author The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright 2012, Andrea Gandino & Simone Maranzana
 * @link http://
 * @since The Happy Framework v 1.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

function thb_portfolio_post_type() {

	/**
	 * The post type labels.
	 *
	 * @see http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	$thb_works_labels = array(
		'name'               => __('Portfolio', 'thb-portfolio'),
		'singular_name'      => __('Work', 'thb-portfolio'),
		'add_new'            => __('Add new', 'thb-portfolio'),
		'add_new_item'       => __('Add new Work', 'thb-portfolio'),
		'edit'               => __('Edit', 'thb-portfolio'),
		'edit_item'          => __('Edit Work', 'thb-portfolio'),
		'new_item'           => __('New Work', 'thb-portfolio'),
		'view'               => __('View Work', 'thb-portfolio'),
		'view_item'          => __('View Work', 'thb-portfolio'),
		'search_items'       => __('Search Works', 'thb-portfolio'),
		'not_found'          => __('No Works found', 'thb-portfolio'),
		'not_found_in_trash' => __('No Works found in Trash', 'thb-portfolio'),
		'parent'             => __('Parent Work', 'thb-portfolio')
	);

	/**
	 * The post type arguments.
	 *
	 * @see http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	if( thb_portfolio_framework_check() ) {
		$options_slug = thb_get_option('works_url_slug');
	}
	else {
		$options_slug = apply_filters( 'thb_portfolio_slug', '' );
	}

	$slug = !empty( $options_slug ) ? $options_slug : 'works';

	$thb_works_args = array(
		'labels'            => $thb_works_labels,
		'public'            => true,
		'show_ui'           => true,
		'capability_type'   => 'post',
		'hierarchical'      => false,
		'rewrite'           => array( 'slug' => $slug, 'with_front' => true ),
		'query_var'         => true,
		'show_in_nav_menus' => true,
		'supports'          => array('title', 'thumbnail', 'excerpt', 'editor', 'comments', 'custom-fields')
	);

	/**
	 * Create the post type object.
	 */
	register_post_type('works', $thb_works_args);

	if( thb_portfolio_framework_check() ) {
		$thb_works = new THB_PostType('works', $thb_works_args);
	}

	/**
	 * Create the post type taxonomy for Works categories.
	 */
	$thb_portfolio_categories_args = array(
		'hierarchical'   => true,
		'labels' => array(
			'name'              => __('Portfolio Categories', 'thb-portfolio' ),
			'singular_name'     => __('Portfolio Category', 'thb-portfolio' ),
			'search_items'      => __( 'Search Portfolio Categories', 'thb-portfolio' ),
			'all_items'         => __( 'All Portfolio Categories', 'thb-portfolio' ),
			'parent_item'       => __( 'Parent Portfolio Category', 'thb-portfolio' ),
			'parent_item_colon' => __( 'Parent Portfolio Category:', 'thb-portfolio' ),
			'edit_item'         => __( 'Edit Portfolio Category', 'thb-portfolio' ),
			'update_item'       => __( 'Update Portfolio Category', 'thb-portfolio' ),
			'add_new_item'      => __( 'Add New Portfolio Category', 'thb-portfolio' ),
			'new_item_name'     => __( 'New Portfolio Category Name', 'thb-portfolio' ),
			'menu_name'         => __( 'Portfolio Category', 'thb-portfolio' )
		),
		'rewrite'        => true,
		'query_var'      => true
	);

	register_taxonomy( 'portfolio_categories', 'works', $thb_portfolio_categories_args );

	if ( thb_portfolio_framework_check() ) {
		$thb_works_taxonomy = new THB_Taxonomy('portfolio_categories', $thb_portfolio_categories_args);
		$thb_works->addTaxonomy($thb_works_taxonomy);
	}

	/**
	 * Add the post type to the theme instance.
	 */
	if ( thb_portfolio_framework_check() ) {
		$thb_theme = thb_theme();
		$thb_theme->addPostType($thb_works);
	}
}

add_action( 'init', 'thb_portfolio_post_type' );