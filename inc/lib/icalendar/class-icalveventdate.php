<?php

/*
 * Parsing ICal Dates
 * @author     Sjoerd Takken
 * @copyright  No Copyright.
 * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
 */
class ICalVEventDate
{
  private $dateString;
  private $isDate;
  private $timestamp;
  private $logger;
  private $dateHelper;

  public function __construct($logger, $key, $dateStr)
  {
    $this->logger = $logger;
    $this->key = $key;
    $this->dateString = $dateStr;
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

  public function getDateString()
  {
    return $this->dateString;
  }

  private function setTimestamp($timestamp)
  {
    $this->timestamp = $timestamp;
  }

  public function getTimestamp()
  {
    return $this->timestamp;
  }

  private function setDate($isDate)
  {
    $this->isDate = $isDate;
  }

  public function isDate()
  {
    return $this->isDate;
  }

  public function parse()
  {
    $dateHelper = new ICalDateHelper();
    $key = $this->getKey();
    $value = $this->getDateString();

    if(strpos($key, 'VALUE=DATE-TIME') !== false)
    {
      $this->setDate(false);
    }
    else if(strpos($key, 'VALUE=DATE') !== false)
    {
      $this->setDate(true);
    }
    else
    {
      $this->setDate(false);
    }

    $ts = $dateHelper->fromiCaltoUnixDateTime($value);
    $this->setTimestamp($ts);
  }

}
