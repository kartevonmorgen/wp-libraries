<?php
/**
  * PHPStringUtil
  * 
  * @author     Sjoerd Takken
  * @copyright  No Copyright.
  * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
  */
class PHPStringUtil 
{
  public function __construct() 
  {
  }

  public function startsWith( $haystack, $needle ) 
  {
    $length = strlen( $needle );
    return substr( $haystack, 0, $length ) === $needle;
  }

  public function endsWith( $haystack, $needle ) 
  {
    $length = strlen( $needle );
    if( !$length ) 
    {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
  }

  public function str_split_unicode($str, $l = 0) 
  {
    if ($l > 0) 
    {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
  }


}
