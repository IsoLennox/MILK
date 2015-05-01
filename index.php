<?php include("inc/header.php"); ?>
<?php if($_SESSION['is_employee']==0){
    echo "<h1>CLIENT</h1>";
//MATT WAS HERE
}else{
    echo "<h1>Employee</h1>";


} ?>
  
<h1>Home Page</h1>
           <p>Porem ipsum dolor sit amet, consectetur adipisicing elit. Soluta magni enim sit quasi expedita ex, assumenda, repellendus sequi neque hic, tempore ullam debitis eaque consectetur dicta est fuga autem voluptate.</p>
 			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
 			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
 			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
 			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
 			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
 			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

           
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