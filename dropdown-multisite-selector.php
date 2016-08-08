<?php
/**
 *
 * Plugin Name:       Dropdown multisite selector
 * Plugin URI:        https://github.com/alordiel/dropdown-multisite
 * Description:       Allows you to configure a select option of redirecting to different webpages.
 * Version:           0.5.0
 * Author:            alordiel
 * Author URI:        http://profiles.wordpress.org/alordiel
 * Text Domain:       dropdown-multisite-selector
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages/
 * GitHub Plugin URI: https://github.com/alordiel/dropdown-multisite
 */

/*  Copyright 2015  Alexander Vasilev  (email : alexander.dorn@gmail.com)

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

define ( 'DMS_VERSION', '0.5.0');
define ( 'PLUGINS_PATH', ABSPATH . 'wp-content/plugins/dropdown-multisite-selector/');

if ( ! defined( 'WPINC' ) ) {
		die;
}

//check if multisite
if ( !is_multisite() ) {
	add_action( 'admin_notices', 'not_a_multisite' );
} else {
	include_once( PLUGINS_PATH . 'controllers/init.php');
}

function not_a_multisite() {
    ?>
    <div class="error">
        <p><?php printf(__( 'Your web site is not a multisite! <a href="%s">Here is how</a> you can make one.', 'dropdown-multisite-selector' ),'http://codex.wordpress.org/Create_A_Networkss'); ?></p>
    </div>
    <?php
}
