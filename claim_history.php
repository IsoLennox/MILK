<?php include("inc/header.php"); ?>


<h1>Your Claims</h1>
 <p>Claim History</p>
<!--<a href="claim_details.php?id=1">Sample Claim</a>-->
           
   <ul class="inline">
           <li><a href="claim_history.php">All</a></li>
           <li><a href="claim_history.php?pending">Pending</a></li>
           <li><a href="claim_history.php?approved">Approved</a></li>
           <li><a href="claim_history.php?denied">Denied</a></li>
       </ul>
       
       
       <?php
//get type of claim queried
    if(isset($_GET['pending'])){
    echo "<h2>Pending Claims</h2>";  
        //GET ALL PENDING FROM USER LOGGED IN

    $query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=0 ORDER BY id DESC";  
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
            
            
            echo "Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: Pending<br/>";
            echo "Claim Type: ".$claim_type."<br/>";
            echo "Notes/Description: ".$show['notes']."<br/>";     
            }  
        }
        ?>
        
        
        
        <Br/>
        <?php   
    
    }elseif(isset($_GET['approved'])){
     
        
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
            
            
            echo "Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: Approved<br/>";
            echo "Claim Type: ".$claim_type."<br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";       
            }  
        }
    
    }elseif(isset($_GET['denied'])){
    
    echo "<h2>Denied Claims</h2>";  
        //GET ALL PENDING FROM USER LOGGED IN

    $query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=3 ORDER BY id DESC";  
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
            
            
            echo "Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: Denied<br/>";
            echo "Claim Type: ".$claim_type."<br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";       
            }
        }
    }else{
 
    //select all claims order by id DESC  
        ?>
        <h2>All Claims</h2>
        <?php       //GET ALL HISTPORY FROM USER LOGGED IN

    $query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} ORDER BY id DESC";  
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
            
            
        if($show['status_id']==0){
            $status="Pending";
        }elseif($show['status_id']==2){
            $status="Approved";
        }elseif($show['status_id']==3){
            $status="Denied";
        }
            
            
            echo "Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: ".$status."<br/>";
            echo "Claim Type: ".$claim_type."<br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";       
            }  
        }
  }//end show claims dependant on uery
?>

     
        
      
        
<?php include("inc/footer.php"); ?>