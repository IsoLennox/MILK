<?php include("inc/header.php");  

    $query  = "SELECT * FROM users WHERE id={$_SESSION['user_id']}";  
    $result = mysqli_query($connection, $query);
     
    if($result){
        $profile_array=mysqli_fetch_assoc($result);
        $old_content=$profile_array['profile_content'];
        $avatar=$profile_array['avatar'];
        $first = $profile_array["first_name"];
        $last = $profile_array["last_name"];
        $email = $profile_array["email"];
        $phone = $profile_array["phone"];
        $address = $profile_array["address"];
        $city = $profile_array["city"];
        $state = $profile_array["state"];
        $zip = $profile_array["zip"];
        if(empty($avatar)){
            $avatar="http://lorempixel.com/250/250/abstract";
        }
    }else{
        $old_content="Error retrieving Profile";
        $avatar="http://lorempixel.com/250/250/abstract";
    }
 

if (isset($_POST['submit'])) {
    
    
  // Process the form
  
   
  $content = addslashes(htmlentities($_POST["content"])); 
  $first = addslashes(htmlentities($_POST["first"]));
  $last = addslashes(htmlentities($_POST["last"]));
  $phone = addslashes(htmlentities($_POST["phone"]));
  $address = addslashes(htmlentities($_POST["address"]));
  $city = addslashes(htmlentities($_POST["city"]));
  $state = addslashes(htmlentities($_POST["state"]));
  $zip = addslashes(htmlentities($_POST["zip"]));

    
   // Perform Update BOOK
      
    $update_profile  = "UPDATE users SET ";
    $update_profile .= "profile_content = '{$content}', ";
    $update_profile .= "first_name = '{$first}', ";
    $update_profile .= "last_name = '{$last}', ";
    $update_profile .= "phone = '{$phone}', ";
    $update_profile .= "address = '{$address}', ";
    $update_profile .= "city = '{$city}', ";
    $update_profile .= "state = '{$state}', ";
        if(isset($_POST['walkthrough'])){
        $update_profile .= "walkthrough_complete = 1, ";
    }else{
        $update_profile .= "";
    }

    $update_profile .= "zip = '{$zip}' ";

    $update_profile .= "WHERE id = {$_SESSION['user_id']} ";
    $result = mysqli_query($connection, $update_profile);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
    $_SESSION['username']=$first . " " . $last;    
    if(isset($_POST['walkthrough']) && $_SESSION['is_employee']==0){
         $_SESSION["walkthrough"] = "Profile updated! Step 2 of 3: Next let's add a room!";
        redirect_to("rooms.php?walkthrough");
    }elseif(isset($_POST['walkthrough']) && $_SESSION['is_employee']==1){
         $_SESSION["walkthrough"] = "Profile updated! <br/><strong>Step 2 of 4: Employee Roles</strong><br/>Each Employee or group of employees can be given specific permissions based on their role. The Super User has full permissions.<br/><a class=\"right\" href=\"add_role.php?walkthrough\">NEXT</a></div>";
        redirect_to("roles.php?walkthrough");
         
        
        
    }else{
         $_SESSION["message"] = "profile updated.";
        redirect_to("profile.php");
    }
        
        
       

    } else {
      // Failure
      $_SESSION["message"] = "profile update failed.";
        redirect_to("edit_profile.php?");
        
    }//END UPDATE profile
      

  
} else {
  // This is probably a GET request
     
} // end: if (isset($_POST['submit']))

?>
 
 
    <h2>Edit Profile Image</h2>
    <section class="avatar">
    <img src="<?php echo $avatar; ?>" alt="Current Profile Image" /><br>
    <?php 
    if(!isset($_GET['walkthrough'])){
        if($avatar!="http://lorempixel.com/250/250/abstract"){ ?>
          <a class='large_link' href="delete.php?avatar=<?php echo $_SESSION['user_id']; ?>"> <i class="fa fa-trash-o"></i> Delete Profile Image</a>
 <?php } 
    } ?>
    </section>
   <section class="right"> 
