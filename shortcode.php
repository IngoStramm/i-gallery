<?php

function ig_show_gallery($atts)
{
    $a = shortcode_atts(array(
        'id' => get_the_ID(),
    ), $atts);
    return '<div id="i-gallery" class="i-gallery" data-id="' . esc_attr($a['id']) . '"></div>';
}
add_shortcode('i-gallery', 'ig_show_gallery');
