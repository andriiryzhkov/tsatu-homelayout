<?php
/**
 * Plugin Name: TSATU Homelayout
 * Plugin URI:  https://github.com/andriiryzhkov/tsatu_homelayout/
 * Description: Customizable widgetized areas for the front page.
 * Version:     0.1.0
 * Author:      Andrii Ryzhkov
 * Author URI:  https://github.com/andriiryzhkov
 * License:     GPLv2+
 * Text Domain: tsatu-homelayout
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2015 Andrii Ryzhkov (email : andrii.ryzhkov@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// Useful global constants
define( 'TSATU_HOMELAYOUT_VERSION', '0.1.0' );
define( 'TSATU_HOMELAYOUT_URL',     plugin_dir_url( __FILE__ ) );
define( 'TSATU_HOMELAYOUT_PATH',    dirname( __FILE__ ) . '/' );

/**
 * Default initialization for the plugin:
 * - Registers the default textdomain.
 */
function tsatu_homelayout_init() {
	//$locale = apply_filters( 'plugin_locale', get_locale(), 'tsatu-homelayout' );
	//load_textdomain( 'tsatu-homelayout', WP_LANG_DIR . '/tsatu-homelayout/tsatu-homelayout-' . $locale . '.mo' );
	load_plugin_textdomain( 'tsatu-homelayout', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'tsatu_homelayout_init');

/**
 * Activate the plugin
 */
function tsatu_homelayout_activate() {
	// First load the init scripts in case any rewrite functionality is being loaded
	//tsatu_homelayout_init();
        
        //Add widget areas initial values
        for ($wa = 1; $wa <= 5; $wa++) {
            add_option('tsatu_columns_' . $wa, 1);
            for ($cl = 1; $cl <= 6; $cl++) {
                add_option('tsatu_home_area_' . $wa . '_' . $cl, 5);
            }
        }

	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'tsatu_homelayout_activate' );

/**
 * Deactivate the plugin
 * Uninstall routines should be in uninstall.php
 */
function tsatu_homelayout_deactivate() {

}
register_deactivation_hook( __FILE__, 'tsatu_homelayout_deactivate' );

// Wireup actions
add_action( 'init', 'tsatu_homelayout_init' );

/**
 * Load home layout builder.
 */
require TSATU_HOMELAYOUT_PATH . '/includes/scripts.php';
require TSATU_HOMELAYOUT_PATH . '/includes/customizer.php';
require TSATU_HOMELAYOUT_PATH . '/includes/sidebar.php';
require TSATU_HOMELAYOUT_PATH . '/includes/homelayout.php';
