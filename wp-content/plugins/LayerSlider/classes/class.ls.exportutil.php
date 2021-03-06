<?php 

/**
 * Class for working with ZIP archives to export
 * sliders with images and other attachments.
 *
 * @package LS_ExportUtil
 * @since 5.0.3
 * @author John Gera
 * @copyright Copyright (c) 2013  John Gera, George Krupa, and Kreatura Media Kft.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 */

class LS_ExportUtil {

	/**
	 * The managed ZipArchieve instance.
	 */
	private $zip;

	/**
	 * A temporary file in /wp-content/uploads/ to manipulate 
	 * ZIPs on the fly without permanently saving to file system.
	 */
	private $file;


	/**
	 * Prepares a ZipArchieve instance and the file system
	 * to work with the class.
	 *
	 * @since 5.0.3
	 * @access public
	 * @return void
	 */
	public function __construct() {

		// Check for ZipArchieve
		if(class_exists('ZipArchive')) {
		
			// Temporary directory for file operations
			$upload_dir = wp_upload_dir();
			$tmp_dir = $upload_dir['basedir'];

			// Prepare ZIP to work with
			$this->file = tempnam($tmp_dir, "zip");
			$this->zip = new ZipArchive;
			$this->zip->open($this->file, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
		}
	}


	/**
	 * Adds slider settings .json file to ZIP
	 *
	 * @since 5.0.3
	 * @access public
	 * @param string $data Slider settings JSON
	 * @return void
	 */
	public function addSettings($data, $folder = '') {
		$folder = !empty($folder) ? $folder.'/' : '';
		$this->zip->addFromString($folder.'settings.json', $data);
	}


	/**
	 * Adds slider images to ZIP
	 *
	 * @since 5.0.3
	 * @access public
	 * @param string $path Image path to add
	 * @return void
	 */
	public function addImage($files, $folder = '') {

		// Check file 
		if(empty($files)) { return false; }

		// Check file type
		if(!is_array($files)) { $files = array($files); }

		// Check folder
		$folder = is_string($folder) ? $folder.'/uploads/' : 'uploads/'; 
	
		// Add contents to ZIP
		foreach($files as $file) {
			if(!empty($file) && is_string($file)) {
				$this->zip->addFile($file, 
					$folder.sanitize_file_name(basename($file))
				);
			}
		}
	}


	/**
	 * Closes all pending operations and downloads the ZIP file.
	 *
	 * @since 5.0.3
	 * @access public
	 * @return void
	 */
	public function download() {

		// Close ZIP operations 
		$this->zip->close();

		// Set headers and to user
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="LayerSlider_Export_'.date('Y-m-d').'_at_'.date('H.i.s').'.zip"');
		header("Content-length: " . filesize($this->file));
		header('Pragma: no-cache');
		header('Expires: 0');
		readfile($this->file);

		// Remove temporary file
		unlink($this->file);
	}


	public function getImagesForSlider($data) {
		
		// Array to hold image URLs
		$images = array();

		// Slider settings
		if(!empty($data['properties']['backgroundimage'])) {
			$images[] = $data['properties']['backgroundimage']; }

		if(!empty($data['properties']['yourlogo'])) {
			$images[] = $data['properties']['yourlogo']; }


		// Slides
		if(!empty($data['layers']) && is_array($data['layers'])) {
		foreach($data['layers'] as $slide) {

				if(!empty($slide['properties']['background'])) {
					$images[] = $slide['properties']['background']; }

				if(!empty($slide['properties']['thumbnail'])) {
					$images[] = $slide['properties']['thumbnail']; }

				// Layers
				if(!empty($slide['sublayers']) && is_array($slide['sublayers'])) {
					foreach($slide['sublayers'] as $layer) {
						
						if(!empty($layer['image'])) {
							$images[] = $layer['image']; }
					}
				}
			}
		}

		return $images;
	}


	public function getFSPaths($urls) {

		if(!empty($urls) && is_array($urls)) {

			$paths = array();
			$root = rtrim(get_home_path(), '/');

			foreach($urls as $url) {
				$path = $root . parse_url($url, PHP_URL_PATH);
				if(file_exists($path)) { 
					$paths[] = $path;
				}
			}

			return $paths;
		}

		return array();
	}
}