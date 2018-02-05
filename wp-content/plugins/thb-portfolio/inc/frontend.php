<?php

/**
 * Portfolio frontend functions.
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

/**
 * Load a template part into a template.
 *
 * @uses locate_template()
 * @param string $name The slug name for the generic template to load.
 * @param array $data
 */
function thb_portfolio_get_template_part( $name, $data=array() ) {
	if( ! thb_portfolio_framework_check() ) {
		return;
	}

	thb_get_subtemplate(THB_PORTFOLIO_KEY, THB_PORTFOLIO_DIR, $name, $data);
}

/**
 * Get the Portfolio single work slides.
 *
 * @param integer $id The work id.
 * @return array
 */
function thb_get_portfolio_item_slides( $id = null ) {
	return thb_get_entry_slides( 'work_slide', $id );
}

/**
 * Create a custom 'works' entries loop.
 *
 * @param array $params The portfolio loop parameters.
 */
function thb_portfolio_query( $params = array() ) {
	if( ! thb_portfolio_framework_check() ) {
		return;
	}

	global $wp_query;
	$post_type = 'works';

	$args = thb_post_type_query_args($post_type, null, $params);
	$args = thb_array_asum($args, $params);

	thb_query_posts($post_type, $args);
}

/**
 * Get the current filter items for a portfolio page.
 *
 * @param array $args The portfolio loop parameters.
 * @return array
 */
function thb_portfolio_get_filter_terms( $args = array() ) {
	$args = thb_post_type_query_args( 'works', null, $args );
	$terms_args = array();

	if ( isset( $args['tax_query'] ) ) {
		foreach ( $args['tax_query'] as $tax_query ) {
			if ( $tax_query['taxonomy'] == 'portfolio_categories' ) {
				if ( $tax_query['operator'] == 'IN' ) {
					$terms_args['include'] = $tax_query['terms'];
				}
				elseif ( $tax_query['operator'] == 'NOT IN' ) {
					$terms_args['exclude'] = $tax_query['terms'];
				}
			}
		}
	}

	$terms = get_terms( 'portfolio_categories', $terms_args );

	return $terms;
}

/**
 * Check if a portfolio page is filtered by only one category.
 *
 * @param array $params The portfolio loop parameters.
 * @return boolean
 */
function thb_portfolio_is_single_filtered( $params = array() ) {
	if( ! thb_portfolio_framework_check() ) {
		return;
	}

	$terms = thb_portfolio_get_filter_terms( $params );

	return count( $terms ) == 1;
}

/**
 * Check if a portfolio page is filtered via AJAX by one or more categories.
 *
 * @return boolean
 */
function thb_portfolio_is_ajax_filtered() {
	if( ! thb_portfolio_framework_check() ) {
		return;
	}

	if ( isset( $_GET['filter'] ) ) {
		return $_GET['filter'] != '';
	}
	elseif ( isset( $_GET['filter_exclude'] ) ) {
		return $_GET['filter_exclude'] != '';
	}

	return false;
}

/**
 * Return the terms IDs of the terms currently being filtered.
 *
 * @param array $params The portfolio loop parameters.
 * @return array
 */
function thb_portfolio_get_applied_filter_term_ids( $params = array() ) {
	if( ! thb_portfolio_framework_check() ) {
		return;
	}

	$ids = array();

	if ( thb_portfolio_is_ajax_filtered() ) {
		$current_terms = thb_portfolio_get_filter_terms( $params );

		foreach ( $current_terms as $term ) {
			$ids[] = $term->term_id;
		}
	}

	return $ids;
}

/**
 * Display a filter for the portfolio items.
 *
 * @param array $params The portfolio loop parameters.
 */
function thb_portfolio_filter( $params = array() ) {
	if( ! thb_portfolio_framework_check() ) {
		return;
	}

	$thb_show_portfolio_filter = ! thb_portfolio_is_single_filtered( $params );
	$thb_show_portfolio_filter = apply_filters( 'thb_show_portfolio_filter', $thb_show_portfolio_filter );

	if ( ! $thb_show_portfolio_filter ) {
		return;
	}

	thb_portfolio_get_template_part( 'portfolio-filter', array(
		'args' => $params
	) );
}

/**
 * Display a loop for the portfolio items.
 *
 * @param array $params The portfolio loop parameters.
 */
function thb_portfolio_loop( $params = array() ) {
	if( ! thb_portfolio_framework_check() ) {
		return;
	}

	$params = wp_parse_args( $params, array(
		'portfolio_template'      => 'portfolio',
		'portfolio_item_template' => 'portfolio-item',
		'num_cols'                => thb_get_grid_columns(), // Compat
		'columns'                 => thb_get_grid_columns(),
		'gutter'                  => function_exists( 'thb_get_grid_gutter' ) ? thb_get_grid_gutter() : '',
		'work_image_size'         => 'full',
		'images_height'           => thb_get_grid_images_height()
	) );

	thb_portfolio_get_template_part( $params['portfolio_template'], $params );
}

/**
 * Display a single portfolio items within the portfolio loop.
 *
 * @param array $params The portfolio item parameters.
 * @return void
 */
function thb_portfolio_item( $params=array() ) {
	$params = thb_array_asum(array(
		'portfolio_item_template' => 'portfolio-item'
	), $params);

	thb_portfolio_get_template_part($params['portfolio_item_template'], $params);
}

/**
 * Print the data filters for the portfolio item.
 */
