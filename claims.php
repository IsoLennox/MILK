<?php 
$current_page="claims";
include("inc/header.php"); ?>

<!--FOR EMPLOYEES-->
 
<!--
TO DO: 

ADD IF NOT EMPLOYEE, REDIRECT TO CLAIMS HISTORY
-->

<h1>Claims</h1>

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
        <ul>
           <li><a href="claims.php">All Claims</a> (<?php echo $data['total']; ?>)</li>
           <li><a href="claims.php?pending">Pending</a> (<?php echo $pdata['total']; ?>)</li>
           <li><a href="claims.php?approved">Approved</a> (<?php echo $adata['total']; ?>)</li>
           <li><a href="claims.php?denied">Denied</a> (<?php echo $ddata['total']; ?>)</li>
        </ul>
       
       
       <?php
//get type of claim queried
    if(isset($_GET['pending'])){
    
    //select all where claim type == pending   order by id ASC  
    echo "<h1>Pending Claims</h1>";  
        //GET ALL PENDING 

    $query  = "SELECT * FROM claims WHERE status_id=0 ORDER BY id DESC";  
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
            echo "Claim Type: ".$claim_type."<br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";       
            }  
        }  
    
    }elseif(isset($_GET['approved'])){
    
    //select all where claim type == approved    order by id DESC  
      
    echo "<h1>Approved Claims</h1>";  
        //GET ALL PENDING 

    $query  = "SELECT * FROM claims WHERE status_id=2 ORDER BY id DESC";  
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
            echo "Claim Type: ".$claim_type."<br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";       
            }  
        }
     
    
    }elseif(isset($_GET['denied'])){
    
    //select all where claim type == approved    order by id DESC  
    echo "<h1>Denied Claims</h1>";  
        //GET ALL PENDING 

    $query  = "SELECT * FROM claims WHERE status_id=3 ORDER BY id DESC";  
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
            echo "Claim Type: ".$claim_type."<br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\">View this Claim</a>";       
            }  
        }
    }else{
  
  echo "<h1>All Claims</h1>";
    $query  = "SELECT * FROM claims ORDER BY id DESC";  
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