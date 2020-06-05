<?php

/**
  * WPLocation
  * 
  * @author     Sjoerd Takken
  * @copyright  No Copyright.
  * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
  */
class WPLocationHelper 
{
  public function __construct() 
  {
  }

  public function fill_by_osm_nominatim($wpLocation)
  {
    $osmN = new OsmNominatim();
    $osmRet = $osmN->fill_location($wpLocation);
  }
    
  public function create_from_free_text_format($locationStr)
  {
    $wpLocation = new WpLocation('');
    //echo 'SET LOCATION: ' . $locationStr;
    $array_location = explode(',', $locationStr);
    
    $is_first = true;
    $after_address = false;
    $after_zip = false;
    $city_done = false;
    foreach($array_location as $element)
    {
      $element = trim($element);
      //echo 'LOC ELEMENT: ' . $element;

      if( $this->is_zip($element))
      {
        //echo 'LOC ELEMENT IS ZIP';
        $this->set_zip( $wpLocation, $element);
        $is_first = false;
        $after_zip = true;
        $after_address = false;
        continue;
      }

      
      if( $this->is_address($element) )
      {
        //echo 'LOC ELEMENT IS ADDRE';
        $this->set_address( $wpLocation, $element);
        $is_first = false;
        $after_zip = false;
        $after_address = true;
        continue;
      }

      // City comes always after address or zip
      if( (! $city_done) && 
          ($after_address || $after_zip) 
          && $this->is_city($element))
      {
        //echo 'LOC ELEMENT IS CITY';
        $this->set_city( $wpLocation, $element);
        $is_first = false;
        $after_zip = false;
        $after_address = false;
        $city_done = true;
        continue;
      }

      if($is_first)
      {
        //echo 'LOC ELEMENT IS NAME';
        $this->set_name( $wpLocation, $element );
        $is_first = false;
      }

      $after_zip = false;
      $after_address = false;
    }

    if(empty($wpLocation->get_name()))
    {
      $this->set_name( $wpLocation, 
                       $this->get_address($wpLocation));
    }
    return $wpLocation;
  }

  public function is_valid($wpLocation)
  {
    if(empty($wpLocation))
    {
      return false;
    }

    if(empty($wpLocation->get_name()))
    {
      return false;
    }

    if(empty($wpLocation->get_street()))
    {
      return false;
    }

    if(empty($wpLocation->get_streetnumber()))
    {
      return false;
    }

    if(empty($wpLocation->get_zip()) && 
       empty($wpLocation->get_city()))
    {
      return false;
    }
    return true;
  }

  public function set_name($wpLocation, $name)
  {
    $wpLocation->set_name($this->cleanup_name($name));
  }

  private function cleanup_name($input)
  {
    //echo 'INPUT NAME' . $input;
    
    $output = $this->cleanup($input,
      '/([0-9A-Za-zäÄöÖüÜß.\s_-]+)/');

    //echo 'OUTPUT NAME' . $output;
    return $output;
  }

  public function set_address($wpLocation, $address)
  {
    if(empty($address))
    {
      $wpLocation->set_street(null);
      $wpLocation->set_streetnumber(null);
      return;
    }
    
    preg_match($this->get_address_pattern(),
               $address, $result);
    if(empty($result))
    {
      $wpLocation->set_street(null);
      $wpLocation->set_streetnumber(null);
      return;
    }

    if(count($result) < 2)
    {
      $wpLocation->set_street($address);
      return;
    }
    $wpLocation->set_street($result[1]);
    $wpLocation->set_streetnumber($result[2]);
  }

  public function get_address($wpLocation) 
  {
    return $wpLocation->get_street() . 
           ' ' . 
           $wpLocation->get_streetnumber();
  }

  private function is_address($input)
  {
    return !empty($this->cleanup_address($input));
  }

  private function get_address_pattern()
  {
    return '/([A-Za-zäÄöÖüÜß.\s_-]+)\s([0-9]+[a-zA-Z]?)/';
  }

  private function cleanup_address($input)
  {
    //echo 'INPUT ADDR' . $input;
    
    $output = $this->cleanup( $input, 
                              $this->get_address_pattern());

    //echo 'OUTPUT ADDR' . $output;
    return $output;
  }

  public function set_street( $wpLocation, $street ) 
  {
    $wpLocation->set_street ($this->cleanup($street));
  }

  public function set_streetnumber( $wpLocation, $sn ) 
  {
    $wpLocation->set_streetnumber(
      $this->cleanup_streetnumber($sn));
  }

  private function cleanup_streetnumber($input)
  {
    //echo 'INPUT SN' . $input;
    
    $output = $this->cleanup($input,
      '/([0-9]+)/');

    //echo 'OUTPUT SN' . $output;
    return $output;
  }

  public function set_zip($wpLocation, $zip)
  {
    $wpLocation->set_zip($this->cleanup_zip($zip));
  }

  private function is_zip($input)
  {
    return !empty($this->cleanup_zip($input));
  }

  private function cleanup_zip($input)
  {
    //echo 'INPUT ZIP' . $input;
    
    $output = $this->cleanup($input,
      '/([0-9]{5})/');

    //echo 'OUTPUT ZIP' . $output;
    return $output;
  }

  private function is_city($input)
  {
    return !empty($this->cleanup($input));
  }

  public function set_city( $wpLocation, $city ) 
  {
    $wpLocation->set_city($this->cleanup($city));
  }

  public function set_state( $wpLocation, $state ) 
  {
    $wpLocation->set_state($this->cleanup($state));
  }

  public function set_country_code( $wpLocation, $cc ) 
  {
    $wpLocation->set_country_code($this->cleanup($cc));
  }


  private function cleanup($input, 
    $pattern = '/([A-Za-zäÄöÖüÜß.\s_-]+)/')
  {
    if(empty($input))
    {
      return null;
    }
    if( preg_match($pattern, $input, $output) )
    {
      return $output[0];
    }
    return null;
  }
}
