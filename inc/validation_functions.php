<?php
$errors = array();

function fieldname_as_text($fieldname) {
  $fieldname = str_replace("_", " ", $fieldname);
  $fieldname = ucfirst($fieldname);
  return $fieldname;
}

// * presence
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty
function has_presence($value) {
  return isset($value) && $value !== "";
}

function validate_presences($required_fields) {
  global $errors;
  foreach($required_fields as $field) {
    $value = trim($_POST[$field]);
    if (!has_presence($value)) {
      $errors[$field] = fieldname_as_text($field) . " can't be blank";
    }
  }
}


function validate_username_unique($prospect_username) {
    global $errors;
    global $connection;
    
    $check_username  = "SELECT * FROM customers WHERE username = '{$prospect_username}'";
    $username_checked = mysqli_query($connection, $check_username);
    
        confirm_query($username_checked);
    return $username_checked;
    
     $username_array=mysqli_fetch_assoc($username_checked);
    
 foreach($username_checked as $field) {
        if (!empty($username_array)) {
       $errors[$field] = "USERNAME TAKEN!";
       // $_SESSION["message"] = "Username Taken!";
        }
    }    
}


function validate_email_unique($required_fields) {
    
 //
}



// * string length
// max length
function has_max_length($value, $max) {
  return strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths) {
  global $errors;
  // Expects an assoc. array
  foreach($fields_with_max_lengths as $field => $max) {
    $value = trim($_POST[$field]);
    if (!has_max_length($value, $max)) {
      $errors[$field] = fieldname_as_text($field) . " is too long";
    }
  }
}

// * inclusion in a set
function has_inclusion_in($value, $set) {
  return in_array($value, $set);
}

?>