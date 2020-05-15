<?php

class OsmNominatim
{
  const DEFAULT_URL = 'https://nominatim.openstreetmap.org';
  private $client;

  function __construct()
  {
    $this->client = new WordpressHttpClient();
  }

  function find_by_address($osmAddress)
  {
    $uri = get_option('osm_nominatim_url', self::DEFAULT_URL);
    $uri .= '/search/';

    $addressUri = '';
    if(!empty($osmAddress->get_street()))
    {
      $addressUri .= $osmAddress->get_street();
      $addressUri .=' ';
    }
    if(!empty($osmAddress->get_streetnumber()))
    {
      $addressUri .= $osmAddress->get_streetnumber();
      $addressUri .=' ';
    }
    if(!empty($osmAddress->get_postcode()))
    {
      $addressUri .= $osmAddress->get_postcode();
      $addressUri .=' ';
    }
    if(!empty($osmAddress->get_town()))
    {
      $addressUri .= $osmAddress->get_town();
      $addressUri .=' ';
    }
    if(!empty($osmAddress->get_country_code()))
    {
      $addressUri .= $osmAddress->get_country_code();
      $addressUri .=' ';
    }

    if(empty($addressUri))
    {
      return $osmAddress;
    }

    $uri .= trim($addressUri);
    $uri .= '?format=xml&addressdetails=1';

    $request = new SimpleRequest('get', $uri);
    $response = $this->client->send($request);
    if( $response->getStatusCode() !== 200 )
    {
      return $osmAddress;
    }

    $xmlData = $response->getBody();
    if( empty($xmlData))
    {
      return $osmAddress;
    }

    $xml = simplexml_load_string($xmlData);
    foreach($xml->children() as $place) 
    {
      $oa = new OsmAddress();
      $oa->set_streetnumber((string)$place->house_number);
      $oa->set_street((string)$place->road);
      $oa->set_town((string)$place->town);
      $oa->set_postcode((string)$place->postcode);
      $oa->set_country_code((string)$place->country_code);
      foreach($place->Attributes() as $key=>$val)
      {
        if($key == 'lat')
        {
          $oa->set_lat((string)$val);
        }
        if($key == 'lon')
        {
          $oa->set_lon((string)$val);
        }
      }
      return $oa;
    }
    return $osmAddress;
  }
}
