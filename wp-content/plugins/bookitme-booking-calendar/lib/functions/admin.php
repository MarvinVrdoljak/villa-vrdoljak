<?php

register_activation_hook(__FILE__, 'bookitme_add_defaults');
register_uninstall_hook(__FILE__, 'bookitme_delete_plugin_options');

add_action('admin_init', 'bookitme_init');
add_action('admin_menu', 'bookitme_add_options_page');

// delete options table entries ONLY when plugin deactivated AND deleted
function bookitme_delete_plugin_options() {
    delete_option('bookitme_options');
}

// Define default option settings
function bookitme_add_defaults() {
    $lod = get_option('bookitme_options');
    if (($lod['chk_default_options_db'] == '1') || (!is_array($lod))) {
        delete_option('bookitme_options'); // so we don't have to reset all the 'off' checkboxes too! (don't think this is needed but leave for now)
        $arr = array("inp_frame_width" => "500");
        update_option('bookitme_options', $arr);
    }
}

// Init plugin options
function bookitme_init() {
    // check default values
    $lod = get_option('bookitme_options');

    if (!$lod['inp_calendar_width']) {
        $lod["inp_calendar_width"] = "500";
        update_option('bookitme_options', $lod);
    }
    //set defaul url to calendar demo site from bookitme.com
    if (!$lod['inp_calendar_url']) {
        $lod["inp_calendar_url"] = "http://www.bookitme.com/tms-demo/tms.html";
        update_option('bookitme_options', $lod);
    }

    if (!$lod['inp_timeline_width']) {
        $lod["inp_timeline_width"] = "500";
        update_option('bookitme_options', $lod);
    }
    //set defaul url to timeline demo site from bookitme.com
    if (!$lod['inp_timeline_url']) {
        $lod["inp_timeline_url"] = "http://www.bookitme.com/tms-time/index.php";
        update_option('bookitme_options', $lod);
    }

    register_setting('bookitme_plugin_options', 'bookitme_options', 'bookitme_validate_options');
}

// Add menu page
function bookitme_add_options_page() {
    add_options_page('Bookitme Options Page', 'Bookitme', 'manage_options', __FILE__, 'bookitme_render_form');
}

// Draw the menu page
function bookitme_render_form() {
    ?>
    <div class="wrap">
        <div class="icon32" id="icon-options-general"><br></div>
        <h2>BOOKITME Options</h2>
        <div style="background:#eee;border: 1px dashed #ccc;font-size: 13px;margin-top: 20px;padding: 5px 0 5px 8px;">To display the BOOOKITME booking calendar on a post/page, enter the following <a href="http://codex.wordpress.org/Shortcode_API" target="_blank">shortcode</a>: <b>[bookitme]</b></div>
        <form method="post" action="options.php">
            <?php settings_fields('bookitme_plugin_options'); ?>
            <?php $options = get_option('bookitme_options'); 
            print_r($options);
            ?>
            
            <table class="form-table">
                <tr valign="top">
                <tr><td colspan="2"><div style="margin-top:10px;"><h1>CALENDAR default values:</h1></div></td></tr>
                <th scope="row">Display size <strong>WIDTH :</strong></th>
                <td><input name="bookitme_options[inp_calendar_width]" type="text" value="<?php echo $options['inp_calendar_width'] ?>" /></td>
                <tr><td scope="row">Display size <strong>HEIGHT :</strong></td>
                    <td><input name="bookitme_options[inp_calendar_height]" type="text" value="<?php echo $options['inp_calendar_height'] ?>" /></td></tr>         
                <tr><td scope="row">Calendar <strong>URL :</strong></td>
                    <td><input name="bookitme_options[inp_calendar_url]" type="text" size="150" value="<?php echo $options['inp_calendar_url'] ?>" /></td></tr>                         
                <tr><td colspan="2"><div style="margin-top:10px;"></div></td></tr>
                <tr><td colspan="2"><div style="margin-top:10px;"><h1>TIMELINE default values:</h1></div></td></tr>
                <th scope="row">Display size <strong>WIDTH :</strong></th>
                <td><input name="bookitme_options[inp_timeline_width]" type="text" value="<?php echo $options['inp_timeline_width'] ?>" /></td>
                <tr><td scope="row">Display size <strong>HEIGHT :</strong></td>
                    <td><input name="bookitme_options[inp_timeline_height]" type="text" value="<?php echo $options['inp_timeline_height'] ?>" /></td></tr>         
                <tr><td scope="row">Calendar <strong>URL :</strong></td>
                    <td><input name="bookitme_options[inp_timeline_url]" type="text" size="150" value="<?php echo $options['inp_timeline_url'] ?>" /></td></tr>                         
                <tr><td colspan="2"><div style="margin-top:10px;"></div></td></tr>


                <tr valign="top" style="border-top:#dddddd 1px solid;">
                    <th scope="row">Database Options</th>
                    <td>
                        <label><input name="bookitme_options[chk_default_options_db]" type="checkbox" value="1" <?php checked('1', $options['chk_default_options_db']); ?> /> Restore Plugin defaults upon deactivation/reactivation</label>
                        <br /><span style="color:#666666;margin-left:2px;">Only check this if you want to reset plugin settings upon reactivation</span>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </form>
    </div>
    <?php
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function bookitme_validate_options($input) {
    // strip html from textboxes
    // e.g. $input['textbox'] =  wp_filter_nohtml_kses($input['textbox']);
    return $input;
}
?>
