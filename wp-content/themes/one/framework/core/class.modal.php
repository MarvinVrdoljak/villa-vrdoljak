<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

/**
 * Modal class.
 *
 * This class is entitled to manage a modal.
 *
 * ---
 *
 * The Happy Framework: WordPress Development Framework
 * Copyright 2014, Andrea Gandino & Simone Maranzana
 *
 * Licensed under The MIT License
 * Redistribuitions of files must retain the above copyright notice.
 *
 * @package Core
 * @author The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright 2014, Andrea Gandino & Simone Maranzana
 * @link http://
 * @since The Happy Framework v 2.0.2
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if( ! class_exists( 'THB_Modal' ) ) {
	class THB_Modal {

		/**
		 * The modal containers.
		 *
		 * @var array
		 */
		protected $_containers = null;

		/**
		 * The modal template.
		 *
		 * @var string
		 */
		protected $_template = 'admin/modal';

		/**
		 * True if the modal has a footer displayed.
		 *
		 * @var boolean
		 */
		protected $_footer = true;

		/**
		 * Constructor
		 *
		 * @param string $title The modal title.
		 * @param string $slug The modal slug.
		 **/
		public function __construct( $title, $slug )
		{
			if( empty($title) ) {
				wp_die( 'Empty modal fields container title.' );
			}

			if( empty($slug) ) {
				wp_die( 'Empty modal fields container slug.' );
			}

			$this->_title = $title;
			$this->_slug = $slug;
			$this->_containers = new THB_List();
		}

		/**
		 * Get the modal slug.
		 *
		 * @return string
		 */
		public function getSlug()
		{
			return $this->_slug;
		}

		/**
		 * Get the modal title.
		 *
		 * @return string
		 */
		public function getTitle()
		{
			return $this->_title;
		}

		/**
		 * Add a container to the modal.
		 *
		 * @param mixed $container The container about to be inserted.
		 * @param integer $index The insertion index.
		 * @return THB_ModalFieldsContainer
		 */
		public function addContainer( $container, $index = false )
		{
			if( $index === false ) {
				$this->_containers->insert( $container );
			}
			else {
				$this->_containers->insertAt( $container, $index );
			}

			return $container;
		}

		/**
		 * Create a new modal fields container.
		 *
		 * @param string $title The modal fields container title.
		 * @param string $slug The modal fields container slug.
		 * @param int $index The insertion index.
		 * @return THB_ModalFieldsContainer
		 */
		public function createContainer( $title, $slug, $index=false )
		{
			$container = new THB_ModalFieldsContainer( $title, $slug );
			$this->addContainer( $container, $index );

			return $container;
		}

		/**
		 * Create a new duplicable modal fields container.
		 *
		 * @param string $title The modal fields container title.
		 * @param string $slug The modal fields container slug.
		 * @param int $index The insertion index.
		 * @return THB_ModalDuplicableFieldsContainer
		 */
		public function createDuplicableContainer( $title, $slug, $index=false )
		{
			$container = new THB_ModalDuplicableFieldsContainer( $title, $slug );
			$this->addContainer( $container, $index );

			return $container;
		}

		/**
		 * Get a modal fields container by its slug.
		 *
		 * @return THB_ModalFieldsContainer
		 */
		public function getContainer( $slug )
		{
			foreach( $this->_containers as $container ) {
				if( $container->getSlug() == $slug ) {
					return $container;
				}
			}

			return false;
		}

		/**
		 * Get the modal fields containers.
		 *
		 * @return array
		 */
		public function getContainers()
		{
			return $this->_containers;
		}

		/**
		 * Hide the modal footer.
		 */
		public function hideFooter()
		{
			return $this->_footer = false;
		}

		/**
		 * Check if the modal footer is hidden.
		 *
		 * @return boolean
		 */
		public function footerHidden()
		{
			return $this->_footer;
		}

		/**
		 * Render the modal.
		 */
		public function render()
		{
			if( $this->getContainers()->size() == 0 ) {
				return;
			}

			$modal_template = new THB_Template( THB_TEMPLATES_DIR . '/' . $this->_template, array(
				'modal' => $this
			) );

			$modal_template->render();
		}

		/**
		 * Serialize the modal keys.
		 *
		 * @return array
		 */
		public function serializeKeys()
		{
			$keys = array();

			foreach ( $this->getContainers() as $container ) {
				$keys = array_merge( $keys, $container->serializeKeys() );
			}

			return $keys;
		}

	}
}