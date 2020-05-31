<?php

abstract class UIModel
{
  public const USER_ID = 'USER_ID';

  private $_modeladapters = array();
  private $_properties = array();

  public function __construct()
  {
  }

  public abstract function init();

  public function add_ma($modeladapter)
  {
    $modeladapter->set_model($this);
    array_push($this->_modeladapters, $modeladapter);
    return $modeladapter;
  }

  public function get_modeladapters()
  {
    return $this->_modeladapters;
  }

  public function get_modeladapter($id)
  {
    foreach($this->get_modeladapters() as $ma)
    {
      if( $ma->get_id() == $id )
      {
        return $ma;
      }
    }
    return null;
  }


  public function load()
  {
    $this->load_model();

    foreach($this->get_modeladapters() as $modeladapter)
    {
      $modeladapter->load_value();
    }
  }

  protected function load_model()
  {
  }

  /**
   * Update Model with View values
   */
  protected function update()
  {
    foreach($this->get_modeladapters() as $ma)
    {
      if ( empty( $_POST[$ma->get_id()] ) )
      {
        continue;
      }
      $ma->set_value( $_POST[$ma->get_id()] );
    }

    $this->update_model();
  }

  protected function update_model()
  {
  }

  /**
   * @param $errors WP_Error: 
   * ModelAdapter can add an error
   * on WP_Error
   */
  public function validate($errors)
  {
    $this->update();

    foreach($this->get_modeladapters() as $ma)
    {
      if($ma->is_validate())
      {
        $errors = $ma->validate_value($errors);
      }
    }
    return $this->validate_model($errors);
  }

  protected function validate_model($errors)
  {
    return $errors;
  }

  public function save()
  {
    $this->update();

    foreach($this->get_modeladapters() as $ma)
    {
      $ma->save_value();
//      $ma->set_value('haha');
    }

    $this->save_model();
  }

  protected function save_model()
  {
  }

  public function set_property($key, $value)
  {
    $this->_properties[$key] = $value;
  }

  public function get_property($key)
  {
    return $this->_properties[$key];
  }
  
  public function get_value($id)
  {
    $ma = $this->get_modeladapter($id);
    if(empty($ma))
    {
      return null;
    }
    return $ma->get_value();
  }

  public function get_title($id)
  {
    $ma = $this->get_modeladapter($id);
    if(empty($ma))
    {
      return null;
    }
    return $ma->get_title();
  }

  public function get_description($id)
  {
    $ma = $this->get_modeladapter($id);
    if(empty($ma))
    {
      return null;
    }
    return $ma->get_description();
  }

  public function get_choices($id)
  {
    $ma = $this->get_modeladapter($id);
    if(empty($ma))
    {
      return array();
    }
    return $ma->get_choices();
  }

  public function is_disabled($id)
  {
    $ma = $this->get_modeladapter($id);
    if(empty($ma))
    {
      return array();
    }
    return $ma->is_disabled();
  }
}

