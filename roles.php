<?php include("inc/header.php"); ?>


<h1>Roles</h1> 
 <a href="add_role.php">New Role</a>
         
         
          <p>Employee Roles</p>
<<<<<<< HEAD
<!--
=======
          <p>Your mom is an employee</p>
>>>>>>> fff91253dc9db247996a8eb2c141afad6c77b88d
          <ul>
              <li><a href="#">Super User</a>
              <ul>Permissions:
                  <li>permission</li>
                  <li>permission</li>
                  <li>permission</li>
                  
              </ul>
              <ul>Users with this role:
                  <li>Sally Stone</li>
              </ul>
              <ul>
                  <li><a href="edit_role.php?id=1">Edit This Role</a></li>
              </ul>
              </li>
          </ul>
-->
           <?php

//Get all Roles

    $role_query  = "SELECT * FROM roles";  
    $role_result = mysqli_query($connection, $role_query);
    if($role_result){
        //show each result value
        foreach($result as $role){
            $role_id=$role['id'];
            echo $role['name'];
             
                      
            }
        }
 ?>
     
        
      
        
<?php include("inc/footer.php"); ?>