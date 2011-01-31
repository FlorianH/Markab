<?php


class Gallery extends AppModel
{
  
  public $name = 'Gallery';
  
  public $useTables = false;

  protected $directory;

  protected $password = false;

  protected $pictures = array();


  function __construct($data)
  {
    $this->directory = Configure::read('Galleries.root') . $data['id'];

    if (file_exists($this->directory))
    {
      $this->password = $this->_loadPassword();
      $this->pictures = $this->_loadPictures();

      if (count($this->pictures) > 0)
      {
        $this->_loadSelected();
      }
    }
  }


  protected function _loadPassword()
  {
    $password_file = $this->directory . DS . 'password.php';

    if (!file_exists($password_file))
    {
      return false;
    }
    else
    {
      include($password_file);
      return Configure::read('Galleries.password');
    }
  }

  
  protected function _loadPictures()
  {
    $pictures = array();

    $pictures_files = array_merge(
      glob( $this->directory . DS . '*.jpg' ),
      glob( $this->directory . DS . '*.JPG' ));

    foreach($pictures_files as $picture)
    {
      $pictures[$this->_lastPart($picture)] = array(
        'file_name'       => $this->_lastPart($picture),
        'full_path'       => $this->_filterFilename($picture),
        'thumbnail_path'  => str_replace('/data/', '/thumb/', $this->_filterFilename($picture)),
        'selected'        => false
      );
    }
    return $pictures;
  }



  protected function _loadSelected() {

    $filename = $this->directory . DS . Configure::read('Galleries.selected_file_name');

    //Create file and make shure it is writable
    if (!file_exists($filename))
      file_put_contents($filename,'');
    
    $selected_files = file($filename);

    if (count($selected_files) !== 0)
    {
      foreach($selected_files as $selected_file)
      {
        $selected_file = trim($selected_file);
        if (!empty($selected_file))
        {
          $this->pictures[$selected_file]['selected'] = true;
        }
      }
    }
  }

  /**
   * Marks on image as selected and saves the new state to the "selected" file.
   * @param array $params
   */
  public function markAsSelected($image, $value)
  {
    $filename = $this->directory . DS . Configure::read('Galleries.selected_file_name');

    $selected = ($value === 'true') ? true : false;
    $this->pictures[$image]['selected'] = $selected;

    $file_contents = '';
    foreach($this->pictures as $picture)
    {
      if ($picture['selected'] === true)
        $file_contents .= $picture['file_name']."\n\r";
    }
    file_put_contents($filename, $file_contents);
  }


  /**
   * Filters the file system root and windows diretory parts ("\\") from a string.
   *
   * @param string $filename  The unfiltered string.
   * @return string           The filtered string.
   */
  protected function _filterFilename($filename)
  {
    $filename = str_replace(ROOT.DS, '', $filename);
    $filename = str_replace('\\', '/', $filename);

    return FULL_BASE_URL . Router::url('/', false). $filename;
  }


  /**
   * Splits the string into parts using the seperator and returns the last part.
   * 
   * @param string $string      The source string.
   * @param string $separator   The seperator, used to cut the string into parts
   *                            if not provided, the system's directory seperator
   *                            will be used.
   * @return string             The last part of the string.
   */
  protected function _lastPart($string, $separator = DS)
  {
    $parts = explode($separator, $string);
    $last = array_pop($parts);
    return $last;
  }


  /**
   * @return boolean  True if this gallery is password protected, false if not.
   */
  public function hasPassword()
  {
    return ($this->password !== false);
  }


  /**
   * GETTER
   * @return string The password for the current gallery.
   */
  public function getPassword()
  {
    return $this->password;
  }


  /**
   * @return boolean
   */
  public function hasPictures()
  {
    return (count($this->pictures) > 0);
  }

  
  /**
   * @return array    An array including all the filenames as absolute paths.
   */
  public function getPictures()
  {
    return array_values($this->pictures);
  }


}