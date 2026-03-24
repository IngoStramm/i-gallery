<?php

add_action('wp_enqueue_scripts', 'ig_frontend_scripts');

function ig_frontend_scripts()
{

    $min = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', '10.0.0.3'))) ? '' : '.min';
    $version = ig_version();

    if (empty($min)) :
        wp_enqueue_script('i-gallery-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true);
    endif;

    wp_register_script('i-gallery-script', IG_URL . '/assets/js/i-gallery' . $min . '.js', array('jquery'), $version, true);

    wp_enqueue_script('i-gallery-script');

    wp_localize_script(
        'i-gallery-script',
        'ajax_object',
        array(
            'ajax_url'                          => admin_url('admin-ajax.php'),
            'plugin_url'                        => IG_URL,
        )
    );

    wp_enqueue_style('i-gallery-style', IG_URL . '/assets/css/i-gallery.css', array(), $version, 'all');
}

add_action('admin_enqueue_scripts', 'ig_admin_scripts');

function ig_admin_scripts()
{
    if (!is_user_logged_in())
        return;

    $version = ig_version();

    $min = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', '10.0.0.3'))) ? '' : '.min';

    wp_register_script('i-gallery-admin-script', IG_URL . '/assets/js/i-gallery-admin' . $min . '.js', array('jquery'), $version, array('strategy' => 'defer', 'in_footer' => true));

    wp_enqueue_script('i-gallery-admin-script');

    wp_localize_script('i-gallery-admin-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
