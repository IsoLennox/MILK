<?php 
$current_page="claims";
include("inc/header.php"); ?>

<!--FOR EMPLOYEES-->
 
<!--
TO DO: 

ADD IF NOT EMPLOYEE, REDIRECT TO CLAIMS HISTORY
-->

       <?php
       
//get type of claim queried
    if(isset($_GET['pending'])){
        
        echo "<h1>Unprocessed Claims</h1>";
        include 'inc/claims_queries.php';  
        $query  = "SELECT * FROM claims WHERE status_id=0 ORDER BY id DESC";  
   
    }elseif(isset($_GET['changes'])){  
        echo "<h1>Awaiting Client Changes</h1>";
        include 'inc/claims_queries.php';  
        $query  = "SELECT * FROM claims WHERE status_id=4 ORDER BY id DESC";  
  
    }elseif(isset($_GET['approved'])){
        echo "<h1>Approved Claims</h1>"; 
        include 'inc/claims_queries.php'; 
       $query  = "SELECT * FROM claims WHERE status_id=2 ORDER BY id DESC";  
        
    }elseif(isset($_GET['denied'])){
        echo "<h1>Denied Claims</h1>"; 
        include 'inc/claims_queries.php'; 
        $query  = "SELECT * FROM claims WHERE status_id=3 ORDER BY id DESC";  

    }else{
  
  echo "<h1>All Claims</h1>";
  include 'inc/claims_queries.php';
    $query  = "SELECT * FROM claims WHERE status_id != 1 ORDER BY id DESC";  
        
    }
    $result = mysqli_query($connection, $query);
    if($result){ 
        echo "<div class=\"claims_list\">";
        //show each result value
        foreach($result as $show){
            echo "<div class=\"claims\">";
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