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
    $message .= '[' . 
      get_date_from_gmt(date("Y-m-d H:i:s")) . '] ';
  }

  public function add_newline()
  {
    $message .= PHP_EOL;
  }

  public function add_line($line)
  {
    $message .= $line;
    $this->add_newline();
  }

  public abstract function save();

  public function reset()
  {
    $message = '';
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
