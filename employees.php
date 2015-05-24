<?php $current_page="employees";
include("inc/header.php"); ?>


<h1>Employees</h1>

<?php
            //GET PERMISSIONS FOR THIS PAGE
         foreach($_SESSION['permissions'] as $key => $val){  
             //EDIT EMPLOYEES
            if($val==2){ 
                echo " <a href=\"new_employee.php\"><i class=\"fa fa-user-plus\"></i> New Employee</a> <br/>"; 
                //can remove this upon styling
                echo "<hr/>";
            } 
        }  

         if(isset($_POST['submit'])){

                // SUBMIT RESET PASSWORD FORM

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
                        $_SESSION["message"] = "Account Updated.";
                        redirect_to("employees.php");
                        } else {
                        // Failure
                        $_SESSION["message"] = "Account update failed."; 
                        } 
                    }elseif($first_password!==$confirmed_password){
                        $_SESSION["message"] = "Passwords Do Not Match!";
                    }
                        }//end confirm no errors in form
                } //end submit password reset

        if(isset($_GET['edit_role'])){
            $emp_id=$_GET['edit_role'];
            
            $user_data=find_user_by_id($emp_id); 
            echo "Editing employee ".$user_data['first_name']." ".$user_data['last_name']."<br/>";
                $role_query  = "SELECT * FROM roles WHERE id={$user_data['role']} ";  
                $roleresult = mysqli_query($connection, $role_query);
                if($roleresult){
                    $role=mysqli_fetch_assoc($roleresult);
                    if(!$role['name']){
                        $role['name']="No Role Set";
                    }
                }
            echo "Current Role: ".$role['name']."<br/>"; 
            echo "New Role: <br/>"; ?>
            
            <form method="POST" action="employees.php?submit_role=<?php echo $emp_id; ?>">      
                <select name="role" id="role">
                <?php
                $role_query  = "SELECT * FROM roles";  
                $role_result = mysqli_query($connection, $role_query);
                if($role_result){
                    //show each result value 
                    foreach($role_result as $role){ 
                        echo "<option value=\"".$role['id']."\">".$role['name']."</option>"; 
                    }
                }  ?>

                </select>
                <input type="submit" name="submit_role" value="Save Role">
            </form>
            
            <?php
            echo "<hr/>";
        }




         if(isset($_GET['submit_role'])){ 
             $user_id=$_GET['submit_role'];
             $role=$_POST['role'];
               $query  = "UPDATE users SET ";
                $query .= "role = {$role} ";
                $query .= "WHERE id = {$user_id} "; 
                $result = mysqli_query($connection, $query); 
                if ($result && mysqli_affected_rows($connection) == 1) { 
                    $_SESSION["message"] = "Account Updated.";
                    redirect_to("employees.php");
                } else {  $_SESSION["message"] = "Account update failed.";  } 
         }




        if(isset($_GET['edit_pass'])){
            $user_id=$_GET['edit_pass'];  
            $user_data=find_user_by_id($emp_id);  
                $ID=$user_data['id'];
                $username=$user_data['username'];
                $email=$user_data['email'];
             
             ?> 
            <h2>Reset <?php echo $user_data['first_name']." ".$user_data['last_name']; ?>'s Password</h2>
            <form action="reset_password.php?user_id=<?php echo $user_id; ?>&token=<?php echo $token; ?>" method="post">
            <p>Password reset for login:<?php echo $username; ?></p>
            <p><?php echo $email; ?></p>
              <p>New Password:
                <input type="password" name="password" value="" />
              </p>
                <p>Confirm Password:
                <input type="password" name="confirm_password" value="" />
              </p>
              <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
              <input type="submit" name="submit" value="Update User" />
            </form> 
            <?php
           }


        if(isset($_GET['disable'])){
            $user_id=$_GET['user']; 
               $query  = "UPDATE users SET ";
                $query .= "account_disabled = {$_GET['disable']} ";
                $query .= "WHERE id = {$user_id} "; 
                $result = mysqli_query($connection, $query); 
                if ($result && mysqli_affected_rows($connection) == 1) { 
                    $_SESSION["message"] = "Account Updated.";
                    redirect_to("employees.php");
                } else {  $_SESSION["message"] = "Account update failed.";  }
         
        }

?>

         
          
          <ul> <?php

//GET ALL EMPLOYEES

    $query  = "SELECT * FROM users WHERE is_employee=1 ORDER BY account_disabled ASC, first_name ASC, last_name ASC";  
    $result = mysqli_query($connection, $query);
    if($result){
        //show each result value
        foreach($result as $show){
           
                $role_query  = "SELECT * FROM roles WHERE id={$show['role']} ";  
                $roleresult = mysqli_query($connection, $role_query);
                if($roleresult){
                    $role=mysqli_fetch_assoc($roleresult);
                    if(!$role['name']){
                        $role['name']="No Role Set";
                    }
                }
                    
            echo "<li><a href=\"profile.php?user=".$show['id']."\"><i class=\"fa fa-user\"></i> ".$show['first_name']." ".$show['last_name']."</a> ".$role['name']."</li>"; 
            
                    //GET PERMISSIONS FOR THIS PAGE
             foreach($_SESSION['permissions'] as $key => $val){  
                 //EDIT EMPLOYEES
                if($val==2){ 
                    echo "<a href=\"employees.php?edit_role=".$show['id']."\"><i class=\"fa fa-user-secret\"></i> Edit Role </a>";
                    echo "<a href=\"employees.php?edit_pass=".$show['id']."\"><i class=\"fa fa-unlock-alt\"></i> Change Password </a>"; 
                    
                    //See if user account is active
                    if($show['account_disabled']=="0"){
                        echo "<a class=\"right \" href=\"employees.php?disable=1&user=".$show['id']."\"><i class=\"fa fa-times red\"></i>Disable Account</a>";
                    }else{
                        //endable account
                         echo "<a class=\"right \" href=\"employees.php?disable=0&user=".$show['id']."\"><i class=\"fa fa-check green\"></i>Reactivate Account</a>";
                    }
                    
                } 
            }  
            
            //can remove this upon styling
             echo "<hr/>";
        }
        
    }
 ?>    </ul>


      
        
<?php include("inc/footer.php"); ?>