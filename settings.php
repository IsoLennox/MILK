<?php include("inc/header.php"); ?>
 
 <script>
     //TOGGLE VISIBILITY FORMS
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
</script>
<!--  GET USER INFO-->
            <?php 
    $user_query  = "SELECT * FROM customers WHERE id={$_SESSION['user_id']}";  
    $user_result = mysqli_query($connection, $user_query);
    $num_rows=mysqli_num_rows($user_result);
    if($num_rows >= 1){
        $user_data=mysqli_fetch_assoc($user_result);
        $username=$user_data['username'];
        $email=$user_data['email'];
        $stored_pass=$user_data['password'];
 
    } 


if (isset($_POST['submit'])) {
    
    
  // Process the form
  
/*********************************/  
//USERNAME
/*********************************/ 
    
   if (isset($_GET['username'])) {
  $username = mysql_prep($_POST["username"]);
      if(empty($_POST['username'])){
      //cannot be empty
          $_SESSION["message"] = "Username cannot be empty!";
          redirect_to("settings.php");
      }else{
      //perform update
          
            $update_book  = "UPDATE customers SET ";
            $update_book .= "username = '{$username}' ";
            $update_book .= "WHERE id = {$_SESSION['user_id']} ";
            $result = mysqli_query($connection, $update_book);
            if ($result && mysqli_affected_rows($connection) == 1) {
              // Success
                       $_SESSION["message"] = "Username Saved! Please log out and back in to see changes.";
                        redirect_to("settings.php");
            } else {
              // Failure
                        $_SESSION["message"] = "Username Could Not Be Saved!";
                        redirect_to("settings.php");
            }//END UPDATE ACCOUNT
          
      }
   }
    
/*********************************/ 
//EMAIL
/*********************************/ 
    
    if (isset($_GET['email'])) {
  $email = mysql_prep($_POST["email"]);
        
        //check email format
     
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["message"] = "Invalid email";
            redirect_to("settings.php");
        }else{
            //perform update
    
    $update_book  = "UPDATE customers SET ";
    $update_book .= "email = '{$email}' ";
    $update_book .= "WHERE id = {$_SESSION['user_id']} ";
    $result = mysqli_query($connection, $update_book);
    if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
                $_SESSION["message"] = "Email Updated!";
                redirect_to("settings.php");
    } else {
      // Failure
                $_SESSION["message"] = "Email Update Failed!";
                redirect_to("settings.php");
    }//END UPDATE ACCOUNT
     
        }
    }
    
/*********************************/ 
//PASSWORD
/*********************************/ 
    
    if (isset($_GET['password'])) {
  $old_pass = mysql_prep($_POST["old_pass"]);
        
        
    if (password_verify($old_pass, $stored_pass)){
		
            //old password matched current password
            $hashed_password = password_hash($_POST["new_pass"], PASSWORD_DEFAULT);
            $first_password = $_POST["new_pass"];
            $confirmed_password = $_POST["confirm_pass"];
  
   if(!empty($first_password) && !empty($confirmed_password)){
            if($first_password===$confirmed_password){
                //new passwords match
                //perform update with $hashed_pass
                
    $update_book  = "UPDATE customers SET ";
    $update_book .= "password = '{$hashed_password}' ";
    $update_book .= "WHERE id = {$_SESSION['user_id']} ";
    $result = mysqli_query($connection, $update_book);
    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
                $_SESSION["message"] = "Password Updated!";
                redirect_to("settings.php");
    } else {
      // Failure
                $_SESSION["message"] = "Password Update Failed!";
                redirect_to("settings.php");
    }//END UPDATE ACCOUNT
                


            }else{
                $_SESSION["message"] = "Passwords Do Not Match!";
                redirect_to("settings.php");
            }//end update new password
        
    }else{
       $_SESSION["message"] = "Passwords Cannot be blank!";
                      redirect_to("settings.php");
 
        }  
            }else{
                $_SESSION["message"] = "Old Password Incorrect";
                      redirect_to("settings.php");
            }//end if old password is correct current password
    }//end submit new password


}


?>


    
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
     
     
     
     <script>
 //check username availability/if empty
function checkUname(){
              $("#u-error input").css({"border": "1px solid grey"});
        $.ajax({
          url: "validation.php?uname="+username
        }).success(function( data ) {
          $("#availability").html(data);
        });  
}
         
       $(document).ready(function () {

    $("#username").blur(function () {
      var username = $(this).val();
      if (username == '') {
        $("#availability").html("");
           $("#u-error input").css({"border": "5px solid #E43633"});
      }else{
          $("#u-error input").css({"border": "1px solid grey"});
        $.ajax({
          url: "validation.php?uname="+username
        }).done(function( data ) {
          $("#availability").html(data);
        });   
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
    
   <h4>Settings</h4>
   <div class="center one-third"> 
 
   
   <h3 class="links" onclick="toggle_visibility('new_username');">Change Username</h3> 
   <p>Your public-facing name</p>
    <span id="new_username">
    <form action="settings.php?username" method="POST">
       
         <p id="u-error">New Username:
        <input type="text" name="username" id="username" value="<?php echo $username; ?>" /> 
<!--        user must unfocus input to see if avail or not-->
        <i title="Check availability" class="fa fa-search"></i>
         
      </p>
      <div id="availability"></div> 
      <br/><br/>  <input type="submit" name="submit" value="Save">
    </form>
    </span> 
    
    
    <hr/>
   <h3 class="links" onclick="toggle_visibility('new_email');">Change Email  </h3>
      <p>Used to log in and recover password</p>
       <span id="new_email">
    <form action="settings.php?email" method="POST">
        <p id="e-error">New Email:
        <input type="text" name="email" id="email" value="<?php echo $email; ?>" />  <i title="Check availability" class="fa fa-search"></i></p>
        <div id="eavailability"></div> 
       <br/><br/> <input type="submit" name="submit" value="Save">
    </form>
    </span> 
   
   <hr/>
   
   
   <h3 class="links" onclick="toggle_visibility('new_pass');">Change Password</h3>
          <span id="new_pass"> 
    <form action="settings.php?password" method="POST">
        <p> Old Password:</p> <input type="password" value="" name="old_pass" placeholder="OLD PASSWORD"><br/>
        
              <p id="p1-error">New Password:<br/>
        <input type="password" name="new_pass" id="pass" value="" />
      </p>
        <p id="p2-error">Confirm New Password: 
          <input type="password" name="confirm_pass" id="pass2" value="" onkeyup="checkPass(); return false;" />
        
      </p>
     <span id="confirmMessage" class="confirmMessage"></span>
        
         <br/><input type="submit" name="submit" value="Save">
    </form>
    </span> 
  </div>
    <?php
   
include("inc/footer.php"); ?>