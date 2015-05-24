<?php require_once("inc/session.php");
require_once("inc/db_connection.php"); 
require_once("inc/functions.php");
require_once("inc/validation_functions.php"); ?>
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
$email = "";

if (isset($_POST['submit'])) {
  // Process the form
  
  // validations: Make sure these fields are not empty
  $required_fields = array("email", "password");
  validate_presences($required_fields);
  
  if (empty($errors)) {
    // Reuired fields not empty, attempt Login based on passed values
		$email = $_POST["email"];
		$password = $_POST["password"];
        //call database to see if email and passowrd combo is in DB
		$found_user = attempt_login($email, $password);

    if ($found_user) {
      // Success : Create session variables
	   $_SESSION["user_id"] = $found_user["id"]; 
	   $_SESSION["username"] = $found_user["first_name"]." ".$found_user["last_name"];  
	   $_SESSION["is_employee"] = $found_user["is_employee"]; 
	   $_SESSION["theme"] = $found_user["theme"]; 
	   $_SESSION["role"] = $found_user["role"]; 
        $perm=array();
        
        //GET PERMISSIONS
            $p_query  = "SELECT * FROM roles_permissions WHERE role_id= {$_SESSION['role']}";
            $p_query_result = mysqli_query($connection, $p_query);
            foreach($p_query_result as $permission){
                array_push($perm, $permission['permission_id']);
            }
			$_SESSION["permissions"]=$perm; 
        
        //get this user info
        $query  = "SELECT * ";
		$query .= "FROM users ";
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
    
    
} 
?>
 <html lang="en">
  <head>
    <title>UnderMyRoof - Login</title>
    <link href="css/style.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Nunito:300,300italic,400,700" rel="stylesheet" type="text/css"> 
  </head>
  <body>
 
 
 <div class="login_wrapper">
      <img src="img/under_my_roof.png" alt="Under My Roof Logo">

      <h2>Comprehensive Protection <br>For the things you treasure</h2> 
<hr>
     <h3>Log In</h3>
     
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
      
        <form id="loginform" action="login.php" method="post">
            <input placeholder="Email" type="text" name="email" value="<?php echo htmlentities($email); ?>" />
            
            <p><input placeholder="Password" type="password" name="password" value="" />
            <a title="Forgot Your Password?" href="forgot_password.php"><i title="Forgot Your Password?" class="fa fa-question-circle"> Forgot Your Password?</i></a></p> 

    
            <input id="loginButton" type="submit" name="submit" value="Log In" /><a href="new_user.php"><!-- <div id="createButton"> -->Create New Account<!-- </div> --></a>
            <div class="clearfix"></div>
        </form>
     
      <div class="milk"><img src="img/milk_logo.png" alt="Powered by MILK apps."></div>  
     </div> 
      
 