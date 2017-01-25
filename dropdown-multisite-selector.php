<?php
/**
 * Plugin Name:       Dropdown multisite selector
 * Plugin URI:        https://github.com/alordiel/dropdown-multisite
 * Description:       Allows you to configure a select option of redirecting to different webpages.
 * Version:           0.6.4
 * Author:            alordiel
 * Author URI:        http://profiles.wordpress.org/alordiel
 * Text Domain:       dropdown-multisite-selector
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages/
 * GitHub Plugin URI: https://github.com/alordiel/dropdown-multisite
 */

/*  Copyright 2014-2016 Alexander Vasilev  (email : alexander.vasilev@protonmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'WPINC' ) ) {
		die;
}

define( 'DMS_PLUGINS_DIR_ABS', dirname(  __FILE__  ) );
define( 'DMS_PLUGINS_DIR_REL', plugins_url( basename(dirname(  __FILE__  ))  ) );

include_once (DMS_PLUGINS_DIR_ABS . platformSlashes("/functions/wordpress.php"));
include_once (DMS_PLUGINS_DIR_ABS . platformSlashes("/functions/functions.php"));
include_once (DMS_PLUGINS_DIR_ABS . platformSlashes("/functions/ajax.php"));
include_once (DMS_PLUGINS_DIR_ABS . platformSlashes("/functions/widgets.php"));
include_once (DMS_PLUGINS_DIR_ABS . platformSlashes("/functions/shortcodes.php"));


// On install check if dms_mutisite option exists, if not - this is updating from 0.1 so create it with option 'none'
register_activation_hook( __FILE__, 'dms_plugin_activated' );
function dms_plugin_activated() {
	if(!get_option('dms_multisite')){
    	update_option('dms_multisite', 'none');
	}
	if(!get_option('dms_sorting')){
    	update_option('dms_sorting', 'none');
	}
	if(!get_option('dms_placeholder')){
    	update_option('dms_placeholder', 'Select Option');
	}
}

// On install check if dms_placeholder option exists, if not - this is updating from 0.33 so create it with option 'none'
add_action( 'plugins_loaded', 'dms_plugin_updated' );
function dms_plugin_updated() {
	if(!get_option('dms_multisite')){
    	update_option('dms_multisite', 'none');
	}
	if(!get_option('dms_sorting')){
    	update_option('dms_sorting', 'none');
	}
	if(!get_option('dms_placeholder')){
	   	update_option('dms_placeholder', 'Select Option');
	}
}

function platformSlashes($path) {
    return str_replace('/', DIRECTORY_SEPARATOR, $path);
}