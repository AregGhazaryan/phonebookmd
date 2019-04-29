<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;
use App\Models\Contact;

class Phonebook extends \Core\Controller
{

  public function indexAction() {
    if ($_SESSION['user_data']['id'] !== getNum()) {
      exit(header('location: '.ROOT_PATH.'/phonebook/'.$_SESSION['user_data']['id'].'/index'));
    }
    if (isset($_POST['del'])) {
      $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $d= new Contact;
      $d->delete($post);
    }
    $c = new Contact;
    $data = $c->getContacts();
    View::render('PhoneBook/index.php',true, $data);
  }

  public function add() {
      View::render('Phonebook/add.php',true,false);
      if (!isset($_SESSION['is_logged_in'])) {
        exit(header('Location:'.ROOT_PATH.'/users/profile/'.$_SESSION['user_data']['id']));
      }
      if (isset($_POST['submit'])) {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $c = new Contact;
        $check = $c->insert($post);
      }
  }

  public function edit() {
    if (isset($_POST['submit'])) {
      $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $e = new Contact;
      $check = $e->update($post);
      if ($check == 'success') {
        setMsg('Contact information successfully updated!', 'success');
        exit(header('Location: '.ROOT_PATH.'/phonebook/'.$_SESSION['user_data']['id'].'/index'));
      }
    }
    $info = new Contact;
    $data = $info->getContactInfo(getNum());
    View::render('Phonebook/edit.php',true,$data);
  }

  public function view() {
    $info = new Contact;
    $data = $info->getContactInfo(getNum());
    View::render('Phonebook/view.php',true,$data);
    if (isset($_POST['del'])) {
      $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $d= new Contact;
      $d->delete($post);
    }
  }
  
}
