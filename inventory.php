<?php include("inc/header.php"); ?>


<h1>Inventory</h1>

<a href="add_item.php">+ Add Item</a>
 <h2>Your Items:</h2>

  <?php

//Get items

    $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']}";  
    $result = mysqli_query($connection, $query);
    if($result){
        //show each result value
        echo "<ul>";
        foreach($result as $show){
            
            $id=$show['id'];
            $name=$show['name'];
            echo "<li><a href=\"item_details.php?id=".$id."\">".$name."</a></li>";
                      
            }
        echo "</ul>";
        }
 ?>
     
        
      
        
<?php include("inc/footer.php"); ?>