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
                            array($this, 'do_activate'));
    register_deactivation_hook( $plugin, 
                            array($this, 'do_deactivate'));
    register_uninstall_hook( $plugin, 
                             array( $this, 'do_uninstall'));
    $col = WPPluginLoaderCollection::get_instance();
    $col->add_loader($this);
  }

  public function get_plugin_dir()
  {
    return plugin_dir_path($this->get_plugin());
  }

  public function get_plugin_id()
  {
    return plugin_basename($this->get_plugin());
  }

  public function get_plugin()
  {
    return $this->_plugin;
  }

  public function get_plugin_name()
  {
    $id = $this->get_plugin_id();
    $pos = strpos($id, '/');
    return substr($id, 0 , $pos);
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

  public function do_activate()
  {
    $this->init();

    if(!$this->are_dependencies_active() )
    {
      echo 'Abhängige Plugins ( ' .
        $this->get_dependencies_info() .
        ' ) sind nicht aktiviert';
      exit;
    }

    $this->load_includes();

    $this->activate();
  }

  public function activate()
  {
  }

  public function is_activated()
  {
    return is_plugin_active($this->get_plugin_id());
  }

  public function do_deactivate()
  {
    $depend_plugins = array();
    $col = WPPluginLoaderCollection::get_instance();
    foreach($col->get_loaders() as $loader)
    {
      //echo 'LOAD(' . $loader->get_plugin_id() . ') ';
      foreach($loader->get_dependencies() as $dep)
      {
        //echo ' DEP=' . $dep . ' THIS=' . 
        //  $this->get_plugin_id();
        if($dep === $this->get_plugin_id())
        {
          if($loader->is_activated())
          {
            array_push($depend_plugins, 
                       $loader->get_plugin_name() );
          }
        }
      }
    }
    if(!empty($depend_plugins))
    {
       echo '<p>die folgenden Plugins (' .  
              implode(', ', $depend_plugins) . 
              ') benutzen diesen Plugin. ' .
              ' Darum kann der Plugin (' .
              $this->get_plugin_name() . ') ' .
              'nicht deaktiviert werden<p>'; 
       echo '<p>Bitte deaktivieren Sie erst ' . 
            'die andere Plugins</p>';
       echo '<p><a href="plugins.php">' .
            'Gehe zurück zu den Plugins-Übersicht</a></p>';
       exit;
    }

    $this->deactivate();
  }

  public function deactivate()
  {
  }

  public function do_uninstall()
  {
    $this->uninstall();
  }

  public function uninstall()
  {
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

class WPPluginLoaderCollection
{
  private static $instance = null;

  private $_pluginLoaders = array();

  private function __construct()
  {
  }

  public static function get_instance()
  {
    if (self::$instance == null)
    {
      self::$instance = new WPPluginLoaderCollection();
    }
    return self::$instance;
  }

  public function add_loader($pluginLoader)
  {
    array_push($this->_pluginLoaders, $pluginLoader);
  }

  public function get_loaders()
  {
    return $this->_pluginLoaders;
  }
}
