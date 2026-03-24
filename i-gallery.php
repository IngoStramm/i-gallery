<?php

/**
 * Plugin Name: I Gallery
 * Plugin URI: https://agencialaf.com
 * Description: Descrição do I Gallery.
 * Version: 0.0.3
 * Author: Ingo Stramm
 * Text Domain: ig
 * License: GPLv2
 */

defined('ABSPATH') or die('No script kiddies please!');

define('IG_DIR', plugin_dir_path(__FILE__));
define('IG_URL', plugin_dir_url(__FILE__));

require_once 'dependencies.php';
require_once 'classes/classes.php';
require_once 'utilities.php';
require_once 'scripts.php';
require_once 'post-cmb.php';
require_once 'shortcode.php';

require 'plugin-update-checker-4.10/plugin-update-checker.php';
$updateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://raw.githubusercontent.com/IngoStramm/i-gallery/refs/heads/master/info.json',
    __FILE__,
    'i-gallery'
);
