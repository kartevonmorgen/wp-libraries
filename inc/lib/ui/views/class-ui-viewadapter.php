<?php

abstract class UIViewAdapter
{
  private $_id;
  private $_view;
  private $_disabled;

  public function __construct($id)
  {
    $this->_id = $id;
  }

  public function show_label()
  {
?><label for="<?php $this->the_id(); ?>"><?php $this->the_title(); ?></label><?php
  }

  public function show_field()
  {
?><input type="text" class="regular-text" name="<?php $this->the_id(); ?>" id="<?php $this->the_id(); ?>" value="<?php $this->the_value(); ?>" <?php $this->the_disabled(); ?>/><?php
  }

  public function show_description()
  {
?><span class="description"><em><?php $this->the_description(); ?></em></span><?php
  }

  public function show_newline()
  {
?><br><?php
  }

  public function set_view($view)
  {
    $this->_view = $view;
  }

  protected function get_view()
  {
    return $this->_view;
  }

  public function get_id()
  {
    return $this->_id;
  }

  public function the_id()
  {
    echo $this->get_id();
  }

  protected function get_value()
  {
    return $this->get_view()->get_value($this->get_id());
  }

  public function the_value()
  {
    echo $this->get_value();
  }

  protected function get_title()
  {
    return $this->get_view()->get_title($this->get_id());
  }

  public function the_title()
  {
    echo $this->get_title();
  }

  public function has_description()
  {
    return !empty($this->get_description());
  }

  protected function get_description()
  {
    return $this->get_view()->get_description($this->get_id());
  }

  public function the_description()
  {
    echo $this->get_description();
  }

  protected function get_choices()
  {
    return $this->get_view()->get_choices($this->get_id());
  }

  public function set_disabled($disabled)
  {
    $this->_disabled = $disabled;
  }

  protected function is_disabled()
  {
    return $this->_disabled || 
      $this->get_view()->is_disabled($this->get_id());
  }

  protected function the_disabled()
  {
    if( $this->is_disabled())
    {
      ?>disabled="disabled"<?php
    }
  }
}
