<?php require_once("inc/session.php");
require_once("inc/db_connection.php"); 
require_once("inc/functions.php");
require_once("inc/validation_functions.php"); ?>

<?php
$email = "";

if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("email", "password");
  validate_presences($required_fields);
  
  if (empty($errors)) {
    // Attempt Login

		$email = $_POST["email"];
		$password = $_POST["password"];
      
		 
		$found_user = attempt_login($email, $password);

    if ($found_user) {
      // Success : Create session varabes
	   $_SESSION["user_id"] = $found_user["id"]; 
	   $_SESSION["username"] = $found_user["username"]; 
	   $_SESSION["is_employee"] = $found_user["is_employee"]; 
			 
        
        //get this user info
        $query  = "SELECT * ";
		$query .= "FROM customers ";
		$query .= "WHERE id={$found_user["id"]} LIMIT 1"; 
		$all_users = mysqli_query($connection, $query); 
        $array= mysqli_fetch_assoc($all_users);
        
        
        if($all_users){
       
    foreach($all_users as $user){
        //user found, redirect 
        redirect_to("index.php");
    }
            
        }else{
            //query did not find result
        $_SESSION["message"] = "User not found.";
        }//end find user ID
  
        
    } else {
      // Failure to find user in attempt_login()
      $_SESSION["message"] = "email/password not found.";
    }
  }
    
    
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>
 <html lang="en">
  <head>
    <title>Basic Login</title>
    <link href="css/style.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    
      <style>
          body, li, {
          color: #666;
          }
.message, .error{

    width: 250px;
    margin: 10px;
    padding: 5px;
    color: #eee;
    border-radius: 5px;
    background: #666;
    

} 
          
#create{
    margin: 0 auto;
    margin-top:50px;
    width: 300px;
    padding: 20px;
    background: ivory;
    border-radius: 5px; 
    }
</style>
  </head>
  <body>
 
 
 <div id="create">
   <h2>Basic Login</h2>
     <p>A simple login and register profile creator.</p>
     
         <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
      
    <form id="loginform" action="login.php" method="post">
      <p><input placeholder="EMAIL" type="text" name="email" value="<?php echo htmlentities($email); ?>" />
      </p>
      <p><input placeholder="PASSWORD" type="password" name="password" value="" />
      <a href="forgot_password.php"><i title="Forgot Your Password?" class="fa fa-question-circle"></i></a>
      </p>
      <input id="loginButton" type="submit" name="submit" value="Log In" /><br/>
      <br />
        <a href="new_user.php"><div id="createButton">Create New Account</div></a>
        
    </form>
     </div> 
       
         
      
      <!--
    ********** IF ANY PROBLEMS WITH PASSWORDS:

        <a href="reset_password.php">Reset Password</a>

-->
  