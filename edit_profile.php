<?php include("inc/header.php");
    ?> <script src="js/profile_pic.js"></script> <?php

    $query  = "SELECT * FROM users WHERE id={$_SESSION['user_id']}";  
    $result = mysqli_query($connection, $query);
     
    if($result){
        $profile_array=mysqli_fetch_assoc($result);
        $old_content=$profile_array['profile_content'];
        $avatar=$profile_array['avatar'];
        $first = $profile_array["first_name"];
        $last = $profile_array["last_name"];
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
    <section class="left">
    <img class="resize-image" src="<?php echo $avatar; ?>" alt="Current Profile Image" />
    </section>
   <section class="right"> 
<form action="upload_profile_img.php" method="post" enctype="multipart/form-data">
    <h3>Select New Image:</h3>
    <input type="file" name="image" id="fileToUpload"><br/>
 
    <input type="submit" value="Upload File" name="submit">
</form>
   <?php 
    if(!isset($_GET['walkthrough'])){
        if($avatar!="http://lorempixel.com/250/250/abstract"){ ?>
    <a href="delete.php?avatar=<?php echo $_SESSION['user_id']; ?>"> <i class="fa fa-trash-o"></i> Delete Profile Image</a>
 <?php } 
    } ?>
  </section>
  <div class="clearfix"></div> 
  <hr/>
  
   <h2>Edit Profile Content</h2>
    <form action="edit_profile.php" method="post">
   
        <label for="content">Profile Content:</label><br/>
        <textarea cols="100" rows="5" name="content" id='content' value="<?php echo htmlentities($content); ?>" ><?php echo htmlentities($old_content); ?></textarea><br>
      
        <label for="first">First Name: </label><input type="text" name="first" id="first" value="<?php echo htmlentities($first); ?>" />
        <label for="last">Last Name:</label><input type="text" name="last" id="last" value="<?php echo htmlentities($last); ?>" />
        <label for="phone">Phone: </label><input type="text" placeholder='(360)800-1234' id='phone' name='phone' value='<?php echo htmlentities($phone); ?>'/>
        <label for="address">Address: </label><input type="text" id='address' name='address' placeholder="1234 Drury Lane" value='<?php echo htmlentities($address); ?>'/>
        <label for="city">City: </label><input type="text" id='city' name='city' placeholder="Vancouver" value='<?php echo htmlentities($city); ?>'/>
        <label for="state">State: </label><input type="text" id='state' name='state' placeholder="WA" value='<?php echo htmlentities($state); ?>'/>
        <label for="zip">Zip: </label><input type="text" id='zip' name='zip' placeholder="55555" value='<?php echo htmlentities($zip); ?>'/>
       <?php if(isset($_GET['walkthrough'])){ ?> <input type="hidden" name='walkthrough' value='1'/> <?php }  ?>
      <input type="submit" name="submit" value="Save" /> 
       <?php if(!isset($_GET['walkthrough'])){ ?> <a href="profile.php">Cancel</a> <?php }  ?>
    </form>
  <hr/>

<?php
  if(!isset($_GET['walkthrough'])){ ?>
   
    <p>Not what you're looking for?<br> <a href="settings.php">Edit Account Settings</a></p>
    
    <?php } ?>
    
<?php include("inc/footer.php"); ?> 