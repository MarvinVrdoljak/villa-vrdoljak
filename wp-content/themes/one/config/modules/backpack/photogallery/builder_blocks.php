<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

if( ! class_exists( 'THB_PhotogalleryBlock' ) && function_exists( 'thb_builder' ) ) {
	/**
	 * Builder blog block.
	 */
	class THB_PhotogalleryBlock extends THB_BuilderBlock {

		/**
		 * Constructor
		 *
		 * @param string $title The block title.
		 **/
		public function __construct()
		{
			parent::__construct(
				'thb_photogallery',
				__( 'Photogallery', 'thb_text_domain' ),
				thb_get_module_template_path( 'backpack/photogallery', 'block_thb_photogallery' )
			);

			$this->setDescription( __( 'A collection of images in a grid format.', 'thb_text_domain' ) );

			$this->buildModals();
		}

		/**
		 * Build the block modals.
		 */
		private function buildModals()
		{
			$grid_columns = thb_config( 'backpack/photogallery', 'builder_block_columns' );

			$thb_modal = new THB_Modal( $this->getTitle(), $this->getSlug() );
				$thb_modal_container = $thb_modal->createContainer( '', $this->getSlug() . '_container' );

					$thb_field = new THB_TextField( 'title' );
					$thb_field->setLabel( __( 'Title', 'thb_text_domain' ) );
					$thb_modal_container->addField( $thb_field );

					thb_grid_layout_add_fields( $thb_modal_container, $grid_columns );

				$thb_modal_container = $thb_modal->createDuplicableContainer( __('Photos', 'thb_text_domain'), 'photogallery_slides' );
				$thb_modal_container->setSortable();

					$thb_modal_container->addControl( __('Add photo', 'thb_text_domain'), 'add_image', '', array(
						'action' => 'thb_add_multiple_slides',
						'title' => __('Add photos', 'thb_text_domain')
					) );

					$field = new THB_SlideField( 'photogallery_slide' );
					$field->setLabel( __('Slide', 'thb_text_domain') );
					$field->getModal( 'edit_slide_image' )->getContainer( 'edit_slide_image_container' )->removeField( 'class' );

					$thb_modal_container->setField($field);

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
				'masonry'
			);

			return array_merge( $block_classes, parent::blockClasses( $block_data ) );
		}

	}

	thb_builder_instance()->addBlock( new THB_PhotogalleryBlock() );
}