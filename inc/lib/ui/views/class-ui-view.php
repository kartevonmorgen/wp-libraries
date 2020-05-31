<?php

abstract class UIView
{
  private $_viewadapters = array();
  private $_controller;

  public function __construct($controller)
  {
    $this->_controller = $controller;
  }

  public function start()
  {
    $this->init();
    $this->show();
  }

  protected abstract function init();

  protected function show()
  {
  }

  protected function get_control()
  {
    return $this->_controller;
  }

  public function add_va($viewadapter)
  {
    $viewadapter->set_view($this);
    array_push($this->_viewadapters, $viewadapter);
    return $viewadapter;
  }

  public function get_viewadapters()
  {
    return $this->_viewadapters;
  }

  public function get_value($id)
  {
    return $this->get_control()->get_value($id);
  }

  public function get_title($id)
  {
    return $this->get_control()->get_title($id);
  }

  public function get_description($id)
  {
    return $this->get_control()->get_description($id);
  }

  public function get_choices($id)
  {
    return $this->get_control()->get_choices($id);
  }

  public function is_disabled($id)
  {
    return $this->get_control()->is_disabled($id);
  }
}
