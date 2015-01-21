<?php

/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/assets/css/main.css
 *
 * Enqueue scripts in the following order:
 * 1. jquery-1.11.1.min.js via Google CDN
 * 2. /theme/assets/js/vendor/modernizr.min.js
 * 3. /theme/assets/js/scripts.js
 *
 * Google Analytics is loaded after enqueued scripts if:
 * - An ID has been defined in config.php
 * - You're not logged in as an administrator
 * 
 * @package tsatu
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function tsatu_homelayout_scripts() {

    if (WP_ENV === 'development') {
        $assets = array(
            'css' => '/assets/css/main.css',
            'js' => '/assets/js/scripts.js',
            'modernizr' => '/assets/vendor/modernizr/modernizr.js',
            'jquery' => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js',
            'customizer' => '/assets/js/customizer.js'
        );
    } else {
        $get_assets = file_get_contents(get_template_directory() . '/assets/manifest.json');
        $assets = json_decode($get_assets, true);
        $assets = array(
            'css' => '/assets/css/main.min.css?' . $assets['assets/css/main.min.css']['hash'],
            'js' => '/assets/js/scripts.min.js?' . $assets['assets/js/scripts.min.js']['hash'],
            'modernizr' => '/assets/js/vendor/modernizr.min.js',
            'jquery' => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js',
            'customizer' => '/assets/js/customizer.min.js'
        );
    }
    
    if (UI_FRAMEWORK != 'Bootstrap') {
        /**
         * The build task in Grunt renames production assets with a hash
         * Read the asset names from assets-manifest.json
         */

        wp_enqueue_style('tsatu_homelayout_style', TSATU_HOMELAYOUT_URL . $assets['css'], false, null);

        /**
         * jQuery is loaded using the same method from HTML5 Boilerplate:
         * Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
         * It's kept in the header instead of footer to avoid conflicts with plugins.
         */
        if (!is_admin() && current_theme_supports('jquery-cdn')) {
            wp_deregister_script('jquery');
            wp_register_script('jquery', $assets['jquery'], array(), null, true);
            add_filter('script_loader_src', 'tsatu_jquery_local_fallback', 10, 2);
        }

        if (is_single() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        wp_enqueue_script('modernizr', TSATU_HOMELAYOUT_URL . $assets['modernizr'], array(), null, true);
        wp_enqueue_script('jquery');
        wp_enqueue_script('tsatu_homelayout_js', TSATU_HOMELAYOUT_URL . $assets['js'], array(), null, true);
    }
    wp_enqueue_script('tsatu_homelayout_customizer', TSATU_HOMELAYOUT_URL . $assets['customizer'], array('jquery', 'customize-preview'), null, true);
}

add_action('wp_enqueue_scripts', 'tsatu_homelayout_scripts', 100);

// http://wordpress.stackexchange.com/a/12450
function tsatu_homelayout_jquery_local_fallback($src, $handle = null) {
    static $add_jquery_fallback = false;

    if ($add_jquery_fallback) {
        echo '<script>window.jQuery || document.write(\'<script src="' . TSATU_HOMELAYOUT_URL . '/assets/vendor/jquery/dist/jquery.min.js?1.11.1"><\/script>\')</script>' . "\n";
        $add_jquery_fallback = false;
    }

    if ($handle === 'jquery') {
        $add_jquery_fallback = true;
    }

    return $src;
}

add_action('wp_head', 'tsatu_homelayout_jquery_local_fallback');
