<?php

/*
 * Parsing ICal Text Type
 * @author     Sjoerd Takken
 * @copyright  No Copyright.
 * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
 */
class ICalVEventText
{
  private $logger;
  private $value;
  private $result;

  public function __construct($logger, $value)
  {
    $this->logger = $logger;
    $this->value = $value;
  }

  private function getValue()
  {
    return $this->value;
  }

  private function get_logger()
  {
    return $this->logger;
  }

  private function setResult($result)
  {
    $this->result = $result;
  }

  public function getResult()
  {
    return $this->result;
  }

  public function parse()
  {
    $value = $this->getValue();

    // Remove the "\," because it is removed by wordpress and then we always get trouble with comparing
    $value = str_replace("\,", ",", $value);

    // Replace \n to <br> for a good html view
    $value = str_replace("\\n", "<br>", $value);
    $this->setResult($value);
  }


}

