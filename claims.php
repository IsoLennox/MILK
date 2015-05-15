<?php 
$current_page="claims";
include("inc/header.php"); ?>

<!--FOR EMPLOYEES-->
 
<!--
TO DO: 

ADD IF NOT EMPLOYEE, REDIRECT TO CLAIMS HISTORY
-->

<h1>Claims</h1>

<form action="#">
    <input type="text" name="search" value="" placeholder="Search Claims by ID, Policyholder, or content...">
    <input type="submit" name="submit" id="submit" value="Find Claims">
</form>
 
       <ul class="inline">
           <li><a href="claims.php">All</a></li>
           <li><a href="claims.php?pending">Pending</a></li>
           <li><a href="claims.php?approved">Approved</a></li>
           <li><a href="claims.php?denied">Denied</a></li>
       </ul>
       
       
       <?php
//get type of claim queried
    if(isset($_GET['pending'])){
    
    //select all where claim type == pending   order by id ASC  
    echo "<h2>Pending Claims</h2>";  
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
      
    echo "<h2>Approved Claims</h2>";  
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
    echo "<h2>Denied Claims</h2>";  
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