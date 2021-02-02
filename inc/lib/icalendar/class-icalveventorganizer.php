<?php

/*
 * Parsing ICal Organizer Type
 * @author     Sjoerd Takken
 * @copyright  No Copyright.
 * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
 */
class ICalVEventOrganizer
{
  private $value;
  private $email;
  private $name;
  private $logger;

  public function __construct($logger, $key, $value)
  {
    $this->logger = $logger;
    $this->key = $key;
    $this->value = $value;
  }

  public function get_logger()
  {
    return $this->logger;
  }

  public function log($log)
  {
    $this->get_logger()->add_log($log);
  }

  public function getKey()
  {
    return $this->key;
  }

  public function getValue()
  {
    return $this->value;
  }

  private function setEmail($email)
  {
    $this->email = $email;
  }

  public function getEmail()
  {
    return $this->email;
  }

  private function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }

  public function parse()
  {
    $key = $this->getKey();
    $value = $this->getValue();
    $su = new PHPStringUtil();
    
    $pos = strpos($key,'CN=');
    if($pos !== false)
    {
      $name = strstr($key, 'CN=');
      $name = substr($name, 3);
      $pos = strpos($key,';', $pos);
      if($pos !== false)
      {
        $name = substr($name, 0, $pos);
      }

      $name = str_replace('"', '', $name);
      $name = str_replace('%20', ' ', $name);
      $this->setName($name);
    }
    
    if($su->startsWith($value, 'MAILTO:'))
    {
      $email = strstr($value, ':');
      $email = substr($email, 1);
      $this->setEmail($email);
    }

  }

}
