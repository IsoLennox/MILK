<?php 
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
        <div class="claim_filters">
            <a href="claim_history.php"><i class="fa fa-folder-open"></i> All Claims</a> (<?php echo $data['total']; ?>) | 
            <a href="claims.php?pending"><i class="fa fa-file-text"></i> Unprocessed (<?php echo $total; ?>)</a>
            <a href="claim_history.php?approved"><i class="fa fa-check green"></i> Approved </a> (<?php echo $adata['total']; ?>) | 
            <a href="claim_history.php?denied"><i class="fa fa-times red"></i> Denied </a> (<?php echo $ddata['total']; ?>) |              
            <a href="claim_history.php?pending"><i class="fa fa-clock-o "></i> Processing </a> (<?php echo $pdata['total']; ?>) |             
            <a href="claim_history.php?changes"><i class="fa fa-pencil"></i> Pending Changes </a> (<?php echo $cdata['total']; ?>) |
            <a href="claim_history.php?draft"><i class="fa fa-file-o "></i> Drafts </a> (<?php echo $drdata['total']; ?>) 
        </div>