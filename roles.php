<?php include("inc/header.php"); ?>


<h1>Employee Roles</h1> 
<?php
//SEE IF THIS USER HAS EDIT ROLE PERMISSIONS
     foreach($_SESSION['permissions'] as $key => $val){ 
         echo $val;
        if($val==3){
            $permission=1; 
        }else{
            $permission=0;
        }
    }


//REDIRECT IF NO PERMISSIONS TO VIEW THIS PAGE
if($permission==1){ ?>
 <a href="add_role.php">New Role</a><br/>
 
<?php }

//Get all Roles

    $role_query  = "SELECT * FROM roles";  
    $role_result = mysqli_query($connection, $role_query);
    if($role_result){
        //show each result value
        echo "<ul>";
        foreach($role_result as $role){
            $role_id=$role['id'];
            echo "<li><strong>".$role['name']."</strong></li>"; 
            //Get permissions for this role
                   $permission_query  = "SELECT * FROM roles_permissions WHERE role_id={$role['id']}";  
                    $permission_result = mysqli_query($connection, $permission_query);
                    if($permission_result){
                        //show each result value
                        echo "<ul>";
                        foreach($permission_result as $permission){
                            $permission_id=$permission['permission_id'];
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
            if($permission==1){ echo "<a href=\"edit.php?role=".$role_id."\">Edit Role</a><br/>"; }
             echo "<br/>";
            }//end echo roles
       
    echo "</ul>";
    }//end call roles table
 ?>
     
        
      
        
<?php include("inc/footer.php"); ?>