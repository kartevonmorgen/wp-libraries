<?php

/** 
 * WPPluginLoader
 * This Class is used to load a Plugin on the right moment
 *
 * @author   Sjoerd Takken
 * @copyright  No Copyright.
 * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class WPPluginLoader
{
  private $_includes = array();
  private $_dependencies = array();
  private $_starters = array();
  private $_plugin;

  public function register( $plugin, $priority = 10)
  {
    $this->_plugin = $plugin;

    add_action( 'init', 
                array($this, 'do_start'), 
                $priority );
    register_activation_hook($plugin, 
                            array($this, 'activate'));
  }

  public function get_plugin_dir()
  {
    return plugin_dir_path($this->get_plugin());
  }

  public function get_plugin()
  {
    return $this->_plugin;
  }

  public function add_include($include)
  {
    array_push($this->_includes, $include);
  }

  public function get_includes()
  {
    return $this->_includes;
  }

  public function add_dependency($dependency)
  {
    array_push($this->_dependencies, $dependency);
  }

  public function get_dependencies()
  {
    return $this->_dependencies;
  }

  public function add_starter($starter)
  {
    array_push($this->_starters, $starter);
  }

  public function get_starters()
  {
    return $this->_starters;
  }

  public function are_dependencies_loaded()
  {
    foreach($this->get_dependencies() as $dep)
    {
      if( !$this->check_dependency($dep, false) )
      {
        return false;
      }
    }
    return true;
  }

  public function are_dependencies_active()
  {
    foreach($this->get_dependencies() as $dep)
    {
      if( !$this->check_dependency($dep, true) )
      {
        return false;
      }
    }
    return true;
  }

  public function get_dependencies_info()
  {
    $result = '';
    foreach($this->get_dependencies() as $dep)
    {
      if(!empty($result))
      {
        $result .= ', ';
      }
      $pos = strpos($dep, '/');
      $result .= substr($dep, 0 , $pos);
    }
    return $result;
  }

  public function check_dependency($dependency, 
                                   $should_be_active = false)
  {
    $plugins = get_plugins();
    foreach($plugins as $key => $plugin_data)
    {
      if($key == $dependency)
      {
        if(! $should_be_active )
        {
          return true;
        }
        else
        {
          if( is_plugin_active( $dependency ))
          {
            return true;
          }
        }
      }
    }
    return false;
  }

  public function do_start()
  {
    $this->init();
    if( $this->are_dependencies_loaded() )
    {
      $this->load_includes();
      if( $this->are_dependencies_active() )
      {
        $this->start();
        $this->execute_starters();
      }
    }
  }

  private function load_includes()
  {
    foreach($this->get_includes() as $include)
    {
      include_once($this->get_plugin_dir() . $include);
    }
  }
  
  private function execute_starters()
  {
    foreach($this->get_starters() as $starter)
    {
      $starter->start();
    }
  }

  public function activate()
  {
    $this->do_start();
    if(!$this->are_dependencies_active())
    {
      echo 'Abhängige Plugins ( ' .
        $this->get_dependencies_info() .
        ' ) sind nicht aktiviert';
      exit;
    }
  }

  /**
   * Used to add includes over add_include( .. ) and 
   * add dependencies over add_dependency( .. ).
   */
  public abstract function init();

  public abstract function start();
}

abstract class WPPluginStarter
{
  public abstract function start();
}
