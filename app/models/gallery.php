<?php


class Gallery extends AppModel {

  public $name = 'Gallery';
  
  public $useTables = false;


  protected $directory;

  protected $password = false;

  protected $pictures = array();



  function __construct($data) {

    $this->directory = Configure::read('Galleries.root') . $data['id'];

    if (file_exists($this->directory)) {

      $this->password = $this->loadPassword();
      $this->pictures = $this->loadPictures();

      if (count($this->pictures) > 0)
        $this->loadSelected();

    }

  }

  



  function loadPassword() {

    $password_file = $this->directory . DS . 'password.php';

    if (!file_exists($password_file)) {

      return false;

    } else {

      include($password_file);
      return Configure::read('Galleries.password');

    }
    
  }//loadPassword()

  
  protected function loadPictures() {

    $pictures = array();
    $absolute_pictures = glob( $this->directory . DS . '*.jpg' );
    if (!$absolute_pictures)
      $absolute_pictures = glob( $this->directory . DS . '*.JPG' );


    foreach($absolute_pictures as $picture) {

      $pictures[$this->lastPart($picture)] = array(
        'file_name' => $this->lastPart($picture),
        'full_path' => $this->filterFilename($picture),
        'thumbnail_path' => str_replace('/data/', '/thumb/', $this->filterFilename($picture)),
        'selected'  => false
      );
      
    }

    return $pictures;

  }//loadPictures()


  public function hasPictures() {

    return (count($this->pictures) > 0);

  }
  

  protected function loadSelected() {

    $filename = $this->directory . DS . Configure::read('Galleries.selected_file_name');

    if (!file_exists($filename)) file_put_contents($filename,'');
    
    $selected_files = file($filename);

    if (count($selected_files) !== 0) {
      foreach($selected_files as $selected_file) {
        $selected_file = trim($selected_file);
        if (!empty($selected_file))
          $this->pictures[$selected_file]['selected'] = true;
      }
    }

  }//loadSelected()


  public function markAsSelected($params) {

    $filename = $this->directory . DS . Configure::read('Galleries.selected_file_name');

    $new_value = ($params['value'] === 'true') ? true : false;
    $this->pictures[$params['image']]['selected'] = $new_value;

    $file_contents = '';
    foreach($this->pictures as $picture) {
      if ($picture['selected'] === true)
        $file_contents .= $picture['file_name']."\n\r";
    }
    file_put_contents($filename, $file_contents);
    
  }



  protected function filterFilename($filename) {

    $filename = str_replace(ROOT.DS, '', $filename);
    $filename = str_replace('\\', '/', $filename);

    return FULL_BASE_URL . Router::url('/', false). $filename;

  }
  

  protected function lastPart($string, $separator = DS) {
    $parts = explode($separator, $string);
    $last = array_pop($parts);
    return $last;
  }




  public function hasPassword() {
    return ($this->password !== false);
  }

  public function getPassword() {
    return $this->password;
  }

  /**
   * @return array    An array including all the filenames as absolute paths.
   */
  public function getPictures() {

    return array_values($this->pictures);
    
  }


}