<?php include("inc/header.php");  

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
  
   
  $content = mysql_prep($_POST["content"]); 
  $first = ($_POST["first"]);
  $last = ($_POST["last"]);
  $phone = ($_POST["phone"]);
  $address = ($_POST["address"]);
  $city = ($_POST["city"]);
  $state = ($_POST["state"]);
  $zip = ($_POST["zip"]);

    
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
        
    if(isset($_POST['walkthrough'])){
         $_SESSION["walkthrough"] = "Profile updated! Next let's add a room!";
        redirect_to("rooms.php?walkthrough");
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
    <img src="<?php echo $avatar; ?>" alt="Current Profile Image" />
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
    <a href="delete.php?avatar=<?php echo $_SESSION['user_id']; ?>"> <i class="fa fa-trash-o"> Delete Profile Image</i></a>
 <?php } 
    } ?>
  </section>
  <div class="clearfix"></div> 
  <hr/>
  
   <h2>Edit Profile Content</h2>
    <form action="edit_profile.php" method="post">
   
        <label for="content">Profile Content:</label><br/>
        <textarea cols="100" rows="5" name="content" id='content' value="<?php echo htmlentities($content); ?>" ><?php echo htmlentities($old_content); ?></textarea>
      
        <label for="first">First Name: </label><input type="text" name="first" id="first" value="<?php echo htmlentities($first); ?>" />
        <label for="last">Last Name:</label><input type="text" name="last" id="last" value="<?php echo htmlentities($last); ?>" />
        <label for="phone">Phone: </label><input type="text" placeholder='(360)800-1234' id='phone' name='phone'value='<?php echo htmlentities($phone); ?>'/>
        <label for="address">Address: </label><input type="text" id='address' name='address'value='<?php echo htmlentities($address); ?>'/>
        <label for="city">City: </label><input type="text" id='city' name='city'value='<?php echo htmlentities($city); ?>'/>
        <label for="state">State: </label><input type="text" id='state' name='state'value='<?php echo htmlentities($state); ?>'/>
        <label for="zip">Zip: </label><input type="text" id='zip' name='zip'value='<?php echo htmlentities($zip); ?>'/>
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