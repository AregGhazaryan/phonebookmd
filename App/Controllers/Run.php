<?php

namespace App\Controllers;

use \Core\View;

class Run extends \Core\Controller
{
  public function indexAction() {
    View::render('run.php',false, false);
    if (isset($_POST['submit'])) {
      if (empty($_POST['dbhost']) || empty($_POST['dbname']) || empty($_POST['dbuname'])) {
        setMsg('Only password field can be empty', "error");
        exit();
      }
      //put the file path here
      $filepath = '../config.ini';
      //after the form submit
      $data = $_POST;
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
      header('location: '.ROOT_PATH.'/');
    }
  }
}
