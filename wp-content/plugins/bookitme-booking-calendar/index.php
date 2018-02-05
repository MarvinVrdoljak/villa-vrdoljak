<?php
/**
 * Plugin Name: Bookitme Functionality
 * Plugin URI: http://www.bookitme.com/plugin/
 * Description: Easy interface to include shortcode for display booking calendar and timeline from bookitme.com
 * Version: 1.0.3
 * Author: Anthony Gate
 * Author URI: http://www.bookitme.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */
// Plugin Directory 
define('BOOKITME_DIR', dirname(__FILE__));

register_activation_hook(__FILE__,'register_project_template');
register_deactivation_hook(__FILE__,'deregister_project_template');

function register_project_template() {
    $template_destination =get_template_destination();
    $template_source = get_template_source();
    copy_page_template($template_source, $template_destination);
}

function deregister_project_template() {
    $theme_dir = get_template_directory();
    $template_path = $theme_dir . '/page-bookitme.php';
    if (file_exists($template_path)) {
        unlink($template_path);
    }
}

function get_template_destination() {
    return get_template_directory() . '/page-bookitme.php';
}

function get_template_source() {
    return dirname(__FILE__) . '/lib/templates/page-bookitme.php';
}

function copy_page_template($template_source, $template_destination) {
    if (!file_exists($template_destination)) {
        touch($template_destination);
        if (null != ( $template_handle = @fopen($template_source, 'r') )) {
            if (null != ( $template_content = fread($template_handle, filesize($template_source)) )) {
                fclose($template_handle);
            }
        }
        if (null != ( $template_handle = @fopen($template_destination, 'r+') )) {
            if (null != fwrite($template_handle, $template_content, strlen($template_content))) {
                fclose($template_handle);
            }
        }
    }
}

//Admin Option
include_once( BOOKITME_DIR . '/lib/functions/admin1.php' );
// Shortcodes
include_once( BOOKITME_DIR . '/lib/functions/shortcodes.php' );
?>
