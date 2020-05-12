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

    $section->add_textfield('osm_nominatim_url', 
                            'Open Street Map Nominatim URL');

    $section->add_textfield('wplib_uri', 
                            'URL');

    $field = new class('wplib_result', 
                       'Output from URL') extends UISettingsTextAreaField
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
    foreach($resp->getHeaders() as $key => $header)
    {
      $result .= '  [' . $key . ']: '.$header . PHP_EOL;
      if(is_array($header))
      {
        foreach($header as $subkey => $subheader)
        {
          $result .= '    [' . $subkey . ']: '.$subheader . PHP_EOL;
        }
      }
    }
    $result .= 'BODY: '. PHP_EOL;
    $result .= $resp->getBody();
    return $result;
  }
}
