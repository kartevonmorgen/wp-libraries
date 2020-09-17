<?php

/**
  * AbstractLogger
  * 
  * @author     Sjoerd Takken
  * @copyright  No Copyright.
  * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
  */
abstract class AbstractLogger
{
  private $prefix;
  private $message;
  private $id;
  private $key;

  public function __construct($id, $key) 
  {
    $this->id = $id;
    $this->key = $key;

    $this->reset();
  }

  public function add_date()
  {
    $this->message .= '[' . 
      get_date_from_gmt(date("Y-m-d H:i:s")) . '] ';
  }

  public function add_prefix($prefix)
  {
    $this->prefix = $prefix;
  }

  public function remove_prefix()
  {
    $this->prefix = '';
  }

  public function add_line($line)
  {
    $this->message .= $this->prefix;
    $this->message .= $line;
    $this->add_newline();
  }

  public function add_newline()
  {
    $this->message .= PHP_EOL;
  }

  public abstract function save();

  public function reset()
  {
    $this->prefix = '';
    $this->message = '';
  }

  public function get_message()
  {
    return $this->message;
  }

  public function get_id()
  {
    return $this->id;
  }

  public function get_key()
  {
    return $this->key;
  }

}
