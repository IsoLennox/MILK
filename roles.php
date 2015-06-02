<?php $current_page="roles";
include("inc/header.php");  


//GET PERMISSIONS
     foreach($_SESSION['permissions'] as $key => $val){ 
         //UPDATE ROLES
        if($val==3){ 
            $roles=1; 
        } 
    }
    if($roles!==1){ redirect_to('index.php'); }

 if(isset($_GET['walkthrough'])){
      if(isset($_GET['success'])){
       echo "<span class=\"walkthrough\"><h4>Walkthrough</h4><br/><strong>New Role Created!</strong><br/>Great Job! As you can see you can edit this role at any time. Last Step: Creating Empoyee Accounts... <br/><a class=\"right\" href=\"new_employee.php?walkthrough\">NEXT</a></span>";
      }else{
     
  $update_walkthrough  = "UPDATE users SET walkthrough_complete=1 WHERE id={$_SESSION['user_id']} ";  
    $walkthrough_updated = mysqli_query($connection, $update_walkthrough); 
      }
      
 }
?>
 <span class="stats">
<h1>Employee Roles</h1> 
 
 
 

 <a href="add_role.php" class='large_link'><i class="fa fa-plus-circle"></i> New Role</a><br/>
  
 <hr>
 <?php



//EDIT ROLE

 if(isset($_GET['role'])){ 
    $role_query  = "SELECT * FROM roles WHERE id={$_GET['role']}";  
    $role_result = mysqli_query($connection, $role_query);
    if($role_result){
        $role=mysqli_fetch_assoc($role_result);
    }
     echo "<h3>Editing: ".$role['name']." </h3>";
     ?>
     
<form action="roles.php?save_role" method="POST">
    <label for="name">Name: </label><input type="text" name="name" id="name" value="<?php echo $role['name']; ?>" > <br/>
    <p>Permissions:</p>
               <?php

// Get permissions for roles

   $query  = "SELECT * FROM permissions";  
   $result = mysqli_query($connection, $query);
   if($result){
       echo "<br/>";
       //show each result value
       foreach($result as $show){
           
           
           //SEE IF THIS ROLE HAS THESE PERMISSIONS 
           $perm_query  = "SELECT * FROM roles_permissions WHERE role_id={$_GET['role']} AND permission_id={$show['id']}";  
           $presult = mysqli_query($connection, $perm_query);
           $num_rows=mysqli_num_rows($presult);
           if($num_rows>=1){
            $checked="checked";
           }else{
            $checked="";
           }
           
           $permission_id = $show['id'];
           $permission_name = $show['name']; 
           //put each permission in a check box
           echo "<input ".$checked." type=\"checkbox\" name=\"permission[]\" value=\"".$permission_id."\" id=\"" . $permission_id . "\" ><label for=\"" . $permission_id . "\">".$permission_name."</label><br/>"; 
                     
           }//end loop through permissions
       }//end call all site permissions
 ?>
       <input type="hidden" name="role_id" value="<?php echo $_GET['role']; ?>">
        <input type="submit" name="save_role" id="submit" value="Save Role">
</form>

 <?php
 }//end edit role





//Get all Roles

    $role_query  = "SELECT * FROM roles";  
    $role_result = mysqli_query($connection, $role_query);
    if($role_result){
        //show each result value
        echo "<div class='left'><ul>";
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
            if($role_id!=="1"){
                 if(!isset($_GET['role'])){
                echo "<a href=\"roles.php?role=".$role_id."\"><i class=\"fa fa-pencil\"></i>  Edit Role</a><br/>"; 
                 }
            }
             echo "<br/>";
            }//end echo roles
       
    echo "</ul>";
    }//end call roles table







//SAVE ROLE 

if(isset($_GET['save_role'])){
    $role_id=$_POST['role_id'];
    $name=$_POST['name'];
    $permissions_array=$_POST['permission'];
 
    
 
    // Success 
        
    //remove all from roles_permissions where role_id=this
    
        $remove_query  = "DELETE FROM roles_permissions WHERE role_id={$role_id}";  
        $remove_result = mysqli_query($connection, $remove_query);
        if($remove_result){
            //insert new for each role submitted
            //EXPLODE permissions ARRAY: FOREACH, INSERT INTO permissions_roles TABLE    
            for ($i = 0; $i < count($permissions_array); $i++) {  
                $insert_permission_query  = "INSERT INTO roles_permissions (permission_id, role_id) VALUES ('{$permissions_array[$i]}', '{$role_id}')";
                $insert_permission_query_result = mysqli_query($connection, $insert_permission_query);
            }//end insert roles/permissions int ojoint table  
            
                $update_role  = "UPDATE roles SET name = '{$name}' ";
                $update_role .= "WHERE id = {$role_id} ";
                $result = mysqli_query($connection, $update_role);

                if ($result) {

                $_SESSION["message"] = "Role Updated!";
                redirect_to('roles.php');

                } else {
                // Failure
                $_SESSION["message"] = "Could not update role";
                redirect_to('roles.php');

                }//END UPDATE profile
            
            
        }else{
            echo "Name changed, could not update permissions";
        }//end remove old permissions


    

    
    
    
    //insert into history table
    
 
      
    
    
 }
    

 ?>
</span>
        
      
        
<?php include("inc/footer.php"); ?>