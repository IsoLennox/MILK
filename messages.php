<?php
$current_page="messages";
include("inc/header.php"); ?>


<h1>Messages</h1>

    <h4>New Message</h4>
 
          <p>Your conversations:</p>
          <ul>
              <li><a href="read_message.php?thread=1">Conversation with Sally Stone</a></li>
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