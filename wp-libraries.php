<?php
/*
Plugin Name: WP Libraries (PSR-7 and UI)
Plugin URI: https://github.com/kartevonmorgen/wp-libraries
Description: Makes a wrapper araound the WP_HTTP class which is compatible with the PSR-7 Api. Creates a class based Wrapper around the Wordpress Settings API
Version: 1.0
Author: Sjoerd Takken
Author URI: https://www.sjoerdscomputerwelten.de/
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

defined('ABSPATH') or die('No script kiddies please!');

include_once( dirname( __FILE__ ) . '/inc/lib/plugin/class-wp-pluginloader.php');

class WPLibrariesPluginLoader extends WPPluginLoader
{
  public function init()
  {
    // PHPUtil
    $this->add_include('/inc/lib/util/class-phpstringutil.php');

    // ICalendar
    $this->add_include('/inc/lib/icalendar/class-icallogger.php');
    $this->add_include('/inc/lib/icalendar/class-icaldatehelper.php');
    $this->add_include('/inc/lib/icalendar/class-icalveventdate.php');
    $this->add_include('/inc/lib/icalendar/class-icalveventorganizer.php');
    $this->add_include('/inc/lib/icalendar/class-icalveventtext.php');
    $this->add_include('/inc/lib/icalendar/class-icalveventrecurringdate.php');
    $this->add_include('/inc/lib/icalendar/class-icalvevent.php');
    $this->add_include('/inc/lib/icalendar/class-icalvcalendar.php');

    // Add txt to Image
    $this->add_include('/inc/lib/img/tti-text-util.php');
    $this->add_include('/inc/lib/img/max_media_upload.php');
    $this->add_include('/inc/lib/log/class-logresult.php');
    $this->add_include('/inc/lib/log/class-abstractlogger.php');
    $this->add_include('/inc/lib/log/class-postmetalogger.php');
    $this->add_include('/inc/lib/log/class-usermetalogger.php');

    // -- Http Wrapper --
    $this->add_include('/inc/lib/http/class-message-interface.php');
    $this->add_include('/inc/lib/http/class-response-interface.php');
    $this->add_include('/inc/lib/http/class-request-interface.php');
    $this->add_include('/inc/lib/http/class-simple-message.php');
    $this->add_include('/inc/lib/http/class-simple-response.php');
    $this->add_include('/inc/lib/http/class-simple-request.php');
    $this->add_include('/inc/lib/http/class-client-interface.php');
    $this->add_include('/inc/lib/http/class-wordpress-http-client.php');

    // -- WP Helper Classes --
    $this->add_include('/inc/lib/wp/class-wpinitiative.php' );
    $this->add_include('/inc/lib/wp/class-wplocation.php' );
    $this->add_include('/inc/lib/wp/class-wplocationhelper.php' );
    $this->add_include('/inc/lib/wp/class-wpcategory.php' );
    $this->add_include('/inc/lib/wp/class-wptag.php' );

    // -- OpenStreetMap Nominatim --
    $this->add_include('/inc/lib/osm/class-osm-nominatim.php' );
    $this->add_include('/inc/lib/osm/class-osm-nominatim-cache.php' );

    // -- UI Tools Metabox --
    $this->add_include('/inc/lib/ui/class-ui-metabox-field.php' );
    $this->add_include('/inc/lib/ui/class-ui-metabox.php' );


    // -- UI Tools Settings --
    $this->add_include('/inc/lib/ui/class-ui-page.php' );
    $this->add_include('/inc/lib/ui/class-ui-settings-field.php' );
    $this->add_include('/inc/lib/ui/class-ui-settings-section.php' );
    $this->add_include('/inc/lib/ui/class-ui-settings-page.php' );

    // -- UI MVC Tools
    $this->add_include('/inc/lib/ui/models/class-ui-choice.php');
    $this->add_include('/inc/lib/ui/models/class-ui-modeladapter.php');
    $this->add_include('/inc/lib/ui/models/class-ui-usermeta_modeladapter.php');
    $this->add_include('/inc/lib/ui/models/class-ui-model.php');
    $this->add_include('/inc/lib/ui/views/class-ui-viewadapter.php');
    $this->add_include('/inc/lib/ui/views/class-ui-va-textfield.php');
    $this->add_include('/inc/lib/ui/views/class-ui-va-textarea.php');
    $this->add_include('/inc/lib/ui/views/class-ui-va-checkbox.php');
    $this->add_include('/inc/lib/ui/views/class-ui-va-combobox.php');
    $this->add_include('/inc/lib/ui/views/class-ui-view.php');
    $this->add_include('/inc/lib/ui/controllers/class-ui-control.php');


    // -- Controllers --
    $this->add_include('/inc/controllers/class-psr7-admincontrol.php' );
  }

  public function start()
  {
    $this->add_starter( PSR7AdminControl::get_instance());
  }
}

$loader = new WPLibrariesPluginLoader();
$loader->register( __FILE__ , 10);



