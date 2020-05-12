<?php

class OsmAddress
{
  private $street;
  private $streetnumber;
  private $postcode;
  private $town;
  private $country;
  private $lat;
  private $lon;
  
  function __construct()
  {
    $this->lon = 0;
    $this->lat = 0;
  }

  public function set_streetnumber($streetnumber)
  {
    $sn = trim($streetnumber);
    $index = strpos($sn, ' ');
    if(empty($index))
    {
      $this->streetnumber = $streetnumber;
      return;
    }
    $this->streetnumber = substr($sn, 0, $index);
  }

  public function get_streetnumber()
  {
    return $this->streetnumber;
  }

  public function set_street_and_number($sn)
  {
    $sn = trim($sn);
    $index = strpos($sn, ' ');
    $len = strlen($sn);
    if(empty($index))
    {
      $this->set_street($sn);
      return;
    }
    $this->set_street(substr($sn, 0, $index));
    if($len > $index)
    {
      $this->set_streetnumber(substr($sn, $index, $len));
    }
  }

  public function set_street($street)
  {
    $this->street = trim($street);
  }

  public function get_street()
  {
    return $this->street;
  }

  public function set_postcode($postcode)
  {
    $this->postcode = $postcode;
  }

  public function get_postcode()
  {
    return $this->postcode;
  }

  public function set_town($town)
  {
    $this->town = $town;
  }

  public function get_town()
  {
    return $this->town;
  }

  public function set_country($country)
  {
    $this->country = $country;
  }

  public function get_country()
  {
    return $this->country;
  }

  public function set_lat($lat)
  {
    $this->lat = $lat;
  }

  public function get_lat()
  {
    return $this->lat;
  }

  public function set_lon($lon)
  {
    $this->lon = $lon;
  }

  public function get_lon()
  {
    return $this->lon;
  }
}
