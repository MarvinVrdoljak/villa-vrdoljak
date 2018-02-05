<?php

// Use shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

//SHORTCODE display booking calendar from www.bookitme.com
function bookitme_calendar($atts, $content = null) {
    extract(shortcode_atts(array(
                'width' => '',
                'height' => '',
                'url' => '',
                    ), $atts));

//Set default values when not came in from shortcode     
    $lod = get_option('bookitme_options');
    if (!$width)
        $width = $lod['inp_calendar_width'];
    if (!$width)
        $width = $lod['inp_calendar_height'];
    if (!$url)
        $url = $lod['inp_calendar_url'];


    $output['calendar'] = '<iframe src="' . $url . '" width="' . $width . '" height="' . $height . '" frameborder="0" align="baseline" scrolling="no" name="booking-calendar"></iframe>';
    return $output['calendar'];
}

add_shortcode('bookitme-calendar', 'bookitme_calendar');

//SHORTCODE display today timeline from www.bookitme.com

function bookitme_timeline($atts, $content = null) {
    extract(shortcode_atts(array(
                'width' => '',
                'height' => '',
                'url' => '',
                    ), $atts));
//Set default values when not came in from shortcode     
    $lod = get_option('bookitme_options');
    if (!$width)
        $width = $lod['inp_timeline_width'];
    if (!$width)
        $width = $lod['inp_timeline_height'];
    if (!$url)
        $url = $lod['inp_timeline_url'];
    
    $output['timeline'] = '<iframe src="' . $url . '" width="' . $width . '" height="' . $height . '" frameborder="0" align="baseline" scrolling="no" name="booking-timeline"></iframe>';
    return $output['timeline'];
}

add_shortcode('bookitme-timeline', 'bookitme_timeline');
?>