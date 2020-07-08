<?php

/**
  * WPLocation
  * 
  * @author     Sjoerd Takken
  * @copyright  No Copyright.
  * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
  */
class WPInitiative 
{
  private $_id;
  private $_name;
  private $_kvm_id;
  private $_description;
  private $_email;
  private $_phone;
  private $_website;
	private $_location;
  
  public function __construct() 
  {
  }

	public function set_id( $id ) 
  {
		$this->_id = $id;
	}

	public function get_id() 
  {
		return $this->_id;
	}

	public function set_name( $name ) 
  {
		$this->_name = $name;
	}

	public function get_name() 
  {
		return $this->_name;
	}

	public function set_kvm_id( $kvm_id ) 
  {
		$this->_kvm_id = $kvm_id;
	}

	public function get_kvm_id() 
  {
		return $this->_kvm_id;
	}

  public function set_description( $description ) 
  {
    $this->_description = $description;
  }

  public function get_description() 
  {
    return $this->_description;
  }

	public function set_location( $location ) 
  {
		$this->_location = $location;
	}

	public function get_location() 
  {
		return $this->_location;
	}

  private function add_line($caption, $value)
  {
    return ''. $caption . ': ' . $value . PHP_EOL;
  }
    
  public function to_text()
  {
    $result = '';
    $result .= $this->add_line('id', $this->get_id());
    $result .= $this->add_line('name', $this->get_name());
    $result .= $this->add_line('kvm_id', $this->get_kvm_id());
    $result .= $this->add_line('description', $this->get_description());
    $location = $this->get_location();
    if(!empty ( $location ))
    {
      $result .= $this->add_line('location_name', $location->get_name());
      $result .= $this->add_line('location_street', $location->get_street());
      $result .= $this->add_line('location_streetnumber', $location->get_streetnumber());
      $result .= $this->add_line('location_zip', $location->get_zip());
      $result .= $this->add_line('location_city', $location->get_city());
      $result .= $this->add_line('location_state', $location->get_state());
      $result .= $this->add_line('location_country_code', $location->get_country_code());
      $result .= $this->add_line('location_lon', $location->get_lon());
      $result .= $this->add_line('location_lat', $location->get_lat());
    }
    return $result;
  }

  public function to_string()
  {
    return '' . 
           $this->get_id() .
           ' (' . 
           $this->get_name() . 
           ' ' .
           $this->get_description() .
           ' )';
  }
}
