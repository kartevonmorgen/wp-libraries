<?php
/*
Plugin Name: WP Libraries (PSR-7 and UI)
Plugin URI: https://wordpress.org/extend/plugins/wphttp2wplib
Description: Makes a wrapper araound the WP_HTTP class which is compatible with the PSR-7 Api. Creates a class based Wrapper around the Wordpress Settings API
Version: 1.0
Author: Sjoerd Takken
Author URI: https://www.sjoerdscomputerwelten.de/
Text Domain: wplib
License: GPL2

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'WPLIB_PLUGINS_URL', plugins_url( '', __FILE__ ) );

// -- Http Wrapper --
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-message-interface.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-response-interface.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-request-interface.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-simple-message.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-simple-response.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-simple-request.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-client-interface.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-wordpress-http-client.php');

// -- UI Tools--
require_once( dirname( __FILE__ ) . '/inc/lib/ui/class-ui-page.php' );
require_once( dirname( __FILE__ ) . '/inc/lib/ui/class-ui-settings-field.php' );
require_once( dirname( __FILE__ ) . '/inc/lib/ui/class-ui-settings-section.php' );
require_once( dirname( __FILE__ ) . '/inc/lib/ui/class-ui-settings-page.php' );

// -- Controllers --
require_once( dirname( __FILE__ ) . '/inc/controllers/class-psr7-admincontrol.php' );

$adminControl = PSR7AdminControl::get_instance();
$adminControl->start();

if ( ! function_exists( 'wplib_load_textdomain' ) ) 
{
  /**
   * Load in any language files that we have setup
   */
  function wplib_load_textdomain() 
  {
    load_plugin_textdomain( 'wplib', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
  }
  add_action( 'plugins_loaded', 'wplib_load_textdomain' );
}
