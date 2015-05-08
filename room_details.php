<?php include("inc/header.php"); ?>

<a href="rooms.php">&laquo; All Rooms</a>
<h1>Room Name</h1>
<a href="edit.php?room=1">Edit</a>

<br/>
<br/>
 <p>Items in this room:</p>
<a href="item_details.php?id=1">Sample Item</a>
           
           <?php

//example query

//    $query  = "SELECT * FROM TABLE WHERE user_id={$_SESSION['user_id']}"; 
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