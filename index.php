<?php 
$current_page="dashboard";
include("inc/header.php"); ?>


  <?php 


 
if($_SESSION['is_employee']==0){
    //CLIENT
    ?>
    <h2>Your Dashboard</h2> 
    
    <?php
    //see if any alerts about claims
    
    $alerts_query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id != 0 AND status_id != 1 ";  
    $alertresult = mysqli_query($connection, $alerts_query);
    if($alertresult){
        
        echo "<h1>ALERTS</h1>";
        //show each result value
        foreach($alertresult as $show_alert){
                                     //GET CLAIM STATUS NAME
            $status_query  = "SELECT * FROM status_types WHERE id={$show_alert['status_id']}";  
            $status_result = mysqli_query($connection, $status_query);
            if($status_result){
                $status_array=mysqli_fetch_assoc($status_result);
                $status=$status_array['name'];
            } 
             echo "<a href=\"claim_details.php?id=".$show_alert['id']."\">Claim #".$show_alert['id'].": '".$show_alert['title']."'</a> is ".$status."<br/>";
                      
            }
        }
    
    
    
    
    
    ?>
    
    <img src="img/stats.PNG" alt="sample stats" />
    <ul>
        <li>Total number of items</li>
        <?php
    $items=0;
    $item_count  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0";  
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
    
}else{  

    
    //IS EMPLOYEE
 
//    foreach($_SESSION['permissions'] as $key => $val){ 
//        if($val==3){
//            echo "permission granted!";
//        }
//    }
?>
    <h2>Statistics</h2>
    
     <img src="img/stats.PNG" alt="sample stats" />
    <ul>
        <li>Total number of clients</li>
        <li>number of claims made &amp; Percent of resolved/denied/pending claims</li>
    </ul>
    
    
    
    
    
    
    <?php
    
    
    
            //GET CLAIM COUNTS
            $all_query  = "SELECT COUNT(*) as total FROM claims";   
            $all_result = mysqli_query($connection, $all_query);
            $data=mysqli_fetch_assoc($all_result);

            $pending_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=0";   
            $pending_result = mysqli_query($connection, $pending_query);
            $pdata=mysqli_fetch_assoc($pending_result); 


            $approved_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=2";   
            $approved_result = mysqli_query($connection, $approved_query);
            $adata=mysqli_fetch_assoc($approved_result); 

            $denied_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=3";   
            $denied_result = mysqli_query($connection, $denied_query);
            $ddata=mysqli_fetch_assoc($denied_result); 
        ?>
           <li><a href="claims.php">All Claims</a> (<?php echo $data['total']; ?>)</li>
           <li><a href="claims.php?pending">Pending</a> (<?php echo $pdata['total']; ?>)</li>
           <li><a href="claims.php?approved">Approved</a> (<?php echo $adata['total']; ?>)</li>
           <li><a href="claims.php?denied">Denied</a> (<?php echo $ddata['total']; ?>)</li>
           
           
           

<?php }     ?>

           
           <?php




// TO DO:

// GET how many claims are in each claim type
// GET how many items are in each item category


//have a refine statistics box: filter each section with checkboxes
//export option for all results

//FILTER BOX:

// Refine Results:
?>
<form action="#" method="POST">
    
    <input type="checkbox" name="results[]" value="claims">Claims
<!--    inside would involve total number of claims, number of items in each claims type, number involved in each claim status -->
    <input type="checkbox" name="results[]" value="items">Items
<!--    inside would involve number of items total, as well as number of items in each category-->
    <input type="checkbox" name="results[]" value="users">Users
<!--    inside would involve total num of users, total num of clients vs. employees, and statistics based on location and how many number of items, and claims clients have each, and on average --> 

<input type="submit" name="refine" value="Refine">
</form>

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
