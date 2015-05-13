<?php include("inc/header.php"); ?> 
    
           
                  <h1>Your Activity</h1>       
<?php

//GET ALL HISTPORY FROM USER LOGGED IN

    $query  = "SELECT * FROM history WHERE user_id={$_SESSION['user_id']} ORDER BY id DESC";  
    $result = mysqli_query($connection, $query);
    if($result){
        echo "<ul>";
        //show each result value
        foreach($result as $show){
            echo "<li>".$show['content']." ".$show['datetime']."</li>";
                      
            }
        echo "</ul>";
        }
 ?>
     
<?php include("inc/footer.php"); ?>