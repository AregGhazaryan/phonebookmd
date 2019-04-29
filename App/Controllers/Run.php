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

      $filepath = '../config.ini';
      $data = $_POST;
      function update_ini_file($data, $filepath) {
        $content = "";
        $parsed_ini = parse_ini_file($filepath, true);
        foreach($data as $section => $values){
          if ($section === "submit") {
            continue;
          }
          $content .=	$section ."=". $values . "\n";
        }

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
