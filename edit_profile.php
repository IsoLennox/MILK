<?php include("inc/header.php");  

     $query  = "SELECT * FROM users WHERE id={$_SESSION['user_id']}";  
    $result = mysqli_query($connection, $query);
     
    if($result){
        $profile_array=mysqli_fetch_assoc($result);
        $old_content=$profile_array['profile_content'];
        $avatar=$profile_array['avatar'];
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
 
      
    
   // Perform Update BOOK
      
    $update_profile  = "UPDATE users SET ";
    $update_profile .= "profile_content = '{$content}' ";
    $update_profile .= "WHERE id = {$_SESSION['user_id']} ";
    $result = mysqli_query($connection, $update_profile);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
        $_SESSION["message"] = "profile updated.";
        redirect_to("profile.php?");

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
   <section class="left_padding"> 
<form action="upload_profile_img.php" method="post" enctype="multipart/form-data">
    Select New Image:<br/>
    <input type="file" name="image" id="fileToUpload"><br/>
 
    <input type="submit" value="Upload File" name="submit">
</form>
   <?php if($avatar!="http://lorempixel.com/250/250/abstract"){ ?>
    <a href="delete.php?avatar=<?php echo $_SESSION['user_id']; ?>"> <i class="fa fa-trash-o"> Delete Profile Image</i></a>
 <?php } ?>
  </section> 
  <div class="clear"></div>
  <hr/>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <h2>Edit Profile Content</h2>
    <form action="edit_profile.php" method="post">
   
        <p>Profile Content:<br/>
        <textarea cols="100" rows="5" name="content" value="<?php echo htmlentities($content); ?>" ><?php echo htmlentities($old_content); ?></textarea>
      </p>
   
      <input type="submit" name="submit" value="Save" />
    </form>
    <br />
    <a href="profile.php">Cancel</a>
    
    <br/>
    <br/>
    <p>Not what you're looking for? <a href="settings.php">Edit Account Settings</a></p>
 
<?php include("inc/footer.php"); ?> 