<?php

/**
 * Portfolio options.
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
 * Main page options tab.
 */
function thb_portfolio_options() {
	if( thb_portfolio_framework_check() && thb_portfolio_config('options') ) {
		$thb_page = thb_theme()->getAdmin()->getMainPage();

		$thb_tab = new THB_Tab( __('Portfolio', 'thb-portfolio'), 'portfolio' );
			$thb_container = $thb_tab->createContainer( '', 'single_work_options' );

			$thb_field = new THB_TextField('works_url_slug');
				$thb_field->setLabel( __('URL slug', 'thb-portfolio') );
				$thb_field->setHelp( sprintf( __('URL slug for Portfolio items. Defaults to "works". Remember to <a href="%s">re-save the site\'s permalinks</a>.', 'thb-portfolio'), admin_url('options-permalink.php')) );
			$thb_container->addField($thb_field);

			if( thb_portfolio_config('works_navigation') ) {
				$thb_field = new THB_YesNoField( 'works_navigation' );
					$thb_field->setLabel( __('Enable navigation between Portfolio items', 'thb-portfolio') );
				$thb_container->addField($thb_field);
			}

			if( thb_portfolio_config('portfolio_index') ) {
				$thb_field = new THB_SelectField('portfolio_index');
				$thb_field->setLabel( __('Select the Portfolio index', 'thb_text_domain') );
				$thb_field->setHelp( __('Choose the index page for your portfolio items "back to portfolio" link.', 'thb_text_domain') );
				$thb_field->setOptions( thb_get_pages_for_select('template-portfolio.php') );
				$thb_container->addField($thb_field);
			}

		$thb_page->addTab($thb_tab);
	}
}

add_action( 'init', 'thb_portfolio_options' );

/**
 * Portfolio page templates options metabox
 */
function thb_add_portfolio_metabox() {
	if( thb_portfolio_framework_check() && thb_portfolio_config('metabox') && thb_is_admin_template(thb_portfolio_config('templates')) ) {
		$ajax = thb_portfolio_config('ajax');
		$grid = thb_portfolio_config( 'grid_templates' );
		$grid_columns = thb_portfolio_config( 'grid_templates_columns' );

		$thb_metabox = new THB_Metabox( __('Portfolio options', 'thb-portfolio'), 'portfolio_options' );
		$thb_metabox->setPriority('high');

		$thb_container = $thb_metabox->createContainer( '', 'portfolio_loop_container' );

		if ( ! empty( $grid ) ) {
			if ( thb_is_admin_template( $grid ) ) {
				$current_template = thb_get_admin_template();

				// if ( isset( $grid_columns[$current_template] ) ) {
				if( in_array( $current_template, array_keys( $grid_columns ) ) ) {
					thb_grid_layout_add_fields( $thb_container, $grid_columns[$current_template] );
				}
			}
		}

		$thb_container = $thb_metabox->createContainer( 'Filtering & ordering', 'portfolio_filtering_container' );
			$thb_field = new THB_QueryFilterField('works_query');
			$thb_field->addClass('full');
			$thb_field->setTaxonomies( thb_get_post_type_taxonomies('works') );

			if( thb_is_admin_template( thb_portfolio_config('pagination_disabled_templates') ) ) {
				$thb_field->setHideNum();
			}

		$thb_container->addField($thb_field);

		$thb_container = $thb_metabox->getContainer( 'portfolio_loop_container' );

		if( !empty($ajax) ) {
			if( thb_is_admin_template($ajax) ) {
				$thb_field = new THB_YesNoField( 'works_ajax_pagination' );
					$thb_field->setLabel( __('Use AJAX pagination', 'thb-portfolio') );
					$thb_field->setHelp( __('If the page template supports this feature (e.g. its items are filterable), enabling AJAX pagination won\'t refresh your page while filtering through Portfolio items.', 'thb-portfolio') );
				$thb_container->addField($thb_field);
			}
		}

		thb_theme()->getPostType('page')->addMetabox($thb_metabox);
	}
}

add_action( 'wp_loaded', 'thb_add_portfolio_metabox' );

/**
 * Portfolio single entries options
 */
