<?php include("inc/header.php"); ?>
<?php if($_SESSION['is_employee']==0){
    echo "<h1>CLIENT</h1>";
//MATT WAS HERE
}else{
    echo "<h1>Employee</h1>";

} ?>
 
 <p>Home Page</p>
           
           
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