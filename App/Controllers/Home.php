<?php

namespace App\Controllers;

use \Core\View;
use \Core\Model;
use App\Models\User;

class Home extends \Core\Controller
{

  protected function before()
  {
    $check = new User;
    $check->checkin();
  }

  public function indexAction()
  {
    userMiddleware('/phonebook/'.@$_SESSION['user_data']['id'].'/index');
    View::render('Home/index.php',true, false);
  }

  public function register()
  {
    View::render('Home/register.php',true, false);
    if(isset($_POST['submit'])){
      $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $reg = new User;
      $reg->insert($post);
    }
  }

  public function login()
  {
    userMiddleware('/');
      View::render('Home/login.php',true, false);
      if (isset($_POST['submit'])) {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $reg = new User;
        $reg->login($post);
    }
  }

  public function logout(){
    unset($_SESSION['is_logged_in']);
    unset($_SESSION['user_data']);
    session_destroy();
    // Redirect
    exit(header('Location: '.ROOT_PATH.'/'));
  }

  protected function after()
  {
  }

}
