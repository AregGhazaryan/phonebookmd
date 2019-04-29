<?php
namespace App\Models;
use PDO;

class Contact extends \Core\Model
{

  public function getContacts() {
		$id = (int)$_SESSION['user_data']['id'];
		$this->query('SELECT contacts.id, fname, lname, email, address,uid,uniqid,image,
		group_concat(distinct pnumber order by pnumber) c,cid
		FROM contacts LEFT JOIN numbers
		ON contacts.uniqid = numbers.cid
    WHERE  uid = :id
		group by id, fname, lname, email, address,uid,uniqid,cid');
		$this->bind(':id', $id);
		$result = $this->resultSet();
		if ($result) {
					return $result;
		} else {
		exit(header("location:".ROOT_PATH."/phonebook/add"));
		}
  }

  public function getContactInfo($id) {
    $this->query('SELECT * FROM contacts where id=:id');
    $this->bind(":id", $id);
    $selector=$this->single();
    $this->query('SELECT contacts.id, fname, lname, email, address,uid,uniqid, numbers.id,image,
      group_concat(distinct pnumber order by pnumber) c,cid FROM contacts LEFT JOIN numbers ON contacts.uniqid = numbers.cid WHERE cid=:uniq');
    $this->bind(':uniq',$selector['uniqid']);
    $row = $this->single();
    if (!empty($row['c'])) {
      return $row;
    } else {
      return $selector;
    }
  }

  public function insert($post) {
      $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($post['fname'] === ""  && $post['lname'] === "" && $post['address'] === "" && $post['email'] === "" && empty($post['number[]'])) {
        setMsg('All fields are empty please try again', 'error');
        displayFloat();
        exit();
      }
       elseif ($post['fname'] === "" && $post['lname'] === "") {
        setMsg('First Name Or Last Name Is Required', 'error');
        displayFloat();
        exit();
      }
      elseif (strlen($post['fname']) > 50 || strlen($post['lname']) > 50 || strlen($post['address']) > 95  || strlen($post['email']) > 62) {
        setMsg('One of the fields exceeds the allowed amount of characters', 'error');
        displayFloat();
        exit();
      }
      else {
        $uinqid = uniqid();
        $id = $_SESSION['user_data']['id'];
        $this->query('INSERT INTO contacts (fname, lname, email, address, uid, uniqid, image) VALUES(:fname, :lname , :email, :address, :id, :uniid, :img)');
        $this->bind(':fname', $post['fname']);
        $this->bind(':lname', $post['lname']);
        $this->bind(':address', $post['address']);
        $this->bind(':email', $post['email']);
        $this->bind(':id', $_SESSION['user_data']['id']);
        $this->bind(':uniid', $uinqid);
        if ($_FILES['image']['size'] <= 0) {
            $this->bind(':img', 'default.png');
        }
        else {
            if ($_FILES['image']['size'] > 0) {
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_tmp  = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
                $explosion = explode('.', $file_name);
                $file_ext  = strtolower(end($explosion));
                $filenm    = reset($explosion);
                $extensions= array("jpeg","jpg","png");
                if (in_array($file_ext, $extensions) === false) {
                    setMsg('Invalid image extension', 'error');
                    displayFloat();
                    exit();
                }
                if ($file_size > 2097152) {
                    setMsg('Image size exceeds 2MB', 'error');
                    displayFloat();
                    exit();
                }
                if (empty($errors) == true) {
                    $bad = array("'", '"', "/", "\\", "<", ">", "!", "@", "#", "$", "%", "^","&", "*", "(",")","+");
                    $file_name = str_replace($bad, "",$filenm) . "-" .uniqid().".".$file_ext;
                    move_uploaded_file($file_tmp, "./Assets/img/userimgs/".$file_name);
                    $this->bind(':img', $file_name);
                }
                else {
                    $this->bind(':img', 'default.png');
                }
            }
        }
        $row = $this->single();
        foreach($post['number'] as $data){
          if (empty($data)) {
            continue;
          }
          $this->query('INSERT INTO numbers (pnumber, cid) VALUES(:num, :cid)');
          $this->bind(':num', $data);
          $this->bind(':cid', $uinqid);
          $this->execute();
        }
        if($this->lastInsertId()){
          setMsg('Contact Successfully Added', 'success');
          displayFloat();
          exit();
        }
      }
}

public function delete($post) {
  $this->query('SELECT * FROM contacts WHERE uid=:id AND uniqid=:uid');
  $this->bind(':id', $_SESSION['user_data']['id']);
  $this->bind(':uid', $_POST['uniqid']);
  $old = $this->single();
  if ($old['image'] !== "default.png") {
    unlink('./Assets/img/userimgs/' . $old['image']);
  }
  $this->query('DELETE FROM contacts WHERE uid=:id AND uniqid=:uid');
  $this->bind(':id', $_SESSION['user_data']['id']);
  $this->bind(':uid', $_POST['uniqid']);
  $this->execute();
  $this->query('DELETE FROM numbers WHERE cid=:uid');
  $this->bind(':uid', $_POST['uniqid']);
  $this->execute();
  exit(header('Location:'.ROOT_PATH.'/phonebook/'.$_SESSION['user_data']['id']."/index"));
}

public function update($post) {
  if ($post['fname'] === "" && $post['lname'] === "" && $post['address'] === "" && $post['email'] === "" && empty($post['number[]'])) {
    setMsg('Fields Are Empty', 'error');
    displayFloat();
    exit();
  }
  elseif ($post['fname'] === "" && $post['lname'] === "") {
    setMsg('One of the name fields is required!', 'error');
    displayFloat();
    exit();
  }
  else {
    if ($post['fname'] === "" && $post['lname'] === "" && $post['password'] === "" && $post['email'] === "") {
      setMsg('All fields were empty information hasn\'t changed!', 'error');
      displayFloat();
      exit();
    }
    $Huhu = $post['uniqid'];
    $this->query('SELECT * FROM contacts where uniqid=:uniq');
    $this->bind(':uniq',$Huhu);
    $old = $this->single();
    $id = $_SESSION['user_data']['id'];
    $this->query('UPDATE contacts	SET fname = :fname, lname= :lname, email = :email, address=:address, image=:img	WHERE uniqid =:id');
    if ($_FILES["image"]["error"] == 0) {
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp  = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $explosion = explode('.', $_FILES['image']['name']);
    $file_ext  = strtolower(end($explosion));
    $filenm    = reset($explosion);
    $extensions= array("jpeg","jpg","png");
    if (in_array($file_ext, $extensions) === false) {
      $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
      setMsg('Extension not allowed, please choose a JPEG or PNG file!', 'error');
      displayFloat();
      exit();
    }
    if ($file_size > 2097152) {
      $errors[] = 'File size must be excately 2 MB';
      setMsg('File size must be excately 2 MB!', 'error');
      displayFloat();
      exit();
    }
    if (empty($errors) == true) {
      $bad = array("'", '"', "/", "\\", "<", ">", "!", "@", "#", "$", "%", "^","&", "*", "(",")","+");
      $file_name = str_replace($bad, "", $filenm) . "-" . uniqid() . "." . $file_ext;
      if ($old['image'] !== "default.png") {
        move_uploaded_file($file_tmp, "./Assets/img/userimgs/" . $file_name);
        unlink('./Assets/img/userimgs/' . $old['image']);
        $this->bind(':img', $file_name);
      }
      else{
        move_uploaded_file($file_tmp, "./Assets/img/userimgs/" . $file_name);
        $this->bind(':img', $file_name);
      }
    }
    else {
      setMsg('Something went wrong, please try again later!', 'error');
      displayFloat();
      exit();
    }
  }
  else{
    $this->bind(':img', $old['image']);
  }
      $this->bind(':fname', $post['fname']);
      $this->bind(':lname', $post['lname']);
      $this->bind(':email', $post['email']);
      $this->bind(':address', $post['address']);
      $this->bind(':id', $Huhu);
      $this->execute();
      foreach($post['oldnum'] as $num){
        $this->query('DELETE FROM numbers where pnumber =:num AND cid=:uid');
        $this->bind(':uid',$Huhu);
        $this->bind(':num',$num);
        $this->execute();
      }
      foreach($post['number'] as $n){
        if ($n !== "" || !empty($n)) {
          $this->query('INSERT INTO numbers (pnumber, cid) VALUES(:num, :forge)');
          $this->bind(':forge', $Huhu);
          $this->bind(':num',$n);
          $this->execute();
        }
      }
    }
    return 'success';
  }
  
}
