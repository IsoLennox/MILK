<?php require_once("inc/session.php"); ?>
<?php require_once("inc/db_connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php require_once("inc/validation_functions.php"); ?>  
<style>
    #page{background:white;}
    .message{

    width: 250px;
    margin: 10px;
    padding: 5px;
    color: #eee;
    border-radius: 5px;

}
</style>
<?php

 


if (isset($_POST['submit'])) {
     
  // Process the form
  
  // validations
  $required_fields = array("password", "confirm_password");
  validate_presences($required_fields);
  

    
    
  if (empty($errors) ) {
    // Perform Create
 
    $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $first_password = $_POST["password"];
    $confirmed_password = $_POST["confirm_password"];
    $ID = $_POST["user_id"];
      
   if($first_password===$confirmed_password){
      
 
    
  
          // Perform Update

    $query  = "UPDATE users SET ";
    $query .= "password = '{$hashed_password}' ";
    $query .= "WHERE id = {$ID} "; 
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
        
       
        
      $_SESSION["message"] = "Account Updated. Please Log In.";
      redirect_to("login.php?");
    } else {
      // Failure
      $_SESSION["message"] = "Account update failed.";
        
    }
  
 
  }elseif($first_password!==$confirmed_password){
   $_SESSION["message"] = "Passwords Do Not Match!";
   }
    }//end confirm no errors in form
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?> 

<?php 


    $user_id=$_GET['user_id']; 
    $token=$_GET['token']; 
     
         $find_user .= "SELECT * FROM users WHERE id = {$user_id} "; 
    $found = mysqli_query($connection, $find_user);
    if($found){
        $found_array=mysqli_fetch_assoc($found);
        $ID=$found_array['id'];
        $username=$found_array['username'];
        $email=$found_array['email'];

         }
     
     ?>
     
     <?php  //CHEC TIME SINCE RESET EMAIL WAS SENT


$time = $token;
 
    $time = time() - $time; // to get the time since that moment
if($time<60){
//    echo "this was less than a minute ago!";

}

if($time<3600){
//    echo "this was less than an Hour ago!";

}

if($time>60){
//    echo "this was more than a minute ago!";

}
 // INCREMENTS OF SECONDS == TIME ELAPSED:
//        31536000 => 'year',
//        2592000 => 'month',
//        604800 => 'week',
//        86400 => 'day',
//        3600 => 'hour',
//        60 => 'minute',
//        1 => 'second'



 
?> 



<!DOCTYPE html>
<html lang="en">
 <head>
     <meta charset="UTF-8">
     <title>Bookshelf</title> 
     <link rel="stylesheet" href="css/style.css">
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 </head>
 <body> 

   <div id="page">
    <?php 
        echo message();
        echo form_errors($errors); 
           
           
           //Let Email only last an hour:
if($time<3600){
    
       ?>
    
    <h2>Reset Password</h2>
    <form action="reset_password.php?user_id=<?php echo $user_id; ?>&token=<?php echo $token; ?>" method="post">
 
        
    <p>Password reset for <?php echo $username; ?></p>
    <p><?php echo $email; ?></p>
 
      <p>New Password:
        <input type="password" name="password" value="" />
      </p>
        <p>Confirm Password:
        <input type="password" name="confirm_password" value="" />
      </p>
       
     <br/>
     <br/>
      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
      <input type="submit" name="submit" value="Update User" />
    </form>
    <br/>
    <br/>
    <a href="settings.php">Cancel</a>
    <br /> 
     <?php 

}else{
 
     $_SESSION["message"] = "Password Reset Link Expired!";
      redirect_to("login.php");

} 
           
           ?>
  </div>
