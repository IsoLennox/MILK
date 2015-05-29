<?php 
$current_page="claims";
include("inc/header.php"); ?>

<!--FOR EMPLOYEES-->
 
<!--
TO DO: 

ADD IF NOT EMPLOYEE, REDIRECT TO CLAIMS HISTORY
-->

<!-- <h1>Claims</h1> -->

         <?php  
            //GET CLAIM COUNTS

         	//ALL CLAIMS EXCEPT FOR DRAFT = (1)
            $all_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id != 1";   
            $all_result = mysqli_query($connection, $all_query);
            $data=mysqli_fetch_assoc($all_result);

            //PROCESSING CLAIMS = (0)
            $pending_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=0";   
            $pending_result = mysqli_query($connection, $pending_query);
            $pdata=mysqli_fetch_assoc($pending_result); 

            //PENDING CHANGES (4)
            $waiting_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=4";   
            $waiting_result = mysqli_query($connection, $waiting_query);
            $wdata=mysqli_fetch_assoc($waiting_result); 
 
            //APPROVED CLAIMS (2)
            $approved_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=2";   
            $approved_result = mysqli_query($connection, $approved_query);
            $adata=mysqli_fetch_assoc($approved_result); 

            //DENIED CLAIMS (3)
            $denied_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=3";   
            $denied_result = mysqli_query($connection, $denied_query);
            $ddata=mysqli_fetch_assoc($denied_result); 
        ?>

       
       <?php
