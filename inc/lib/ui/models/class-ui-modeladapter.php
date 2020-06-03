<?php

abstract class UIModelAdapter
{
  private $_value;
  private $_id;
  private $_title;
  private $_description;
  private $_choices = array();
  private $_disabled = false;
  private $_validate = false;

  private $_model;

  public function __construct($id, $title = '')
  {
    $this->_id = $id;
    $this->set_title($title);
  }

  public function get_id()
  {
    return $this->_id;
  }

  public function set_model($model)
  {
    $this->_model = $model;
  }

  public function get_model()
  {
    return $this->_model;
  }

  public function get_property($key)
  {
    return $this->get_model()->get_property($key);
  }

  public function set_title($title)
  {
    $this->_title = $title;
  }

  public function get_title()
  {
    return $this->_title;
  }

  public function set_description($description)
  {
    $this->_description = $description;
  }

  public function get_description()
  {
    return $this->_description;
  }

  public function add_choice($choice)
  {
    array_push( $this->_choices, $choice);
  }

  public function get_choices()
  {
    return $this->_choices;
  }

  public function set_disabled($disabled)
  {
    $this->_disabled = $disabled;
    if($disabled)
    {
      echo ' DISABLED (' . $this->get_id() . ') '. $this->_disabled;
    }
  }

  public function is_disabled()
  {
    //echo ' IS DISABLED (' . $this->get_id() . ') '. $this->_disabled;
    return $this->_disabled;
  }

  public function set_validate($validate)
  {
    $this->_validate = $validate;
  }

  public function is_validate()
  {
    return $this->_validate;
  }

  public function get_value()
  {
    return $this->_value;
  }

  public function set_value($value)
  {
    // If an Item is disabled, we get wrong
    // values, so we make sure that no updates
    // will happen then.
    echo 'SET ('. $this->get_id() . ') VALUE ' . 
      $value . ' DISABLED ' . $this->is_disabled();
    $this->_value = $value;
  }

  public abstract function load_value();

  public function validate_value($errors)
  {
    if(!$this->is_validate())
    {
      return $errors;
    }

    $value = $this->get_value();
    if ( empty( $value )
       || ! empty( $value )
       && trim( $value ) == '' ) 
    {
      $errors->add(
         $this->get_id().'_error',
           'Fehler: ' . $this->get_title() . ' fehlt!!');
    }
    return $errors;
  }

  public abstract function save_value();
}