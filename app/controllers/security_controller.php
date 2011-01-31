<?php



class SecurityController extends AppController
{

  public $name = 'Security';

  public $uses = array();


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
  function login($id)
  {
    if (in_array('data', array_keys($this->params)))
    {
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
  function logout()
  {
		$this->Session->setFlash(__('You were correctly logged out.', true));
    $this->Session->delete('user_password');
    $this->redirect('/');
  }


}