<?php

class UIUserMetaModelAdapter extends UIModelAdapter
{
  public function save_value()
  {
    $user_id = $this->get_property(UIModel::USER_ID);
    if(empty($user_id))
    {
      return;
    }
    $value = $this->get_value();
    echo 'SAVE: ' . $this->get_id() . ' = ' . $value;
    update_user_meta( $user_id, 
                      $this->get_id(),
                      $value);
  }

  public function load_value()
  {
    $value = '';
    $user_id = $this->get_property(UIModel::USER_ID);
    if( empty($user_id) )
    {
      if( !empty( $_POST[$this->get_id()] ) )
      {
        $value = sanitize_text_field( 
                   $_POST[$this->get_id()] );
      }
    }
    else
    {
      $value = get_the_author_meta( $this->get_id(), 
                                    $user_id );
    }
    echo 'LOAD (' . $this->get_id() . ') USER_ID ' . $user_id . ' VALUE ' . $value;

    $this->set_value($value);
  }
}