<form action="upload_profile_img.php" method="post" enctype="multipart/form-data">
    <h3>Select New Image:</h3>
    <input type="file" name="image" id="fileToUpload"> 
 
    <input type="submit" value="Save New Image" name="submit">
</form>
   
  </section>
  <div class="clearfix"></div> 
  <hr/>
  
   <h2>Edit Profile Content</h2>
  
    <form action="edit_profile.php" method="post">
   <br>
   <br> 
        

     <section class="left half">
      
        <label for="first">First Name: </label><input type="text" name="first" id="first" value="<?php echo htmlentities($first); ?>" />
        <label for="last">Last Name:</label><input type="text" name="last" id="last" value="<?php echo htmlentities($last); ?>" />
        
         <textarea cols="100" rows="5" name="content" id='content' value="<?php echo htmlentities($content); ?>" ><?php echo htmlentities($old_content); ?></textarea>
      
      
       
    </section>
    <section class="left half">
        <label for="phone">Phone: </label><input type="text" placeholder='(360)800-1234' id='phone' name='phone' value='<?php echo htmlentities($phone); ?>'/>
        <label for="address">Address: </label><input type="text" id='address' name='address' placeholder="1234 Drury Lane" value='<?php echo htmlentities($address); ?>'/>
        <label for="city">City: </label><input type="text" id='city' name='city' placeholder="Vancouver" value='<?php echo htmlentities($city); ?>'/>
        <label for="state">State: </label><input type="text" id='state' name='state' placeholder="WA" value='<?php echo htmlentities($state); ?>'/>
        <label for="zip">Zip: </label><input type="text" id='zip' name='zip' placeholder="55555" value='<?php echo htmlentities($zip); ?>'/>
      
    </section>
        <?php if(isset($_GET['walkthrough'])){ ?> <input type="hidden" name='walkthrough' value='1'/> <?php }  ?>
        <input type="submit" name="submit" value="Save Profile Content" /> 
        <?php if(!isset($_GET['walkthrough'])){ ?> <a href="profile.php">Cancel</a> <?php }  ?>
    </form>
  <hr/>
  <?php
      
/*********************************/ 
//EMAIL
/*********************************/ 
    
    if (isset($_GET['email'])) {
  $email = mysql_prep($_POST["email"]);
        
        //check email format
     
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["message"] = "Invalid email";
            redirect_to("edit_profile.php");
        }else{
            //perform update
    
    $update_book  = "UPDATE users SET ";
    $update_book .= "email = '{$email}' ";
    $update_book .= "WHERE id = {$_SESSION['user_id']} ";
    $result = mysqli_query($connection, $update_book);
    if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
                $_SESSION["message"] = "Email Updated!";
                redirect_to("edit_profile.php");
    } else {
      // Failure
                $_SESSION["message"] = "Email Update Failed!";
                redirect_to("edit_profile.php");
    }//END UPDATE ACCOUNT
     
        }
    }
 ?>


    
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
     
     
     
     <script>
 //check username availability/if empty
 
         
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
         
 //check email availability/if empty 
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
     
<h1 id="settings">Account Settings</h1>
  <section class="left half">
     
   <h2>Change Email  </h2>
      <p>Used to log in and recover password</p>
       <span id="new_email">
    <form action="edit_profile.php?email" method="POST">
        <p id="e-error">New Email:
        <input type="text" name="email" id="email" value="<?php echo $email; ?>" /></p>
        <div id="eavailability"></div> 
       <br/><br/> <input type="submit" name="submit" value="Save Email">
    </form>
    </span> 
   
</section>
   
    <section class="left half"> 
   <h2>Change Password</h2>
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
        
         <br/><input type="submit" name="submit" value="Save Password">
    </form>
    </span> 
  </div>

</section>
 
<?php include("inc/footer.php"); ?> 