<?php

/*
 * @author     Sjoerd Takken
 * @copyright  No Copyright.
 * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
 */
class ICalVEvent
{
  private $logger;
  private $dt_startdate;
  private $dt_enddate;
  private $dt_allday;
  private $lastmodified;
  private $created;
  private $uid;
  private $summary;
  private $description;
  private $location;
  private $organizer_name;
  private $organizer_email;
  private $url;
  private $recurring;
  private $recurring_dates;

  function __construct($logger)
  {
    $this->logger = $logger;
  }

  function get_logger()
  {
    return $this->logger;
  }

  function log($log)
  {
    $this->get_logger()->add_log($log);
  }

  function set_dt_startdate($startdate)
  {
    $this->dt_startdate = $startdate;
  }

  function get_dt_startdate()
  {
    return $this->dt_startdate;
  }

  function set_dt_allday($allday)
  {
    $this->dt_allday = $allday;
  }

  function is_dt_allday()
  {
    return $this->dt_allday;
  }

  function set_dt_enddate($enddate)
  {
    $this->dt_enddate = $enddate;
  }

  function get_dt_enddate()
  {
    return $this->dt_enddate;
  }

  function set_lastmodified($modified)
  {
    $this->lastmodified = $modified;
  }

  function get_lastmodified()
  {
    return $this->lastmodified;
  }

  function set_created($created)
  {
    $this->created = $created;
  }

  function get_created()
  {
    return $this->created;
  }

  function set_uid($uid)
  {
    $this->uid = $uid;
  }

  function get_uid()
  {
    return $this->uid;
  }

  function set_summary($summary)
  {
    $this->summary = $summary;
  }

  function get_summary()
  {
    return $this->summary;
  }

  function set_description($description)
  {
    $this->description = $description;
  }

  function get_description()
  {
    return $this->description;
  }

  function set_url($url)
  {
    $this->url = $url;
  }

  function get_url()
  {
    return $this->url;
  }

  function set_location($location)
  {
    $this->location = $location;
  }

  function get_location()
  {
    return $this->location;
  }

  function set_organizer_name($organizer_name)
  {
    $this->organizer_name = $organizer_name;
  }

  function get_organizer_name()
  {
    return $this->organizer_name;
  }

  function set_organizer_email($organizer_email)
  {
    $this->organizer_email = $organizer_email;
  }

  function get_organizer_email()
  {
    return $this->organizer_email;
  }

  function set_recurring($recurring)
  {
    $this->recurring = $recurring;
  }

  function is_recurring()
  {
    return $this->recurring;
  }

  function set_recurring_dates($recurring_dates)
  {
    $this->recurring_dates = $recurring_dates;
  }

  function get_recurring_dates()
  {
    return $this->recurring_dates;
  }


  function parse_value($key, $value)
  {
    $keys = explode(';', $key);
    if(empty($keys))
    {
      return;
    }

    $firstpartofkey = reset($keys);
    switch ($firstpartofkey) 
    {
      case 'DTSTART':
        $vEventDate = new ICalVEventDate($this->get_logger(), $key, $value);
        $vEventDate->parse();
        $this->set_dt_startdate($vEventDate->getTimestamp());
        $this->set_dt_allday($vEventDate->isDate());
        break;
      case 'DTEND':
        $vEventDate = new ICalVEventDate($this->get_logger(), $key, $value);
        $vEventDate->parse();
        $this->set_dt_enddate($vEventDate->getTimestamp());
        $this->set_dt_allday($vEventDate->isDate());
        break;
      case 'RRULE':
        $recurring = new ICalVEventRecurringDate($value, $this->get_dt_startdate());
        $this->set_recurring(true);
        $this->set_recurring_dates($recurring->getDates());
        break;
      case 'LAST_MODIFIED':
        $vEventDate = new ICalVEventDate($this->get_logger(), $key, $value);
        $vEventDate->parse();
        $this->set_lastmodified($vEventDate->getTimestamp());
        break;
      case 'CREATED':
        $vEventDate = new ICalVEventDate($this->get_logger(), $key, $value);
        $vEventDate->parse();
        $this->set_created($vEventDate->getTimestamp());
        break;
      case 'UID':
        $this->set_uid($value);
        break;
      case 'SUMMARY':
        $text = new ICalVEventText($this->get_logger(), $value);
        $text->parse();
        $this->set_summary($text->getResult());
        break;
      case 'DESCRIPTION':
        $text = new ICalVEventText($this->get_logger(), $value);
        $text->parse();
        $this->set_description($text->getResult());
        break;
      case 'URL':
        $this->set_url($value);
        break;
      case 'LOCATION':
        $this->set_location($value);
        break;
      case 'ORGANIZER':
        $vEventOrganizer = new ICalVEventOrganizer($this->get_logger(), $key, $value);
        $vEventOrganizer->parse();
        $this->set_organizer_name($vEventOrganizer->getName());
        $this->set_organizer_email($vEventOrganizer->getEmail());
        break;
    }
  }

}
