<?php include("inc/header.php"); ?>


<h1>Employees</h1>
 <a href="new_employee.php">New Employee</a> 
         
         
          <p>Employees of Greenwell Bank using UnderMyRoof</p>
          <ul>
                        <?php

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
             
        }
    }
 ?>
     
              
          </ul>

        
      
        
<?php include("inc/footer.php"); ?>