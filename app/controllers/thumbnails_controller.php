<?php

include('../libs/SimpleImage.php');

class ThumbnailsController extends AppController {

  public $name = 'Thumbnails';

  public $uses = array();



  public function index() {

    $this->autoRender = false;

    $filename = $this->params['gallery'].DS.$this->params['image'];
    $original_filename = Configure::read('Galleries.root').$filename;
    $cache_name = md5($filename.filectime($original_filename));
    $thumbnail_filename = Configure::read('Galleries.image_cache').$cache_name;


    if (!file_exists($thumbnail_filename)) {

      $image = new SimpleImage();
      $image->load($original_filename);
      $image->resizeToWidth(Configure::read('Image.width'));
      $image->save($thumbnail_filename);
      
    }

    header('Content-Type: image/jpeg');
    echo file_get_contents($thumbnail_filename);

  }


}//ThumbnailsController