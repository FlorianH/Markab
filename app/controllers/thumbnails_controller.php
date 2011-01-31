<?php


class ThumbnailsController extends AppController
{

  public $name = 'Thumbnails';

  public $uses = array();


  function beforeFilter()
  {
    $filename = $this->params['gallery'] . DS . $this->params['image'];
    $this->loadModel('Thumbnail', $filename);
    
    $this->autoRender = false;
  }

  
  /**
   * Displays the rendered thumbnail or 404 if the file cannot be found.
   */
  public function index()
  {
    if (!$this->Thumbnail->sourceFileExists())
    {
      $this->cakeError('error404');
    }

    header('Content-Type: image/jpeg');
    echo $this->Thumbnail->getData();
  }

}