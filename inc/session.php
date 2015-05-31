<?php

  session_start();
  
  function message() {
    if (isset($_SESSION["message"])) {
      $output = "<div class=\"message\">";
      $output .= htmlentities($_SESSION["message"]);
      $output .= "</div>";
      
      // clear message after use
      $_SESSION["message"] = null;
      
      return $output;
    }
  }

  function errors() {
    if (isset($_SESSION["errors"])) {
      $errors = $_SESSION["errors"];
      
      // clear message after use
      $_SESSION["errors"] = null;
      
      return $errors;
    }
  }
  

  function walkthrough() {
    if (isset($_SESSION["walkthrough"])) {
    $errors = "<div class=\"walkthrough\"><h4>Walkthrough</h4><br/>";
      $errors .= $_SESSION["walkthrough"];
        if ($_SESSION["is_employee"]==0) {
      $errors .= "<br/><br/><a class=\"right\" onclick=\"return confirm('Skip the walkthrough? You can take the walkthrough again any time by going to the help page.');\" href=\"index.php?no-walkthrough\">No, Thanks!</a></div>";
        }else{
             $errors .="</div>";
        }
      // clear message after use
      $_SESSION["walkthrough"] = null;
      
      return $errors;
    }
  }
?>