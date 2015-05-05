<?php include("inc/header.php"); ?>


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
                                } 
                
                          $_SESSION["message"] = "New Role Created!";
                          redirect_to("roles.php");

                    }else{
                
                    $_SESSION["message"] = "New Role Created, Could Not Find new role! Permissions not added.";
                    redirect_to("add_role.php");
                }
        }else{
            $_SESSION["message"] = "New Role Failed!";
            redirect_to("add_role.php");
    }
            
    }
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
           echo "<input type=\"checkbox\" name=\"permission[]\" value=\"".$role_id."\"  >".$role_name."<br/>"; 
                     
           }
       }
 ?>
        <input type="submit" name="submit" id="submit" value="Save Role">
</form>
 <a href="roles.php">cancel</a>


         
 
           <?php

//example query

//    $query  = "SELECT * FROM TABLE";  
//    $result = mysqli_query($connection, $query);
//    if($result){
//        //show each result value
//        foreach($result as $show){
//            
//            $this_value=$show['col_name'];
//            echo $this_value;
//                      
//            }
//        }
 ?>
     
        
      
        
<?php include("inc/footer.php"); ?>