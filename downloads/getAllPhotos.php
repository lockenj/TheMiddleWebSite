<?php 
  $photosLoc = '/content/photos/';
  $photos = array();
  if ($handle = opendir($_SERVER['DOCUMENT_ROOT'] . $photosLoc . 'large')) {
    while (false !== ($file = readdir($handle))) {
      if (!is_dir($file) && preg_match("/\.(bmp|jpe?g|gif|png)$/", $file)) {
        $img = array(
          large=>$photosLoc . 'large/' . $file,
          thumb=>$photosLoc . 'thumbs/' . $file, 
        );
        array_push($photos, $img);
      }
    }
    closedir($handle);
  }
  echo json_encode($photos);
?>