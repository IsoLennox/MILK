<?php include("inc/header.php"); ?>


<h1>New Role</h1> 
<!-- <form action="add_role.php">
    Name: <input type="text" name="role_name">
    Permissions:
        <input type="checkbox" name="permission[]">Permission
        <input type="checkbox" name="permission[]">Permission
        <input type="checkbox" name="permission[]">Permission
        <input type="checkbox" name="permission[]">Permission
        <input type="checkbox" name="permission[]">Permission
        <input type="submit" name="submit" id="submit" value="Save Role">
</form> -->

<form action="add_role.php">
    Name: <input type="text" name="role_name">
    Permissions:
               <?php

// Get permissions for roles

   $query  = "SELECT * FROM permissions";  
   $result = mysqli_query($connection, $query);
   if($result){
       //show each result value
       foreach($result as $show){
           
           $role_id = $show['id'];
           $role_name = $show['name'];
           echo "<input type=\"checkbox\" name=\"permission[]\">" . $role_name;
                     
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