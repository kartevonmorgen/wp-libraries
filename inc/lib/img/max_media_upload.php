<?php

add_filter('wp_handle_upload_prefilter', 
           'max_media_upload_error_message');

function max_media_upload_error_message($file) 
{
  $enabled = get_option('wplib_max_media_uploadenabled');
  if(empty($enabled))
  {
    return $file;
  }
  $limit = get_option('wplib_max_media_uploadsize');
  if(empty($limit))
  {
    $limit = 500;
  }
  $limit_output = $limit . ' kB';

  $size = $file['size'];
  $size = $size / 1024;

  if ( ( $size > $limit ) ) 
  {
    $file['error'] = 'Bilder, Video, '.
                     'Audio sollten kleiner sein dann ' . 
                     $limit_output . ' ( ' . round($size) . 
                     ' > ' . $limit . ' )';
  }
  return $file;
}

add_action('admin_head', 'upload_load_styles');

function upload_load_styles() 
{
  $enabled = get_option('wplib_max_media_uploadenabled');
  if(empty($enabled))
  {
    return;
  }
  $limit = get_option('wplib_max_media_uploadsize');
  if(empty($limit))
  {
    $limit = 500;
  }
  $limit_output = $limit . ' kB';
  ?>
  <!-- .Custom Max Upload Size -->
	<style type="text/css">
		.after-file-upload {
			display: none;
		}
		.upload-flash-bypass:after {
			content: 'Maximale große für Bilder, Video und Audio: <?php echo $limit_output ?>.';
			display: block;
			margin: 15px 0;
		}

  </style>
  <!-- END Custom Max Upload Size -->
  <?php
}
