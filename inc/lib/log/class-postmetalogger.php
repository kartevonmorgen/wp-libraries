<?php

/**
  * PostMetaLogger
  * 
  * @author     Sjoerd Takken
  * @copyright  No Copyright.
  * @license    GNU/GPLv2, see https://www.gnu.org/licenses/gpl-2.0.html
  */
class PostMetaLogger extends AbstractLogger
{

  public function save()
  {
    update_post_meta(
      $this->get_id(),
      $this->get_key(),
      $this->get_message());
  }
}
