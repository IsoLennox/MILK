    <ul> 
        <?php
    $items=0;
    $item_count  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0";  
    $item_result = mysqli_query($connection, $item_count);
    $num_items=mysqli_num_rows($item_result);
    echo "<li>You have ".$num_items." items</li>";
    ?>
                        <?php //NUMBER OF ROOMS
    $rooms=0;
    $room_count  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']}";  
    $room_result = mysqli_query($connection, $room_count);
    $num_rooms=mysqli_num_rows($room_result);
    echo "<li>You have ".$num_rooms." rooms</li>";
    //get items for each room
    ?>
        
        
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
    echo "<li>You have made ".$num_claims." claims</li>";



 
        //GET COUNTS
            $all_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']}";   
            $all_result = mysqli_query($connection, $all_query);
            $data=mysqli_fetch_assoc($all_result);

            $pending_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=0";   
            $pending_result = mysqli_query($connection, $pending_query);
            $pdata=mysqli_fetch_assoc($pending_result); 
                
            $draft_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=1";   
            $draft_result = mysqli_query($connection, $draft_query);
            $drdata=mysqli_fetch_assoc($draft_result); 

                
            $changes_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=4";   
            $changes_result = mysqli_query($connection, $changes_query);
            $cdata=mysqli_fetch_assoc($changes_result); 


            $approved_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=2";   
            $approved_result = mysqli_query($connection, $approved_query);
            $adata=mysqli_fetch_assoc($approved_result); 

            $denied_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=3";   
            $denied_result = mysqli_query($connection, $denied_query);
            $ddata=mysqli_fetch_assoc($denied_result); 
        ?>
          
          </ul>
          
          <h2>Claim Status Counts</h2>
    <ul>
           <li><a href="claim_history.php">All Claims </a> (<?php echo $data['total']; ?>)</li>
           <li><a href="claim_history.php?draft">Drafts </a> (<?php echo $drdata['total']; ?>)</li>
           <li><a href="claim_history.php?pending">Processing </a> (<?php echo $pdata['total']; ?>)</li>
           <li><a href="claim_history.php?approved">Approved </a> (<?php echo $adata['total']; ?>)</li>
           <li><a href="claim_history.php?changes">Pending Changes </a> (<?php echo $cdata['total']; ?>)</li>
           <li><a href="claim_history.php?denied">Denied </a> (<?php echo $ddata['total']; ?>)</li>

    </ul>