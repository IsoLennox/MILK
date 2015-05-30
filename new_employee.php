<?php $page = "Create A New Employee";
include("inc/header.php"); ?>
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
  if(isset($_GET['walkthrough'])){ 
     $update_walkthrough  = "UPDATE users SET walkthrough_complete=3 WHERE id={$_SESSION['user_id']} ";  
    $walkthrough_updated = mysqli_query($connection, $update_walkthrough);
  
     echo "<div class=\"walkthrough\"><h4>Walkthrough</h4><br/><strong>Last Step: Creating an Employee Account</strong><br/>An employee with permissions to edit employees will have the ability to create a new employee. Employees can only be created internally, and will be able to change their email and password after they log in. <br/><a class=\"right\" href=\"index.php?walkthrough\">Got It!</a></div>";
       
      
 }

//Creating New Employee
if (isset($_POST['submit'])) {
    
     
  // Process the form
  
  // validations
  $required_fields = array("email","first", "last","password", "confirm_password");
  validate_presences($required_fields);
  
 
  if (empty($errors) ) {
    // Perform Create

      
    $email = mysql_prep($_POST["email"]); 
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

            $_SESSION["message"] = "Invalid email";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }else{
            $first = mysql_prep($_POST["first"]);
            $last = mysql_prep($_POST["last"]);


            // $hashed_password = password_encrypt($_POST["password"]);
            $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $first_password = $_POST["password"];
            $confirmed_password = $_POST["confirm_password"];
            $role = $_POST["role"];


            if($first_password===$confirmed_password){

                //check that unique email entered does not exist

                $query  = "select * from users WHERE email='{$email}'"; 
                $user_found = mysqli_query($connection, $query);
                $user_array= mysqli_fetch_assoc($user_found);

                if (empty($user_array)){

                    //Email is not taken
                    $query  = "INSERT INTO users (";
                    $query .= " email, first_name, last_name, password, is_employee, role";
                    $query .= ") VALUES (";
                    $query .= " '{$email}', '{$first}', '{$last}', '{$hashed_password}', 1, {$role}";
                    $query .= ") ";
                    $new_user_created = mysqli_query($connection, $query);


                    if ($new_user_created) { 
                        // Success
                        $_SESSION["message"] = "Account for ".$first." ".$last." created!"; 
                        redirect_to("employees.php");

                    } else {
                        // Failure
                        $_SESSION["message"] = "User Not Created!";
                        header('Location: ' . $_SERVER['HTTP_REFERER']);

                    }
                } else {
                    // Failure
                    $_SESSION["message"] = "User with that email Exists";
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
    
            }//end confirm passwords match
      }//end confirm email format
    }//end confirm no errors in form
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>  

<!DOCTYPE html>
<html lang="en">
 
     
     <script>
 //check if empty
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
  
          
  <div id="create"> 
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
<!--    <h2>Create New Employee</h2> -->
      
    <form action="new_employee.php" method="post">

        <p id="e-error">Email (Log In/Recover password):
            <input type="text" name="email" id="email" value="" /> </p> 
            <div id="eavailability"></div>

        <p id="f-error">First:
            <input type="text" name="first" id="first" value="" /> </p>

        <p id="l-error">Last:
            <input type="text" name="last" id="last" value="" /> </p>

        <p>Role:
            <select name="role" id="role">
            <?php
    $role_query  = "SELECT * FROM roles";  
    $role_result = mysqli_query($connection, $role_query);
    if($role_result){
        //show each result value 
        foreach($role_result as $role){ 
            echo "<option value=\"".$role['id']."\">".$role['name']."</option>"; 
        }
    }
                ?>
         
            </select> 
            </p>

        <p id="p1-error">Temporary Password:
            <input type="password" name="password" id="pass" value="" /></p>

        <p id="p2-error">Confirm Password: 
            <input type="password" name="confirm_password" id="pass2" value="" onkeyup="checkPass(); return false;" /> </p>
            <span id="confirmMessage" class="confirmMessage"></span>

        <br/> 
        <input type="submit" name="submit" value="Continue" />

    </form>
    <br />
    <a href="employees.php">Cancel</a>

   
      
       </div>
        