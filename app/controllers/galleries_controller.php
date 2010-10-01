<?php


class GalleriesController extends AppController {

  
  public $name = 'Galleries';


  function beforeFilter() {
    
    if ($this->Session->read('user_password'))
      $logged_in = true;
    else
      $logged_in = false;
    
    $this->set('logged_in', $logged_in);
    
  }



  /**
   * The index page.
   */
  function index() {

  }


  /**
   * The login page.
   *
   * The user will be redirected to this action, if he tries to
   * access a gallery that has password protection and is not logged in.
   * The according view will display a little form. If the form has been submit,
   * the entered password will be written into the session and the user will
   * be redirected to the page he tried to access earlier. If the entered
   * password is incorrect, the show gallery action will again redirect the
   * usere to this action and he can enter another password.
   */
  function login($id) {
    
    if (in_array('data', array_keys($this->params))) {
      $this->Session->write('user_password', $this->params['data']['Login']['password']);
      $this->redirect('/'.$id);
    }
    $this->set('id', $id);
    
  }


  /**
   * The logout page.
   *
   * If the user hits this page, the stored password in the session will be
   * deleted and he/she will be redirected to the index action.
   */
  function logout() {
    $this->Session->setFlash(__('You were correctly logged out.', true));
    $this->Session->delete('user_password');
    $this->redirect('/');
  }


  function show($id) {

    $this->checkLogin($id);

    if (!$this->Gallery->hasPictures()) {
      $this->Session->setFlash(__('The page you requested does not exist.', true));
      $this->redirect('/');
    }

    $this->set('pictures', $this->Gallery->getPictures());
    $this->set('id', $id);

  }//show()


  function select() {
    $this->checkLogin($this->params['id']);

    $this->Gallery = new Gallery($this->params);
    $this->Gallery->markAsSelected($this->params);

    $this->autoRender = false;
  
    echo $this->params['id'].' updated.';
    die();

  }//select()



  protected function checkLogin($id) {

    if (!$this->Gallery->hasPassword())
      return true;

    $gallery_password = $this->Gallery->getPassword();
    $user_password = $this->Session->read('user_password');

    if (empty($user_password)) {

      $this->Session->setFlash(__('Please log in.', true));
      $this->redirect('/login/'.$id);

    } else if ($user_password !== $gallery_password) {

      $this->Session->setFlash(__('Your password is not correct. Please try again.', true));
      $this->redirect('/login/'.$id);

    }

    
    
  }//checkLogin()


}//class GalleriesController