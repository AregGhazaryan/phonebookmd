<?php
namespace App\Controllers;
use \App\Models\User;
use \Core\View;

class Users extends \Core\Controller
{
  protected function before()
  {

  }

  public function indexAction()
  {
    exit(header('Location: ' . ROOT_PATH . '/user/' . $_SESSION['user_data']['id'] . '/profile'));
  }

  public function profile()
  {
    if ($_SESSION['user_data']['id'] !== getNum()) {
      exit(header('location: '.ROOT_PATH.'/users/'.$_SESSION['user_data']['id'].'/profile'));
    }
    $get = new User;
    $data = $get->getUserData();
    View::render('user/index.php',true, $data);
  }

  public function edit(){
    if ($_SESSION['user_data']['id'] !== getNum()) {
      exit(header('location: '.ROOT_PATH.'/users/'.$_SESSION['user_data']['id'].'/profile'));
    } else {
      $get = new User;
      $data = $get->getUserData();
      View::render('user/edit.php',true, $data);
    }
    if(isset($_POST['submit'])) {
      $update = new User;
      $update->update();
    }
  }

  protected function after()
  {

  }
}
