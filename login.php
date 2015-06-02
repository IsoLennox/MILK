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
        //check that account is not disabled
        if($found_user['account_disabled']==1){
            $_SESSION["message"] = "Your account has been disabled.";
            redirect_to('login.php');
        }
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
                
                
                //if user has not taken walkthrough, start walkthrough
                if($user['walkthrough_complete']==0 && $_SESSION['is_employee']==0){
                $_SESSION["walkthrough"] = "Welcome To Under My Roof! <br/><strong> Step 1 of 3: First, Please complete your profile!";
                redirect_to("edit_profile.php?walkthrough");
                }elseif($user['walkthrough_complete']==1 && $_SESSION['is_employee']==0){
                $_SESSION["walkthrough"] = "Welcome Back! <br/><strong>Step 2 of 3: Let's add your first room!</strong>";
                redirect_to("rooms.php?walkthrough");
                }elseif($user['walkthrough_complete']==2 && $_SESSION['is_employee']==0){
                $_SESSION["walkthrough"] = "Welcome Back! <br/><strong> Last Step: Let's add your first item!</strong>";
                redirect_to("add_item.php?walkthrough");
                }elseif($user['walkthrough_complete']==0 && $_SESSION['is_employee']==1){
                $_SESSION["walkthrough"] = "Welcome To Under My Roof!  <br/><strong>Step 1 of 4:</strong><br/> First, Please complete your profile!";
                redirect_to("edit_profile.php?walkthrough");
                }elseif($user['walkthrough_complete']==1 && $_SESSION['is_employee']==1){
                $_SESSION["walkthrough"] = "Welcome Back! <br/><strong> Step 2 of 4: Employee Roles</strong><br/>Each Employee or group of employees can be given specific permissions based on their role. The Super User has full permissions.<br/><a class=\"right\" href=\"add_role.php?walkthrough\">NEXT</a>";
                redirect_to("roles.php?walkthrough");
                }elseif($user['walkthrough_complete']==2 && $_SESSION['is_employee']==1){
//                $_SESSION["walkthrough"] = "Welcome Back! <br/><strong> Step 3 of 4: Creating a New Role</strong><br/>Here you can give a role a title, and choose which permissions it will have. <br/><a class=\"right\" href=\"new_employee.php?walkthrough\">NEXT</a></div>";
                redirect_to("add_role.php?walkthrough");
                }elseif($user['walkthrough_complete']==3 && $_SESSION['is_employee']==1){
//                $_SESSION["walkthrough"] = "Welcome Back! <br/><strong> Last Step: Creating an Employee Account</strong><br/>For example, an employee with permissions to edit employees will have the ability to create a new employee. Employees can only be created internally, and will be able to change their email and password after they log in.<br/><a class=\"right\" href=\"employees.php?walkthrough\">NEXT</a></div>";
                redirect_to("new_employee.php?walkthrough");
                }else{
                redirect_to("index.php");
                }
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
      
 