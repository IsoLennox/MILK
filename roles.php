<?php include("inc/header.php"); ?>


<h1>Employee Roles</h1> 
 <a href="add_role.php">New Role</a><br/>
 
         
          
<!--
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
        echo "<ul>";
        foreach($role_result as $role){
            $role_id=$role['id'];
            echo "<li>".$role['name']."</li>"; 
            //Get permissions for this role
                   $permission_query  = "SELECT * FROM roles_permissions";  
                    $permission_result = mysqli_query($connection, $permission_query);
                    if($permission_result){
                        //show each result value
                        echo "<ul>";
                        foreach($permission_result as $permission){
                            $permission_id=$permission['id'];
                            //GET permission name
                                $name_query  = "SELECT * FROM permissions WHERE id={$permission_id}";  
                                $name_result = mysqli_query($connection, $name_query);
                                if($name_result){
                                    //show each result value
                                    foreach($name_result as $name){
                                        echo "<li>".$name['name']."</li>";  
                                        } 
                                } 
                        }
                        echo "</ul>";
                    }
            }
        echo "<a href=\"edit.php?role=".$role_id."\">Edit Role</a><br/>";
    echo "</ul>";
    }
 ?>
     
        
      
        
<?php include("inc/footer.php"); ?>