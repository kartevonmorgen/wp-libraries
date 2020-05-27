<?php

/**
 * Controller PSR7AdminControl
 * Settings page of the PSR7 Wrapper around WP_Http.
 *
 * @author   Sjoerd Takken
 * @copyright  No Copyright.
 * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
 */
class PSR7AdminControl 
{
  private static $instance = null;

  private function __construct() 
  {
  }

  /** 
   * The object is created from within the class itself
   * only if the class has no instance.
   */
  public static function get_instance()
  {
    if (self::$instance == null)
    {
      self::$instance = new PSR7AdminControl();
    }
    return self::$instance;
  }

  public function start() 
  {
    $page = new UISettingsPage('psr7-options', 
                               'WP Libraries');
    $section = $page->add_section('wplib_section_one', 'Settings');
    $section->set_description(
      'give up an url and test with psr7 wrapper around WP_Http ');

    $field = $section->add_textfield('osm_nominatim_url', 
                            'OSM Nominatim URL');
    $field->set_defaultvalue(OsmNominatim::DEFAULT_URL);
    $field->set_description('This URL ist used to fill the coordinates of a location, by getting this information over the Open Street Map Nominatim API');

    $section->add_textfield('wplib_uri', 
                            'Test URL');

    $field = new class('wplib_result', 
                       'Output from Test URL') extends UISettingsTextAreaField
    {
      public function get_value()
      {
        $instance = PSR7AdminControl::get_instance();
        return $instance->testRequest();
      }
    };
    $field->set_register(false);
    $section->add_field($field);

    $page->register();
  }

  public function testRequest()
  {
    $uri = get_option('wplib_uri', 'haha');
    if(empty($uri))
    {
      return 'No URI found';
    }

    $req = new SimpleRequest('get', $uri);
    $client = new WordpressHttpClient();
    $resp = $client->send($req);

    $result = '';
    $result .= $resp->getStatusCode();
    $result .= ' ';
    $result .= $resp->getReasonPhrase();
    $result .= '' . PHP_EOL;
    $result .= 'HEADERS: '. PHP_EOL;
    foreach($resp->getHeaders() as $key => $value)
    {
      $result .= '  [' . $key . ']: '.$value . PHP_EOL;
    }
    $result .= 'BODY: '. PHP_EOL;
    $result .= $resp->getBody();
    return $result;
  }
}
