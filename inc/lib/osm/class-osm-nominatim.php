<?php

class OsmNominatim
{
  const DEFAULT_URL = 'https://nominatim.openstreetmap.org';
  private $client;

  function __construct()
  {
    $this->client = new WordpressHttpClient();
  }

  function fill_location($wpLocation)
  {
    $uri = get_option('osm_nominatim_url', self::DEFAULT_URL);
    $uri .= '/search/';

    $addressUri = '';
    if(empty($wpLocation->get_street()))
    {
      return $wpLocation;
    }

    $addressUri .= $wpLocation->get_street();
    $addressUri .=' ';

    if(!empty($wpLocation->get_streetnumber()))
    {
      $addressUri .= $wpLocation->get_streetnumber();
      $addressUri .=' ';
    }

    if(empty($wpLocation->get_zip()) &&
       empty($wpLocation->get_city()))
    {
      return $wpLocation;
    }
      
    if(!empty($wpLocation->get_zip()))
    {
      $addressUri .= $wpLocation->get_zip();
      $addressUri .=' ';
    }

    if(!empty($wpLocation->get_city()))
    {
      $addressUri .= $wpLocation->get_city();
      $addressUri .=' ';
    }

    if(!empty($wpLocation->get_country_code()))
    {
      $addressUri .= $wpLocation->get_country_code();
      $addressUri .=' ';
    }

    $uri .= trim($addressUri);
    $uri .= '?format=xml&addressdetails=1';

    $request = new SimpleRequest('get', $uri);
    $response = $this->client->send($request);
    if( $response->getStatusCode() !== 200 )
    {
      return $wpLocation;
    }

    $xmlData = $response->getBody();
    if( empty($xmlData))
    {
      return $wpLocation;
    }

    $xml = simplexml_load_string($xmlData);
    if(empty($xml->children()))
    {
      return $wpLocation;
    }

    foreach($xml->children() as $place)
    {
      if(empty($place))
      {
        return $wpLocation;
      }
    
      if(!empty((string)$place->house_number))
      {
        $wpLocation->set_streetnumber((string)$place->house_number);
      }
    
      if(!empty((string)$place->road))
      {
        $wpLocation->set_street((string)$place->road);
      }
    
      if(!empty((string)$place->town))
      {
        $wpLocation->set_city((string)$place->town);
      }
    
      if(!empty((string)$place->postcode))
      {
        $wpLocation->set_zip((string)$place->postcode);
      }
    
      if(!empty((string)$place->country_code))
      {
        $wpLocation->set_country_code((string)$place->country_code);
      }

      foreach($place->Attributes() as $key=>$val)
      {
        if($key == 'lat')
        {
          $wpLocation->set_lat((string)$val);
        }
        if($key == 'lon')
        {
          $wpLocation->set_lon((string)$val);
        }
      }
      return $wpLocation;
    }
    return $wpLocation;
  }
}
