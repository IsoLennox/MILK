<?php include("inc/header.php"); ?>


<h1>Employees</h1>

<?php
                //GET PERMISSIONS FOR THIS PAGE
             foreach($_SESSION['permissions'] as $key => $val){  
                 //EDIT EMPLOYEES
                if($val==2){ 
                    echo " <a href=\"new_employee.php\">New Employee</a> ";
                } 
            }  

?>

         
          
          <ul> <?php

//GET ALL EMPLOYEES

    $query  = "SELECT * FROM users WHERE is_employee=1";  
    $result = mysqli_query($connection, $query);
    if($result){
        //show each result value
        foreach($result as $show){
           
                $role_query  = "SELECT * FROM roles WHERE id={$show['role']}";  
                $roleresult = mysqli_query($connection, $role_query);
                if($roleresult){
                    $role=mysqli_fetch_assoc($roleresult);
                    if(!$role['name']){
                        $role['name']="No Role Set";
                    }
                }
                    
            echo "<li><a href=\"profile.php?user=".$show['id']."\">".$show['first_name']." ".$show['last_name']."</a> ".$role['name']."</li>";
            
                    //GET PERMISSIONS FOR THIS PAGE
             foreach($_SESSION['permissions'] as $key => $val){  
                 //EDIT EMPLOYEES
                if($val==2){ 
                    echo "Edit Employee (Change role / Delete employee)";
                } 
            }  
             
        }
    }
 ?>
     
              
          </ul>

        
      
        
<?php include("inc/footer.php"); ?>