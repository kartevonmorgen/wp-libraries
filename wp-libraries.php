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

// -- Convert text to Image
require_once( dirname( __FILE__ ) . '/inc/lib/img/tti-text-util.php');
require_once( dirname( __FILE__ ) . '/inc/lib/img/max_media_upload.php');

require_once( dirname( __FILE__ ) . '/inc/lib/log/class-logresult.php');
require_once( dirname( __FILE__ ) . '/inc/lib/log/class-abstractlogger.php');
require_once( dirname( __FILE__ ) . '/inc/lib/log/class-postmetalogger.php');
require_once( dirname( __FILE__ ) . '/inc/lib/log/class-usermetalogger.php');

// -- Http Wrapper --
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-message-interface.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-response-interface.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-request-interface.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-simple-message.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-simple-response.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-simple-request.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-client-interface.php');
require_once( dirname( __FILE__ ) . '/inc/lib/http/class-wordpress-http-client.php');

// -- WP Helper Classes --
require_once( dirname( __FILE__ ) . '/inc/lib/wp/class-wpinitiative.php' );
require_once( dirname( __FILE__ ) . '/inc/lib/wp/class-wplocation.php' );
require_once( dirname( __FILE__ ) . '/inc/lib/wp/class-wplocationhelper.php' );
require_once( dirname( __FILE__ ) . '/inc/lib/wp/class-wpcategory.php' );
require_once( dirname( __FILE__ ) . '/inc/lib/wp/class-wptag.php' );

// -- OpenStreetMap Nominatim --
require_once( dirname( __FILE__ ) . '/inc/lib/osm/class-osm-nominatim.php' );

// -- UI Tools Metabox --
require_once( dirname( __FILE__ ) . '/inc/lib/ui/class-ui-metabox-field.php' );
require_once( dirname( __FILE__ ) . '/inc/lib/ui/class-ui-metabox.php' );


// -- UI Tools Settings --
require_once( dirname( __FILE__ ) . '/inc/lib/ui/class-ui-page.php' );
require_once( dirname( __FILE__ ) . '/inc/lib/ui/class-ui-settings-field.php' );
require_once( dirname( __FILE__ ) . '/inc/lib/ui/class-ui-settings-section.php' );
require_once( dirname( __FILE__ ) . '/inc/lib/ui/class-ui-settings-page.php' );

// -- UI MVC Tools
require_once( dirname( __FILE__ ) . '/inc/lib/ui/models/class-ui-choice.php');
require_once( dirname( __FILE__ ) . '/inc/lib/ui/models/class-ui-modeladapter.php');
require_once( dirname( __FILE__ ) . '/inc/lib/ui/models/class-ui-usermeta_modeladapter.php');
require_once( dirname( __FILE__ ) . '/inc/lib/ui/models/class-ui-model.php');
require_once( dirname( __FILE__ ) . '/inc/lib/ui/views/class-ui-viewadapter.php');
require_once( dirname( __FILE__ ) . '/inc/lib/ui/views/class-ui-va-textfield.php');
require_once( dirname( __FILE__ ) . '/inc/lib/ui/views/class-ui-va-textarea.php');
require_once( dirname( __FILE__ ) . '/inc/lib/ui/views/class-ui-va-checkbox.php');
require_once( dirname( __FILE__ ) . '/inc/lib/ui/views/class-ui-va-combobox.php');
require_once( dirname( __FILE__ ) . '/inc/lib/ui/views/class-ui-view.php');
require_once( dirname( __FILE__ ) . '/inc/lib/ui/controllers/class-ui-control.php');


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
