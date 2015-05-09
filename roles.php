<?php include("inc/header.php"); ?>


<h1>Employee Roles</h1> 
 <a href="add_role.php">New Role</a><br/>
 
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
                                }//end echo permission name
                        }//end get permissions
                        echo "</ul>";
                    }//end get permissions from joint table
            }//end echo roles
        echo "<a href=\"edit.php?role=".$role_id."\">Edit Role</a><br/>";
    echo "</ul>";
    }//end call roles table
 ?>
     
        
      
        
<?php include("inc/footer.php"); ?>