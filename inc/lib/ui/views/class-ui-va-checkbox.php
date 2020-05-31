<?php

class UIVACheckbox extends UIViewAdapter
{
  public function show_field()
  {
?><input type="checkbox" name="<?php $this->the_id(); ?>" id="<?php $this->the_id(); ?>" value="1" <?php checked($this->get_value(), true); ?> <?php $this->the_disabled(); ?>/><?php
  }
}
