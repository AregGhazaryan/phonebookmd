<?php

namespace Core;

class View
{

  public static function render($view, $fullview, $data)
  {
    $file = "../App/Views/$view";
    $msg = "../App/Views/messages.php";
    if ($fullview) {
      require('../App/Views/main.php');
      return $data;
    } else {
      require($file);
      return $data;
    }
  }

}
