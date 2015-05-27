<?php
$current_page="claims";
include("inc/header.php"); ?>
  <?php
   
    if(isset($_GET['draft'])){
        $sub_page='draft';
    echo "<h2>Unsubmitted Claims</h2>";  
    include 'inc/claims_queries.php';
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
    include 'inc/claims_queries.php';  
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
    include 'inc/claims_queries.php';  
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
    include 'inc/claims_queries.php';  
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
    include 'inc/claims_queries.php';  
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
    include 'inc/claims_queries.php';
        
        
            //SHOW ALERT IF CLAIM IS PENDING CHANGES
    
    $alerts_query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id = 4 ";  
    $alertresult = mysqli_query($connection, $alerts_query);
    $rows = mysqli_num_rows($alertresult);
    if($rows>=1){
        
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
        
        echo "   <hr>";
        }
        
        
        
        
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