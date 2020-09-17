<?php

/**
  * PostMetaLogger
  * 
  * @author     Sjoerd Takken
  * @copyright  No Copyright.
  * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
  */
class LogResult
{
  private $_result;
  private $_text;
  
  public function __construct($result, $message) 
  {
    $this->_result = result;
    $this->_message = message;
  }

  public function is_true()
  {
    return $this->_result;
  }

  public function is_false()
  {
    return !$this->_result;
  }

  public function get_message()
  {
    return $this->_message;
  }

  public static function true_result($message)
  {
    return new LogResult(true, $message);
  }

  public static function false_result($message)
  {
    return new LogResult(false, $message);
  }
}
