<?php include("inc/header.php"); ?>
<?php 

if(isset($_GET['id'])){ ?>

<a href="rooms.php">&laquo; All Rooms</a>
 
 <?php
    $query  = "SELECT * FROM rooms WHERE id={$_GET['id']}"; 
    $result = mysqli_query($connection, $query);
    if($result){
        foreach($result as $show){
            echo "<h1>".$show['name']."</h1>";
            echo "<a href=\"edit.php?room=".$_GET['id']."\">Edit</a> ";
            echo "<p>".$show['notes']."</p>";
                $item_query  = "SELECT * FROM items WHERE room_id={$_GET['id']}"; 
                $itemresult = mysqli_query($connection, $item_query);
                if($itemresult){
                    echo "Items in this room: ";
                    echo "<ul>";
                    foreach($itemresult as $item){
                        echo "<li><a href=\"item_details.php?id=".$item['id']."\">".$item['name']."</li>"; 
                    }
                    echo "</ul>";
                }//end get items in room

            }
        }
  }else{
    $_SESSION["message"] = "Room does not exist!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>

           
            
        
      
        
<?php include("inc/footer.php"); ?>