<?php include("inc/header.php"); ?>


  <?php 
 
if($_SESSION['is_employee']==0){
    //CLIENT
    ?>
    <h2>Your Dashboard</h2> 
    <ul>
        <li>Total number of items</li>
        <li>number of claims made &amp; Percent of resolved/denied/pending claims</li>
        <li>Your Rooms and items in them</li>
        <li>Quick Add New item</li>
        <li>MILK FTW</li>
        <li>Sup</li>
        <li>MILK</li>
    </ul>
    <?php
    
}else{  ?>
    <h2>Statistics</h2>
    <ul>
        <li>Total number of clients</li>
        <li>number of claims made &amp; Percent of resolved/denied/pending claims</li>
    </ul>
    <?php

}
    ?>

           
           <?php

//example query

//    $query  = "SELECT * FROM TABLE";  
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