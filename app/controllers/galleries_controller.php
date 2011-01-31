<?php

/**
 * Displays the homepage, or a gallery and provides the
 * endpoint for the ajax select process.
 */
class GalleriesController extends AppController
{

  public $name = 'Galleries';


  /**
   * Check if the user has a password in his session and
   * store that information.
   */
  function beforeFilter()
  {
    $logged_in = ($this->Session->read('user_password'));
    $this->set('logged_in', $logged_in);
  }


  /**
   * The index page that displays information about markab.
   */
  function index() { }


  /**
   * Displays a gallery.
   */
  function show($id)
  {
    $this->_checkLogin($id);

    if (!$this->Gallery->hasPictures())
    {
      $this->Session->setFlash(__('The page you requested does not exist.', true));
      $this->redirect('/');
    }
    $this->set('id', $id);
    $this->set('pictures', $this->Gallery->getPictures());
  }


  /**
   * Endpoint for the ajax call that selects or deselects
   * a picture in a gallery.
   */
  function select()
  {
    $this->autoRender = false;
    
    $this->_checkLogin($this->params['id']);

    $this->Gallery = new Gallery($this->params);
    $this->Gallery->markAsSelected($this->params['image'], $this->params['value']);

    die($this->params['id'].' updated.');
  }


  /**
   * Checks if the password that the user carries in his
   * session matches the current galleries password.
   * If there is no or an incorrect password, the user
   * will be redirected to the login page for that gallery.
   */
  protected function _checkLogin($id)
  {
    if (!$this->Gallery->hasPassword())
      return true;

    $gallery_password = $this->Gallery->getPassword();
    $user_password = $this->Session->read('user_password');

    if (empty($user_password))
    {
      $this->Session->setFlash(__('Please log in.', true));
      $this->redirect('/login/'.$id);
    }
    else if ($user_password !== $gallery_password)
    {
      $this->Session->setFlash(__('Your password is not correct. Please try again.', true));
      $this->redirect('/login/'.$id);
    }
  }

  
}