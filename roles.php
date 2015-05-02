<?php include("inc/header.php"); ?>


<h1>Roles</h1> 
 <a href="add_role.php">New Role</a>
         
         
          <p>Employee Roles</p>
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