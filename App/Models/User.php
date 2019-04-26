<?php
namespace App\Models;
use PDO;

class User extends \Core\Model
{
  public function insert($post)
  {
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $password = md5($post['password']);
    if ($post['submit']) {
      if(empty($post['fname']) || empty($post['lname']) || empty($post['email']) || empty($post['password'])){
        $_SESSION['errorMsg'] = 'One of the fields is empty!';
        exit(header('Location: '.ROOT_PATH.'/home/register'));
      }else{
        $this->query('INSERT INTO users (f_name, l_name, email, pwd, img) VALUES(:fname, :lname , :email, :password, :img)');
        $this->bind(':fname', $post['fname']);
        $this->bind(':lname', $post['lname']);
        $this->bind(':email', $post['email']);
        $this->bind(':img', 'default.png');
        $this->bind(':password', $password);
        $this->execute();
        // Verify
        if ($this->lastInsertId()) {
          // Set Message and Redirect
          $_SESSION['successMsg'] = 'Congratulations, you\'ve been successfully registered, you can login now!';
          exit(header('Location: '.ROOT_PATH.'/home/login'));
        }
      }
    }
    return;
  }

public function checkin(){
  $this->query('CREATE TABLE IF NOT EXISTS contacts (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  fname     VARCHAR (255),
  lname     VARCHAR (255),
  email     VARCHAR (255),
  address     VARCHAR (255),
  image     VARCHAR (255),
  uid     VARCHAR (255),
  uniqid     VARCHAR (255)
);
CREATE TABLE IF NOT EXISTS numbers (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  pnumber     VARCHAR (255),
  cid     VARCHAR (255)
);
CREATE TABLE IF NOT EXISTS users (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  f_name     VARCHAR (255),
  l_name     VARCHAR (255),
  email     VARCHAR (255),
  pwd     VARCHAR (255),
  img			VARCHAR (255)
)');
  $this->execute();
  if (reinstall()) {
  $this->query('
  DROP TABLE IF EXISTS contacts;
  DROP TABLE IF EXISTS numbers;
  DROP TABLE IF EXISTS users;
  CREATE TABLE IF NOT EXISTS contacts (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    fname     VARCHAR (255),
    lname     VARCHAR (255),
    email     VARCHAR (255),
    address     VARCHAR (255),
    image     VARCHAR (255),
    uid     VARCHAR (255),
    uniqid     VARCHAR (255)
  );
  CREATE TABLE IF NOT EXISTS numbers (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    pnumber     VARCHAR (255),
    cid     VARCHAR (255)
  );
  CREATE TABLE IF NOT EXISTS users (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    f_name     VARCHAR (255),
    l_name     VARCHAR (255),
    email     VARCHAR (255),
    pwd     VARCHAR (255),
    img			VARCHAR (255)
    )');
      $this->execute();
      toggle();
    }
}

  public function login($post){
    userMiddleware('/');
    // Sanitize POST
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $password = md5($post['password']);
    if ($post['submit']) {
        // Compare Login
        $this->query('SELECT * FROM users WHERE email = :email AND pwd = :password');
        $this->bind(':email', $post['email']);
        $this->bind(':password', $password);
        $row = $this->single();
        if ($row) {
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user_data'] = array(
                "id"	  => $row['id'],
                "name"	=> $row['f_name'],
                "email"	=> $row['email']
            );
            header('Location: '.ROOT_PATH.'/users/'.$_SESSION['user_data']['id'].'/profile');
        } else {
            $_SESSION['errorMsg']="Incorrect Login!";
            exit(header("Location: ".ROOT_PATH."/home/login"));
        }
    }
    return;
  }

  public function getUserData() {
    $id = getNum();
    $this->query('SELECT * FROM users where id=:id');
    $this->bind(":id", $id);
    return $this->single();
  }

  public function update() {
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if ($post['fname'] === "" && $post['lname'] === "" && $post['password'] === "" && $post['email'] === "" && $_FILES['image']['size'] < 0) {
        setMsg('All fields were empty, profile information hasn\'t changed', 'error');
        return;
    }
    $this->query('SELECT * FROM users WHERE id=:uid');
    $this->bind(':uid', $_SESSION['user_data']['id']);
    $old = $this->single();
    $password = md5($post['password']);
    $id = $_SESSION['user_data']['id'];
    $this->query('UPDATE users SET f_name = :fname, l_name= :lname, email = :email, pwd=:password, img = :img	WHERE id =:id');
    if ($post['fname'] === "" || empty($post['fname'])) {
        $this->bind(':fname', $old['f_name']);
    } else {
        $this->bind(':fname', $post['fname']);
    }
    if ($post['lname'] === "" || empty($post['lname'])) {
        $this->bind(':lname', $old['l_name']);
    } else {
        $this->bind(':lname', $post['lname']);
    }
    if ($post['email'] === "" || empty($post['email'])) {
        $this->bind(':email', $old['email']);
    } else {
        $this->bind(':email', $post['email']);
    }
    if ($_FILES['image'] === "" || empty($_FILES['image']) || $_FILES['image']['size']==0) {
        $this->bind(':img', $old['img']);
    } else {
        if ($_FILES['image']['size']>0) {
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp  = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $explosion = explode('.',$_FILES['image']['name']);
            $file_ext  = strtolower(end($explosion));
            $filenm    = reset($explosion);
            $extensions = array("jpeg","jpg","png");
            if (in_array($file_ext, $extensions) === false) {
                setMsg('Error : Extension not allowed', 'error');
                exit();
            }
            if ($file_size > 2097152) {
              setMsg('Error : Image size too big', 'error');
              exit();
            }
            if (empty($errors) == true) {
                $bad = array("'", '"', "/", "\\", "<", ">", "!", "@", "#", "$", "%", "^","&", "*", "(",")","+");
                $file_name = str_replace($bad, "",$filenm) . "-" .uniqid().".".$file_ext;
                move_uploaded_file($file_tmp, "./assets/img/avis/".$file_name);
                if($old['img'] !== "default.png"){
                  unlink('./assets/img/avis/' . $old['img']);
                }
                $this->bind(':img', $file_name);
            } else {
                $this->bind(':img', $old['img']);
            }
        }
    }
    if ($post['password'] === "" || empty($post['password'])) {
        $this->bind(':password', $old['pwd']);
    } else {
        $this->bind(':password', $password);
    }
    $this->bind(':id', $_SESSION['user_data']['id']);
    $this->execute();
    $this->query('SELECT * FROM users WHERE id=:id');
    $this->bind(':id', $_SESSION['user_data']['id']);
    $row = $this->single();
    if ($row) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_data'] = array(
                "id"	=> $row['id'],
                "name"	=> $row['f_name'],
                "email"	=> $row['email']
            );
    }
    setMsg('Profile information has changed according to the changed fields', 'success');
    echo "<meta http-equiv='refresh' content='0'>";
  }

}
