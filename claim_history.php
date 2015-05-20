<?php
$current_page="claims";
include("inc/header.php"); ?>
  <?php
//get type of claim queried
    if(isset($_GET['draft'])){
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
            
            
            echo "Title: ".$show['title']."<br/>"; 
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: Pending<br/>";
            echo "Claim Type: ".$claim_type."<br/>";
            echo "Notes/Description: ".$show['notes']."<br/>"; 
             echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>"; 
            
            echo "</div>";
            }  
        }
            echo "<Br/>";  
    
    }elseif(isset($_GET['pending'])){
    echo "<h2>Pending Claims</h2>";  
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
            
            
            echo "Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: Pending<br/>";
            echo "Claim Type: ".$claim_type."<br/>";
            echo "Notes/Description: ".$show['notes']."<br/>"; 
             echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>"; 
            
            echo "</div>";
            }  
        }
            echo "<Br/>";  
    
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
            
            echo "<div class=\"notes_container\">";
            
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
            
            echo "</div>";
            }
        }
        
        
        
        
    }elseif(isset($_GET['changes'])){
    
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
            
            
            echo "Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: Pending Changes<br/>";
            echo "Claim Type: ".$claim_type."<br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";  
            
            echo "</div>";
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
            echo "Title: ".$show['title']."<br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: <span style=\"color:red;\">".$status."</span><br/>";
            echo "Claim Type: ".$claim_type."<br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";  
            
            
            echo "</div>";
            }  
        }
  }//end show claims dependant on uery
?>

     
        
      
        
<?php include("inc/footer.php"); ?>