<?php
$current_page="claims";
include("inc/header.php"); ?>
  <?php
 

        //GET COUNTS
           

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
     <a href="claim_history.php?draft"><i class="fa fa-file-o "></i> Drafts </a> (<?php echo $drdata['total']; ?>) | 
           <a href="claim_history.php?pending"><i class="fa fa-clock-o "></i> Processing </a> (<?php echo $pdata['total']; ?>) | 
           <a href="claim_history.php?approved"><i class="fa fa-check green"></i> Approved </a> (<?php echo $adata['total']; ?>) | 
           <a href="claim_history.php?denied"><i class="fa fa-times red"></i> Denied </a> (<?php echo $ddata['total']; ?>) | 
           <a href="claim_history.php?changes"><i class="fa fa-pencil"></i> Pending Changes </a> (<?php echo $cdata['total']; ?>)

  <?php 
   
    if(isset($_GET['draft'])){
        $sub_page='draft';
    echo "<h2>Unsubmitted Claims</h2>";  
        //GET ALL PENDING FROM USER LOGGED IN

    $query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=1 ORDER BY id DESC";  
    $result = mysqli_query($connection, $query);
    if($result){ 
        //show each result value
        foreach($result as $show){
            echo "<div class=\"notes_container\">";
                        //GET CLAIM TYPE NAME
            $type_query  = "SELECT * FROM claim_types WHERE id={$show['claim_type']}";  
            $type_result = mysqli_query($connection, $type_query);
            if($type_result){
                $type_array=mysqli_fetch_assoc($type_result);
                $claim_type=$type_array['name'];
            }
            
            
            echo "<p>Title: ".$show['title']."<br/>"; 
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: <span style=\"color:red;\">Draft</span><br/>";
            echo "Claim Type: ".$claim_type."<br/>";
            echo "Notes/Description: ".$show['notes']."</p><br/>"; 
             echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>"; 
            
            echo "</div>";
            }  
        }
            echo "<Br/>";  
    
    }elseif(isset($_GET['pending'])){
        $sub_page='pending';
    echo "<h2>Processing Claims</h2>";  
        //GET ALL PENDING FROM USER LOGGED IN

    $query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=0 ORDER BY id DESC";  
    $result = mysqli_query($connection, $query);
    if($result){ 
        //show each result value
        foreach($result as $show){
            
            echo "<div class=\"notes_container\">";
            
                        //GET CLAIM TYPE NAME
            $type_query  = "SELECT * FROM claim_types WHERE id={$show['claim_type']}";  
            $type_result = mysqli_query($connection, $type_query);
            if($type_result){
                $type_array=mysqli_fetch_assoc($type_result);
                $claim_type=$type_array['name'];
            }
            
            
            echo "<p>Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status:<span style=\"color:red;\">Processing</span><br/>";
            echo "Claim Type: ".$claim_type."<br/>";
            echo "Notes/Description: ".$show['notes']."</p><br/>"; 
            echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>"; 
            
            echo "</div>";
            }  
        }
            echo "<br/>";  
    
    }elseif(isset($_GET['approved'])){
     
    $sub_page='approved';    
    echo "<h2>Approved Claims</h2>";  
        //GET ALL PENDING FROM USER LOGGED IN

    $query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=2 ORDER BY id DESC";  
    $result = mysqli_query($connection, $query);
    if($result){ 
        //show each result value
        foreach($result as $show){
            
                        //GET CLAIM TYPE NAME
    $type_query  = "SELECT * FROM claim_types WHERE id={$show['claim_type']}";  
    $type_result = mysqli_query($connection, $type_query);
    if($type_result){
        $type_array=mysqli_fetch_assoc($type_result);
        $claim_type=$type_array['name'];
    }
            
            
            echo "<p>Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: <span style=\"color:red;\">Approved</span><br/>";
            echo "Claim Type: ".$claim_type."</p><br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";       
            }  
        }
    
    }elseif(isset($_GET['denied'])){
    $sub_page='denied';
    echo "<h2>Denied Claims</h2>";  
        //GET ALL PENDING FROM USER LOGGED IN

    $query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=3 ORDER BY id DESC";  
    $result = mysqli_query($connection, $query);
    if($result){ 
        //show each result value
        foreach($result as $show){
            
            echo "<div class=\"notes_container\">";
            
                        //GET CLAIM TYPE NAME
    $type_query  = "SELECT * FROM claim_types WHERE id={$show['claim_type']}";  
    $type_result = mysqli_query($connection, $type_query);
    if($type_result){
        $type_array=mysqli_fetch_assoc($type_result);
        $claim_type=$type_array['name'];
    }
            
            
            echo "<p>Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: <span style=\"color:red;\">Denied</span><br/>";
            echo "Claim Type: ".$claim_type."</p><br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";  
            
            echo "</div>";
            }
        }
        
        
        
        
    }elseif(isset($_GET['changes'])){
    $sub_page='changes';
    echo "<h2>Pending Changes / Awaiting Resubmittal</h2>";  
        //GET ALL PENDING FROM USER LOGGED IN

    $query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=4 ORDER BY id DESC";  
    $result = mysqli_query($connection, $query);
    if($result){ 
        //show each result value
        foreach($result as $show){
            echo "<div class=\"notes_container\">";
                        //GET CLAIM TYPE NAME
    $type_query  = "SELECT * FROM claim_types WHERE id={$show['claim_type']}";  
    $type_result = mysqli_query($connection, $type_query);
    if($type_result){
        $type_array=mysqli_fetch_assoc($type_result);
        $claim_type=$type_array['name'];
    }
            
            
            echo "<p>Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status:<span style=\"color:red;\">Pending Changes</span><br/>";
            echo "Claim Type: ".$claim_type."</p><br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";  
            
            echo "</div>";
            }
        }
    }else{
    $sub_page='all_claims';
    //select all claims order by id DESC  
        ?>
        <h2>All Claims</h2>
        <?php       //GET ALL HISTPORY FROM USER LOGGED IN

    $query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} ORDER BY id DESC";  
    $result = mysqli_query($connection, $query);
    if($result){ 
        //show each result value
        foreach($result as $show){
            
            echo "<div class=\"notes_container\">";
            
            //GET CLAIM TYPE NAME
    $type_query  = "SELECT * FROM claim_types WHERE id={$show['claim_type']}";  
    $type_result = mysqli_query($connection, $type_query);
    if($type_result){
        $type_array=mysqli_fetch_assoc($type_result);
        $claim_type=$type_array['name'];
    }
            
                        //GET CLAIM STATUS NAME
    $status_query  = "SELECT * FROM status_types WHERE id={$show['status_id']}";  
    $status_result = mysqli_query($connection, $status_query);
    if($status_result){
        $status_array=mysqli_fetch_assoc($status_result);
        $status=$status_array['name'];
    } 
            echo "<p>Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: <span style=\"color:red;\">".$status."</span><br/>";
            echo "Claim Type: ".$claim_type."</p><br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";  
            
            
            echo "</div>";
            }  
        }
  }//end show claims dependant on uery
?>

     
        
      
        
<?php include("inc/footer.php"); ?>