function thb_portfolio_single_options() {
	if( thb_portfolio_framework_check() ) {
		$thb_works = thb_theme()->getPostType('works');

		$slide_field = new THB_SlideField( thb_portfolio_config('work_slides_key') );
		$slide_field->setLabel( __('Slide', 'thb_text_domain') );
		$slide_field = apply_filters( 'thb_work_slide', $slide_field );

		if( thb_is_admin_template('single-works.php') && thb_portfolio_config('single') ) {
			$thb_metabox = thb_theme()->getPostType('works')->getMetabox('layout');
				$thb_container = $thb_metabox->createContainer( __('Related works', 'thb-portfolio'), 'related_works' );

				$thb_field = new THB_CheckboxField( 'works_related' );
					$thb_field->setLabel( __('Enable a related works section', 'thb-portfolio') );
					$thb_field->setHelp( __('Selecting "Yes" automatically creates a "related works" section at the bottom of a Portfolio item page.', 'thb-portfolio') );
					$thb_field->setDynamicDefault( 'thb_default_works_related' );
				$thb_container->addField($thb_field);

				$thb_field = new THB_NumberField('works_related_number');
					$thb_field->setLabel( __('Related works to show', 'thb-portfolio') );
					$thb_field->setHelp( __('Choose how many related works you want to display. Defaults to 3.', 'thb-portfolio') );
					$thb_field->setDynamicDefault( 'thb_default_works_related_number' );
				$thb_container->addField($thb_field);

				$thb_field = new THB_CheckboxField('works_related_thumb');
					$thb_field->setLabel( __('Show thumbnails in related works', 'thb-portfolio') );
					$thb_field->setHelp( __('Choose to enable the display of thumbnails for related works.', 'thb-portfolio') );
					$thb_field->setDynamicDefault( 'thb_default_works_related_thumb' );
				$thb_container->addField($thb_field);
		}

		$thb_metabox = new THB_Metabox( __('Project data', 'thb-portfolio'), 'extra' );
		$thb_metabox->setPriority('high');

		if ( thb_portfolio_config( 'work_external_url' ) ) {
			$thb_container = $thb_metabox->createContainer( '', 'data_details' );
				$field = new THB_TextField( 'external_url' );
				$field->setLabel( __( 'External URL', 'thb_text_domain' ) );
				$field->setHelp( __('Insert here an external URL to link to in Portfolio pages directly.', 'thb-portfolio') );
				$thb_container->addField($field);
		}

		if( $work_details = thb_portfolio_config('work_details') ) {
			if( $work_details == 'text' ) {
				$thb_container = $thb_metabox->createContainer( __('Details', 'thb_text_domain'), 'details' );
					$field = new THB_TextareaField( 'prj_info' );
					$field->setHelp( __('Insert here your project details (Note: accepts basic HTML).', 'thb-portfolio') );
					$thb_container->addField($field);
			}
			elseif( $work_details == 'keyvalue' ) {
				$thb_container = $thb_metabox->createDuplicableContainer( __('Details', 'thb_text_domain'), 'details' );
					$thb_container->addControl( __('Add', 'thb-portfolio'), '' );
					$thb_container->setSortable();

					$thb_upload = new THB_KeyValueField( 'prj_info' );
					$thb_upload->setLabel( __('Detail', 'thb-portfolio') );
					$thb_container->setField($thb_upload);
			}

			$thb_works->addMetabox($thb_metabox, array(), 0);
		}

		if( thb_portfolio_config('work_slides') ) {
			if( $work_slides_config = thb_portfolio_config('work_slides_config') ) {
				if( is_callable($work_slides_config) ) {
					$thb_metabox->addContainer( call_user_func($work_slides_config) );
				}
			}

				$thb_container = new THB_MetaboxDuplicableFieldsContainer( __('Project images and videos', 'thb_text_domain'), 'slides_container' );
				$thb_container->setSortable();

				$thb_container->addControl( __('Add images', 'thb_text_domain'), 'add_image', '', array(
					'action' => 'thb_add_multiple_slides',
					'title'  => __('Add images', 'thb_text_domain')
				) );

				$thb_container->addControl( __('Add video', 'thb_text_domain'), 'add_video', '', array(
					'action' => 'thb_add_video_slide',
					'title'  => __('Add video', 'thb_text_domain')
				) );

					$thb_container->setField($slide_field);

				$thb_metabox->addContainer($thb_container);

			$thb_works->addMetabox($thb_metabox);
		}
	}
}

add_action( 'init', 'thb_portfolio_single_options', 20 );