function thb_portfolio_item_datafilters() {
	$thb_id = get_the_ID();
	$work_types = wp_get_object_terms( $thb_id, 'portfolio_categories' );
	$filters = array();

	if( ! empty($work_types) ) {
		foreach( $work_types as $type ) {
			$filters['filter-' . $type->term_id] = '';
		}
	}

	thb_data_attributes($filters);
}

/**
 * Get the portfolio item subtitle.
 *
 * @return string
 */
function thb_get_portfolio_item_subtitle() {
	$thb_id = get_the_ID();
	$work_types = wp_get_object_terms( $thb_id, 'portfolio_categories' );
	$types = array();

	if( ! empty($work_types) ) {
		foreach( $work_types as $type ) {
			$types[] = $type->name;
		}
	}

	return join($types, ", ");
}

/**
 * Print the portfolio item subtitle.
 */
function thb_portfolio_item_subtitle() {
	echo thb_get_portfolio_item_subtitle();
}

/**
 * Prints the classes for the work item as an HTML attribute.
 *
 * @param string|array $classes
 */
function thb_portfolio_post_class( $classes='' ) {
	global $wp_query, $post;

	$classes = (array) $classes;

	$class = get_post_class('', $post->ID);
	$class[] = 'item-' . $wp_query->current_post;

	foreach( $classes as $c ) {
		if( ! in_array($c, $class) ) {
			$class[] = $c;
		}
	}

	echo 'class="' . esc_attr( join(' ', $class) ) . '"';
}

/**
 * Read the page options and make them available for the Javascript side of things
 */
function thb_portfolio_localize_script() {
	if ( ! thb_portfolio_framework_check() ) {
		return;
	}

	if( thb_is_page_template(thb_portfolio_config('templates')) ) {
		wp_localize_script('jquery', 'thb_portfolio', array(
			'use_ajax' => (int) thb_get_post_meta( get_the_ID(), 'works_ajax_pagination' ),
			'base' => get_permalink( get_the_ID() )
		));
	}
}

add_action( 'wp_enqueue_scripts', 'thb_portfolio_localize_script', 11 );

/**
 * Read the modal configuration and make them available for the Javascript side of things.
 *
 * @param array $params The portfolio loop parameters.
 */
function thb_portfolio_data_attributes( $params = array() ) {
	if ( ! thb_portfolio_framework_check() ) {
		return;
	}

	$params = wp_parse_args( $params, array(
		'ajax_pagination' => (int) thb_get_post_meta( get_the_ID(), 'works_ajax_pagination' )
	) );

	$data = array(
		'ajax' => (int) isset( $params['ajax_pagination'] ) ? $params['ajax_pagination'] : 0,
		'base' => get_permalink( thb_get_page_ID() )
	);

	thb_data_attributes( $data );
}

/**
 * Classes to be added to the portfolio items container.
 *
 * @param integer $columns
 * @param string $gutter
 * @return string
 */
function thb_get_portfolio_classes( $columns, $gutter = false ) {
	$classes = array(
		'thb-grid-layout',
		thb_get_grid_class_name( $columns, $gutter )
	);

	$classes = apply_filters( 'thb_portfolio_classes', $classes );

	return implode( ' ', (array) $classes );
}

/**
 * Print the classes to be added to the portfolio items container.
 *
 * @param integer $columns
 */
function thb_portfolio_classes( $columns ) {
	echo thb_get_portfolio_classes( $columns );
}

/**
 * Body classes
 * -----------------------------------------------------------------------------
 */
function thb_portfolio_body_classes( $classes ) {
	if ( ! thb_portfolio_framework_check() ) {
		return;
	}

	$thb_portfolio_grid_templates = thb_portfolio_config( 'grid_templates' );
	$grid_body_class = thb_config( 'backpack/layout', 'grid_body_class' );

	if( $grid_body_class && thb_is_page_template( $thb_portfolio_grid_templates ) ) {
		$classes[] = thb_get_grid_class_name( thb_get_grid_columns() );
	}

	return $classes;
}

add_filter( 'body_class', 'thb_portfolio_body_classes' );

if( !function_exists('thb_portfolio_get_index') ) {
	/**
	 * Retrieve the page ID of the Portfolio index.
	 *
	 * @return integer
	 */
	function thb_portfolio_get_index() {
		$id = thb_get_option( 'portfolio_index' );
		$page = get_post( $id );

		if ( ! $page ) {
			$id = 0;
		}

		return $id;
	}
}

if( ! function_exists( 'thb_portfolio_item_get_external_url' ) ) {
	/**
	 * Return the Portfolio item external URL.
	 *
	 * @param integer $id
	 * @return string
	 */
	function thb_portfolio_item_get_external_url( $id = null ) {
		if ( ! $id ) {
			$id = get_the_ID();
		}

		$external_url = esc_url( thb_get_post_meta( $id, 'external_url' ) );

		return $external_url;
	}
}

if( ! function_exists( 'thb_portfolio_item_get_permalink' ) ) {
	/**
	 * Return a permalink for the Portfolio item.
	 *
	 * @param integer $id
	 * @return string
	 */
	function thb_portfolio_item_get_permalink( $id = null ) {
		if ( ! $id ) {
			$id = get_the_ID();
		}

		$external_url = thb_portfolio_item_get_external_url( $id );

		return ! empty( $external_url ) ? $external_url : get_permalink( $id );
	}
}

if( ! function_exists( 'thb_portfolio_item_permalink' ) ) {
	/**
	 * Display a permalink for the Portfolio item.
	 *
	 * @param integer $id
	 */
	function thb_portfolio_item_permalink( $id = null ) {
		if ( ! $id ) {
			$id = get_the_ID();
		}

		echo thb_portfolio_item_get_permalink( $id );
	}
}