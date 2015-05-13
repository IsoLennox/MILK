<?php include("inc/header.php"); ?>

<a href="claim_history.php">&laquo; Claims History</a>
<h1>CLAIM TITLE</h1> 

<?php
if($_SESSION['is_employee']==1){
    echo "<a href=\"#\">Update This Claim</a>"; 
}
?>

<br/>
<br/> 
          <p>Made By: UserName (link to profile)</p><br/> 
          <p>Item Title/ID</p><br/> 
          <p>Claim Details</p><br/> 
          <p>Claim Details</p><br/> 
          <p>Claim Notes</p><br/> 
           
           <?php

//example query

//    $query  = "SELECT * FROM TABLE WHERE user_id={$_SESSION['user_id']}"; 
//    $result = mysqli_query($connection, $query);
//    if($result){
//        //show each result value
//        foreach($result as $show){
//            
//            $this_value=$show['col_name'];
//            echo $this_value;
//                      
//            }
//        }
 ?>
     
        
      
        
<?php include("inc/footer.php"); ?>