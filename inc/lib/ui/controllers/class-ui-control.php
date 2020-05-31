<?php

abstract class UIControl
{ 
  private $_model;

  public function set_model($model)
  {
    $this->_model = $model;
  }

  protected function get_model()
  {
    return $this->_model;
  }

  public function set_property($key, $value)
  {
    $this->get_model()->set_property($key, $value);
  }

  public abstract function init();

  public function load()
  {
    $this->get_model()->load();
  }

  public function validate($errors)
  {
    return $this->get_model()->validate($errors);
  }

  public function save()
  {
    $this->get_model()->save();
  }

  public function get_value($id)
  {
    return $this->get_model()->get_value($id);
  }

  public function get_title($id)
  {
    return $this->get_model()->get_title($id);
  }

  public function get_description($id)
  {
    return $this->get_model()->get_description($id);
  }

  public function get_choices($id)
  {
    return $this->get_model()->get_choices($id);
  }

  public function is_disabled($id)
  {
    return $this->get_model()->is_disabled($id);
  }
}
