<?php include("inc/header.php"); ?>


  <?php 
 
if($_SESSION['is_employee']==0){
    //CLIENT
    ?>
    <h2>Your Dashboard</h2> 
    <ul>
        <li>Total number of items</li>
        <?php
    $items=0;
    $item_count  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']}";  
    $item_result = mysqli_query($connection, $item_count);
    $num_items=mysqli_num_rows($item_result);
    echo "You have ".$num_items." items";
    ?>
        
        
        
        
        <li>number of claims made &amp; Percent of resolved/denied/pending claims</li>
        
    <?php
    $claims=0;
    $claim_count  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']}";  
    $claim_result = mysqli_query($connection, $claim_count);
    $num_claims=0;
    if($claim_result){
        foreach($claim_result as $claim){
        $num_claims++;
    }
    }
    echo "You have made ".$num_claims." claims";
    ?>
        
        
        <li>Your Rooms and items in them</li>
        
                <?php
    $rooms=0;
    $room_count  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']}";  
    $room_result = mysqli_query($connection, $room_count);
    $num_rooms=mysqli_num_rows($room_result);
    echo "You have ".$num_rooms." rooms";
    ?>
       
       
        <li>Quick Add New item</li> 
    </ul>
    <?php
    
}else{  ?>
    <h2>Statistics</h2>
    <ul>
        <li>Total number of clients</li>
        <li>number of claims made &amp; Percent of resolved/denied/pending claims</li>
    </ul>
    <?php

}
    ?>

           
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
