<?php

include('../libs/SimpleImage.php');

class Thumbnail extends AppModel
{

  public $name = 'Thumbnail';

  public $useTables = false;

  
  protected $filename = false;

  protected $source   = false;

  protected $thumb_path   = false;


  public function __construct($data)
  {
    $this->filename     = $data['id'];
    $this->source       = Configure::read('Galleries.root').$this->filename;
    $cache_name         = md5($this->filename.filectime($this->source));
    $this->thumb_path   = Configure::read('Galleries.image_cache').$cache_name;
  }

  
  public function sourceFileExists()
  {
    return file_exists($this->source);
  }


  public function getData()
  {
    if (!file_exists($this->thumb_path))
    {
      $this->_generateThumbnail();
    }
    return file_get_contents($this->thumb_path);
  }


  /**
   * Generates the thumbnail for a given file.
   */
  protected function _generateThumbnail()
  {
    $image = new SimpleImage();
    $image->load($this->source);
    $image->resizeToWidth(Configure::read('Image.width'));
    $image->save($this->thumb_path);
  }

}