//get type of claim queried
    if(isset($_GET['pending'])){
        
        echo "<h1>Unprocessed Claims</h1>";
        ?>
        <div class="claim_filters">
           <a href="claims.php"><i class="fa fa-folder-open black"></i> All Claims</a> (<?php echo $data['total']; ?>) |
           <a href="claims.php?pending"><i class="fa fa-file-text"></i> Inactive </a>(<?php echo $total; ?>) |           
           <a href="claims.php?approved"><i class="fa fa-check green"></i> Approved</a> (<?php echo $adata['total']; ?>) |
           <a href="claims.php?denied"><i class="fa fa-times red"></i> Denied</a> (<?php echo $ddata['total']; ?>) |
           <a href="claims.php?pending"><i class="fa fa-clock-o black"></i> Processing</a> (<?php echo $pdata['total']; ?>) |
           <a href="claims.php?changes"><i class="fa fa-pencil"></i> Pending Changes</a> (<?php echo $wdata['total']; ?>) 
        </div>
        <?php 
        $query  = "SELECT * FROM claims WHERE status_id=0 ORDER BY id DESC";  
   
    }elseif(isset($_GET['changes'])){  
        echo "<h1>Awaiting Client Changes</h1>";
         ?>
        <div class="claim_filters">
           <a href="claims.php"><i class="fa fa-folder-open black"></i> All Claims</a> (<?php echo $data['total']; ?>) |
           <a href="claims.php?pending"><i class="fa fa-file-text"></i> Inactive </a>(<?php echo $total; ?>) |           
           <a href="claims.php?approved"><i class="fa fa-check green"></i> Approved</a> (<?php echo $adata['total']; ?>) |
           <a href="claims.php?denied"><i class="fa fa-times red"></i> Denied</a> (<?php echo $ddata['total']; ?>) |
           <a href="claims.php?pending"><i class="fa fa-clock-o black"></i> Processing</a> (<?php echo $pdata['total']; ?>) |
           <a href="claims.php?changes"><i class="fa fa-pencil"></i> Pending Changes</a> (<?php echo $wdata['total']; ?>) 
        </div>
        <?php  
        $query  = "SELECT * FROM claims WHERE status_id=4 ORDER BY id DESC";  
  
    }elseif(isset($_GET['approved'])){
        echo "<h1>Approved Claims</h1>";
         ?>
        <div class="claim_filters">
           <a href="claims.php"><i class="fa fa-folder-open black"></i> All Claims</a> (<?php echo $data['total']; ?>) |
           <a href="claims.php?pending"><i class="fa fa-file-text"></i> Inactive </a>(<?php echo $total; ?>) |           
           <a href="claims.php?approved"><i class="fa fa-check green"></i> Approved</a> (<?php echo $adata['total']; ?>) |
           <a href="claims.php?denied"><i class="fa fa-times red"></i> Denied</a> (<?php echo $ddata['total']; ?>) |
           <a href="claims.php?pending"><i class="fa fa-clock-o black"></i> Processing</a> (<?php echo $pdata['total']; ?>) |
           <a href="claims.php?changes"><i class="fa fa-pencil"></i> Pending Changes</a> (<?php echo $wdata['total']; ?>) 
        </div>
        <?php  
       $query  = "SELECT * FROM claims WHERE status_id=2 ORDER BY id DESC";  
        
    }elseif(isset($_GET['denied'])){
        echo "<h1>Denied Claims</h1>";
         ?>
        <div class="claim_filters">
           <a href="claims.php"><i class="fa fa-folder-open black"></i> All Claims</a> (<?php echo $data['total']; ?>) |
           <a href="claims.php?pending"><i class="fa fa-file-text"></i> Inactive </a>(<?php echo $total; ?>) |           
           <a href="claims.php?approved"><i class="fa fa-check green"></i> Approved</a> (<?php echo $adata['total']; ?>) |
           <a href="claims.php?denied"><i class="fa fa-times red"></i> Denied</a> (<?php echo $ddata['total']; ?>) |
           <a href="claims.php?pending"><i class="fa fa-clock-o black"></i> Processing</a> (<?php echo $pdata['total']; ?>) |
           <a href="claims.php?changes"><i class="fa fa-pencil"></i> Pending Changes</a> (<?php echo $wdata['total']; ?>) 
        </div>
        <?php  
        $query  = "SELECT * FROM claims WHERE status_id=3 ORDER BY id DESC";  

    }else{
  
  echo "<h1>All Claims</h1>";
   ?>
        <div class="claim_filters">
           <a href="claims.php"><i class="fa fa-folder-open black"></i> All Claims</a> (<?php echo $data['total']; ?>) |
           <a href="claims.php?pending"><i class="fa fa-file-text"></i> Inactive </a>(<?php echo $total; ?>) |           
           <a href="claims.php?approved"><i class="fa fa-check green"></i> Approved</a> (<?php echo $adata['total']; ?>) |
           <a href="claims.php?denied"><i class="fa fa-times red"></i> Denied</a> (<?php echo $ddata['total']; ?>) |
           <a href="claims.php?pending"><i class="fa fa-clock-o black"></i> Processing</a> (<?php echo $pdata['total']; ?>) |
           <a href="claims.php?changes"><i class="fa fa-pencil"></i> Pending Changes</a> (<?php echo $wdata['total']; ?>) 
        </div>
        <?php
    $query  = "SELECT * FROM claims WHERE status_id != 1 ORDER BY id DESC";  
        
    }
    $result = mysqli_query($connection, $query);
    //DEPENDING ON LINK PARAMETER - ?PENDING etc 
    //$SHOW displays
    if($result){ 
        echo "<div class=\"claims_list\">";
        //show each result value
        foreach($result as $show){
            echo "<div class=\"claims\">";
    //GET CLAIM TYPE NAME IE(FIRE FLOOD EARTHQUAKE)
    $type_query  = "SELECT * FROM claim_types WHERE id={$show['claim_type']}";  
    $type_result = mysqli_query($connection, $type_query);
    if($type_result){
        $type_array=mysqli_fetch_assoc($type_result);
        $claim_type=$type_array['name'];
    }
            
            
   	//GET CLAIM STATUS NAME (DRAFT APPROVED DENIED)
    $status_query  = "SELECT * FROM status_types WHERE id={$show['status_id']}";  
    $status_result = mysqli_query($connection, $status_query);
    if($status_result){
        $status_array=mysqli_fetch_assoc($status_result);
        $status=$status_array['name'];
    }           
            
            echo "<a href=\"claim_details.php?id=".$show['id']."\"><h4>".$show['title']."</h4></a><br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            echo "Status: ".$status."<br/>";
            echo "Claim Type: ".$claim_type."<br/>";
               echo "<a href=\"claim_details.php?id=".$show['id']."\"><i class=\"fa fa-eye\"></i> View this Claim</a>";  
            echo "</div>";
            }  
        echo "</div>";
        }
?>

      
        
<?php include("inc/footer.php"); ?>