<?php require_once("inc/session.php"); ?>
<?php require_once("inc/db_connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php require_once("inc/validation_functions.php"); ?>  
<style>
.message{
/*FOR ERRORS*/
    width: 250px;
    margin: 10px;
    padding: 5px;
    color: #eee;
    background: #222;
    border-radius: 5px;

} 
</style>
<?php

//Creating New group and Admin user

  


if (isset($_POST['submit'])) {
  // USER SUBMITTED FORM
  // validations
  $required_fields = array("email","first","last","password", "confirm_password");
  validate_presences($required_fields);
  if (empty($errors) ) {
    // Perform Create
    $email = mysql_prep($_POST["email"]); 
      if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["message"] = "Invalid email";
            redirect_to("new_user.php");
        }else{
            $first = mysql_prep($_POST["first"]);
            $last = mysql_prep($_POST["last"]);

            // $hashed_password = password_encrypt($_POST["password"]);
            $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $first_password = $_POST["password"];
            $confirmed_password = $_POST["confirm_password"];


            if($first_password===$confirmed_password){
                    //check that username entered does not exist

                    $query  = "select * from users WHERE email='{$email}'"; 
                    $user_found = mysqli_query($connection, $query);
                    $user_array= mysqli_fetch_assoc($user_found);

                    if (empty($username_array)){

                    //Username is not taken
                        $query  = "INSERT INTO users (";
                        $query .= " email, first_name, last_name, password";
                        $query .= ") VALUES (";
                        $query .= " '{$email}', '{$first}', '{$last}', '{$hashed_password}'";
                        $query .= ") ";
                        $new_user_created = mysqli_query($connection, $query);


                        if ($new_user_created) { 
                            // Success
                            $_SESSION["message"] = "Account created! Log In."; 
                            redirect_to("login.php");

                        } else {
                            // Failure
                            $_SESSION["message"] = "User Not Created!";

                        }


                    } else {
                    // Failure
                    $_SESSION["message"] = "Username Exists";

                    }

            }//end confirm passwords match
      }//end confirm email format
    }//end confirm no errors in form
} ?> 

<!DOCTYPE html>
<html lang="en">
 <head>
     <meta charset="UTF-8">
     <title>UnderMyRoof - New User</title> 
     <link rel="stylesheet" href="css/style.css">
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
     
     
     
     <script>
    //make sure not empty, live response
       $(document).ready(function () {
    $("#first").blur(function () {
      var username = $(this).val();
      if (username == '') {
        $("#availability").html("");
           $("#f-error input").css({"border": "5px solid #E43633"});
      }else{
          $("#f-error input").css({"border": "1px solid grey"});
      
      } 
    }); 
           
           
    $("#last").blur(function () {
      var username = $(this).val();
      if (username == '') {
        $("#availability").html("");
           $("#l-error input").css({"border": "5px solid #E43633"});
      }else{
          $("#l-error input").css({"border": "1px solid grey"});
      
      } 
    }); 
  });
         
 //check email availability/if empty
       $(document).ready(function () {
    $("#email").blur(function () {
      var email = $(this).val();
      if (email == '') {
        $("#eavailability").html("");
           $("#e-error input").css({"border": "5px solid #E43633"});
      }else{
          $("#e-error input").css({"border": "1px solid grey"});
        $.ajax({
          url: "validation.php?email="+email
        }).done(function( data ) {
          $("#eavailability").html(data);
        });   
      } 
    });
  });
 
 
          //password not empty
       $(document).ready(function () {
    $("#pass").blur(function () {
      var input = $(this).val();
      if (input == '') {
        $("#p1-error input").css({"border": "5px solid #E43633"});
      }else{
        $("#p1-error input").css({"border": "1px solid grey"});
      }
    });
  });
         
         
         
          //confirm_password
       $(document).ready(function () {
    $("#pass2").blur(function () {
      var input = $(this).val();
      if (input == '') {
        $("#p2-error input").css({"border": "5px solid #E43633"});
      }else{
        $("#p2-error input").css({"border": "1px solid grey"});
      }
    });
  });
         
         
         
         
         
          function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pass');
    var pass2 = document.getElementById('pass2');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
    }
}  
         
     
     </script>
 </head>
 
 
<body>    
<div><!--LOGIN CONTAINER--> 


    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>

    <h2>Create New Account</h2> 
    <form action="new_user.php" method="post">
        <p id="e-error">Email (Used to Log In):
        <input type="text" name="email" id="email" value="" /> </p>
        <div id="eavailability"></div>

        <p id="f-error">First: <input type="text" name="first" id="first" value="" /></p>
        <p id="l-error">Last:<input type="text" name="last" id="last" value="" /></p>
        <p id="p1-error">Password:<input type="password" name="password" id="pass" value="" /></p>
        <p id="p2-error">Confirm Password: <input type="password" name="confirm_password" id="pass2" value="" onkeyup="checkPass(); return false;" /></p>
        <span id="confirmMessage" class="confirmMessage"></span><br/>
        <input type="submit" name="submit" value="Continue" />

    </form>
    <br />
    <a href="login.php">Cancel</a>

</div><!--   END LOGIN CONTAINER  -->
        