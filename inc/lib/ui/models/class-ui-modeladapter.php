<?php

abstract class UIModelAdapter
{
  private $_value;
  private $_loadedvalue;
  private $_value_setted;
  private $_value_changed;
  private $_id;
  private $_title;
  private $_description;
  private $_choices = array();
  private $_disabled = false;
  private $_validate = false;
  private $_backgroundcolor = null;

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
  }

  public function is_disabled()
  {
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

  public function set_backgroundcolor($backgroundcolor)
  {
    $this->_backgroundcolor = $backgroundcolor;
  }

  public function get_backgroundcolor()
  {
    return $this->_backgroundcolor;
  }

  public function set_value_setted($value_setted)
  {
    $this->_value_setted = $value_setted;
  }

  public function is_value_setted()
  {
    return $this->_value_setted;
  }

  public function set_value_changed($value_changed)
  {
    $this->_value_changed = $value_changed;
  }

  public function is_value_changed()
  {
    return $this->_value_changed;
  }

  public function get_value()
  {
    if($this->is_value_setted())
    {
      return $this->_value;
    }
    return $this->get_loaded_value();
  }

  public function set_value($value)
  {
    $this->_value = $value;
    $this->set_value_setted(true);
    if($value != $this->get_loaded_value())
    {
      $this->set_value_changed(true);
    }
  }

  public function get_loaded_value()
  {
    return $this->_loadedvalue;
  }

  public function set_loaded_value($value)
  {
    $this->_loadedvalue = $value;
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
