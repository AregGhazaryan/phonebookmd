<?php
function displaymenu() {
  if (@isset($_SESSION['is_logged_in'])) {
    if (@$_SESSION['is_logged_in'] == true) {
      echo '
      <ul class="navbar-nav nav nav-tabs">
        <div class="dropdown">
          <button class="btn btn-drop nav-link dropdown-toggle active" type="button" data-toggle="dropdown">
            <i class="material-icons">face</i>'.$_SESSION['user_data']['name'].'<span class="caret"></span>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="'.ROOT_PATH.'/phonebook/'.$_SESSION['user_data']['id'].'/index"><i class="material-icons">contact_phone</i>Phonebook</a>
            <a class="dropdown-item" href="'.ROOT_PATH.'/users/'.$_SESSION['user_data']['id'].'/profile"><i class="material-icons">person</i>Profile</a>
            <a class="dropdown-item" href="'.ROOT_PATH.'/home/logout"><i class="material-icons">exit_to_app</i>Logout</a>
          </div>
        </div>
      </ul>';
    }
  }
}

function getNum() {
  $raw = explode("/",$_SERVER['QUERY_STRING']);
  return $raw[1];
}

function userMiddleware($path) {
  if(isset($_SESSION['is_logged_in'])){
    if ($_SESSION['is_logged_in']) {
      exit(header('location: ' . ROOT_PATH . $path));
    }
  }
}

function fileExists(){
   if(!file_exists("../config.ini")){
     setMsg('You Haven\'t Created The Config.ini File','error');
     display();
     return false;
   }else{
     return true;
   }
 }

function isWriteable(){
       $try = is_writable('../config.ini');
       if(!$try){
         setMsg('Config.ini should have write permissions.','error');
         display();
         return false;
       }else{
         return true;
       }
 }

 function isInstalled(){
   if(@filesize('../config.ini') > 0){
     return true;
   }else{
     return false;
   }
 }

 function firstRun(){
   if(@filesize('../config.ini') !== 0){
     $ini_array = @parse_ini_file("../config.ini");
     $reinstall = $ini_array['reinstall'];
     if($reinstall){
       return true;
     }else{
       return false;
     }
   }else{
     return false;
   }
 }

 function reinstall(){
   if(@filesize('../config.ini') !== 0){
     $ini_array = @parse_ini_file("../config.ini");
     $reinstall = $ini_array['reinstall'];
     if($reinstall === '2'){
       return true;
     }else{
       return false;
     }
   }else{
     return false;
   }
 }

 function toggle(){
   $filepath = '../config.ini';
   //after the form submit
   $data = @parse_ini_file("../config.ini");;
   $data['reinstall'] = '1';
   //update ini file, call function
   function update_ini_file($data, $filepath) {
     $content = "";
     //parse the ini file to get the sections
     //parse the ini file using default parse_ini_file() PHP function
     $parsed_ini = parse_ini_file($filepath, true);
     foreach($data as $section => $values){
       if($section === "submit"){
         continue;
       }
       $content .=	$section ."=". $values . "\n";
     }
     //write it into file
     if (!$handle = fopen($filepath, 'w')) {
       return false;
     }
     $success = fwrite($handle, $content);
     fclose($handle);
   }
   update_ini_file($data, $filepath);
 }
