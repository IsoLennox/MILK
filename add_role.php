<?php $current_page="roles";
include("inc/header.php"); ?>
<?php
 
//SEE IF THIS USER HAS EDIT ROLE PERMISSIONS
     foreach($_SESSION['permissions'] as $key => $val){ 
        if($val==3){
            $permission=1; 
        }else{
            $permission=0;
        }
    }


//REDIRECT IF NO PERMISSIONS TO VIEW THIS PAGE
//if($permission!==1){
//    redirect_to('index.php');
//}else{ 

 if(isset($_GET['walkthrough'])){
  $update_walkthrough  = "UPDATE users SET walkthrough_complete=2 WHERE id={$_SESSION['user_id']} ";  
    $walkthrough_updated = mysqli_query($connection, $update_walkthrough);
     
     echo "<div class=\"walkthrough\"><h4>Walkthrough</h4><br/><strong>Step 3 of 4: Creating a New Role</strong><br/>Here you can give a role a title, and choose which permissions it will have. <br/><a class=\"right\" href=\"new_employee.php?walkthrough\">NEXT</a></div>";
      
 }
                 
?>
<h1>New Role</h1> 
 
<?php
if (isset($_POST['submit'])) {
    $name= $_POST['name'];
    $permissions_array= $_POST['permission'];
    
    
        //INSERT ALL DATA EXCEPT PERMISSIONS
    $insert  = "INSERT INTO roles ( name ) VALUES ( '{$name}' ) ";
    $insert_result = mysqli_query($connection, $insert);
    if($insert_result){
    
            //GET ID OF ROLE
            $id_query  = "SELECT * FROM roles WHERE name= '{$name}' ORDER BY id DESC LIMIT 1 ";
            $id_query_result = mysqli_query($connection, $id_query);
            if($id_query_result){
                        $result_array=mysqli_fetch_assoc($id_query_result);
                        $role_id=$result_array['id'];

                    //EXPLODE permissions ARRAY: FOREACH, INSERT INTO permissions_roles TABLE    
                    for ($i = 0; $i < count($permissions_array); $i++) {  
                            $insert_permission_query  = "INSERT INTO roles_permissions (permission_id, role_id) VALUES ('{$permissions_array[$i]}', '{$role_id}')";
                            $insert_permission_query_result = mysqli_query($connection, $insert_permission_query);
                                }//end insert roles/permissions int ojoint table 
                
                
                if(isset($_POST['walkthrough'])){  
                
                        redirect_to("roles.php?walkthrough&success");
                }else{
                          $_SESSION["message"] = "New Role Created!";
                          redirect_to("roles.php");
                    }

                    }else{
                
                    $_SESSION["message"] = "New Role Created, Could Not Find new role! Permissions not added.";
                    redirect_to("add_role.php");
                }//end get new role ID
        }else{
            $_SESSION["message"] = "New Role Failed!";
            redirect_to("add_role.php");
        }//end insert uery
            
    }//end check if form was submitted
?>

<form action="add_role.php" method="POST">
    Name: <input type="text" name="name" id="name" value="" > 
    Permissions:
               <?php

// Get permissions for roles

   $query  = "SELECT * FROM permissions";  
   $result = mysqli_query($connection, $query);
   if($result){
       echo "<br/>";
       //show each result value
       foreach($result as $show){
           
           $role_id = $show['id'];
           $role_name = $show['name']; 
           //put each permission in a check box
           echo "<input type=\"checkbox\" name=\"permission[]\" id=\"". $role_id . "\" value=\"".$role_id."\"> <label for=\"". $role_id . "\">".$role_name."</label><br/>";
                     
           }//end loop through permissions
       }//end call all site permissions

if(isset($_GET['walkthrough'])){ ?>
        <input type="hidden" name="walkthrough">
<?php }
 ?>
        <input type="submit" name="submit" id="submit" value="Save Role">
</form>
 <a href="roles.php">cancel</a>

  
        
<?php
//    }
include("inc/footer.php"); ?>