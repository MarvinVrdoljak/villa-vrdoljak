<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

if( ! class_exists( 'THB_PortfolioBlock' ) && function_exists( 'thb_builder' ) ) {
	/**
	 * Builder blog block.
	 */
	class THB_PortfolioBlock extends THB_BuilderBlock {

		/**
		 * Constructor
		 *
		 * @param string $title The block title.
		 **/
		public function __construct()
		{
			parent::__construct(
				'thb_portfolio',
				__( 'Portfolio', 'thb-portfolio' ),
				THB_PORTFOLIO_TEMPLATES_DIR . '/block_thb_portfolio'
			);

			$this->setDescription( __( 'Load a Portfolio loop, with different style variants.', 'thb-portfolio' ) );

			$this->buildModals();
		}

		/**
		 * Build the block modals.
		 */
		private function buildModals()
		{
			$thb_modal = new THB_Modal( $this->getTitle(), $this->getSlug() );
				$thb_modal_container = $thb_modal->createContainer( '', $this->getSlug() . '_container' );

					$thb_field = new THB_TextField( 'title' );
					$thb_field->setLabel( __( 'Title', 'thb-portfolio' ) );
					$thb_modal_container->addField( $thb_field );

					$thb_field = new THB_GraphicRadioField( 'layout' );
					$thb_field->setLabel( __( 'Layout', 'thb_text_domain' ) );
					$thb_field->setOptions( thb_portfolio_config( 'builder_portfolio_layouts' ) );
					$thb_modal_container->addField( $thb_field );

					thb_grid_layout_add_fields( $thb_modal_container, thb_portfolio_config( 'grid_builder_columns' ) );

					$thb_field = new THB_QueryFilterField( 'query_filter' );
					$thb_field->addClass('full');
					$thb_field->setTaxonomies( thb_get_post_type_taxonomies( 'works' ) );
					$thb_modal_container->addField( $thb_field );

					$thb_field = new THB_CheckboxField( 'disable_filter' );
						$thb_field->setLabel( __('Disable filter', 'thb-portfolio') );
					$thb_modal_container->addField($thb_field);

					$thb_field = new THB_YesNoField( 'works_ajax_pagination' );
						$thb_field->setLabel( __('Use AJAX pagination', 'thb-portfolio') );
						$thb_field->setHelp( __('If the page template supports this feature (e.g. its items are filterable), enabling AJAX pagination won\'t refresh your page while filtering through Portfolio items.', 'thb-portfolio') );
					$thb_modal_container->addField($thb_field);

				$thb_modal_container = $thb_modal->createContainer( __( 'Carousel', 'thb_text_domain' ), $this->getSlug() . '_carousel_container' );

					thb_carousel_options( $thb_modal_container );

			$this->addModal( $thb_modal );
		}

		/**
		 * The classes to be added to the block element on frontend.
		 *
		 * @param array $block_data
		 * @return array
		 */
		public function blockClasses( $block_data ) {
			$block_classes = array(
				$block_data['layout']
			);

			if ( $block_data['carousel'] == '0' ) {
				$block_classes[] = 'masonry';
			} else {
				$block_classes[] = 'carousel';
			}

			return array_merge( $block_classes, parent::blockClasses( $block_data ) );
		}

	}

	thb_builder_instance()->addBlock( new THB_PortfolioBlock() );
}