<?php $current_page="employees";
include("inc/header.php"); ?>


<h1>Employees</h1>

<?php
            //GET PERMISSIONS FOR THIS PAGE
         foreach($_SESSION['permissions'] as $key => $val){  
             //EDIT EMPLOYEES
            if($val==2){ 
                echo " <a href=\"new_employee.php\"><i class=\"fa fa-user-plus\"></i> New Employee</a> <br/>";
                echo " <a href=\"#\"><i class=\"fa fa-user-times\"></i> View Disabled Accounts</a> ";
                //can remove this upon styling
                echo "<hr/>";
            } 
        }  

 

        if($_GET['edit_role']){
            $emp_id=$_GET['edit_role'];
            echo "Editing employee ".$emp_id;
            //get user role
            $query  = "SELECT * FROM users WHERE is_employee=1";  
            $result = mysqli_query($connection, $query);
            if($result){}
            echo "Current Role: Super User<br/>";
            
            //can remove this upon styling
            echo "<hr/>";
        }

?>

         
          
          <ul> <?php

//GET ALL EMPLOYEES

    $query  = "SELECT * FROM users WHERE is_employee=1";  
    $result = mysqli_query($connection, $query);
    if($result){
        //show each result value
        foreach($result as $show){
           
                $role_query  = "SELECT * FROM roles WHERE id={$show['role']} ORDER BY account_disabled";  
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
                    echo "<a href=\"employees.php?edit_role=".$show['id']."\"><i class=\"fa fa-agent\"></i> Edit Role</a>";
                    echo "<a href=\"employees.php?edit_pass=".$show['id']."\"><i class=\"fa fa-agent\"></i> Change Password</a>"; 
                     echo "change password<br/>";
                    //See if user account is active
                    if($show['account_disabled']=="0"){
                        echo "a href=\"employees.php?disable=1&user=".$show['id']."\"><i class=\"fa fa-times red\"></i>Disable Account</a><br/>";
                    }else{
                        //endable account
                         echo "a href=\"employees.php?disable=0&user=".$show['id']."\"><i class=\"fa fa-check green\"></i>Reactivate Account</a><br/>";
                    }
                    
                } 
            }  
            
            //can remove this upon styling
             echo "<hr/>";
        }
        
    }
 ?>    </ul>


      
        
<?php include("inc/footer.php"); ?>