<?php include("inc/header.php"); ?>
<a href="inventory.php">&laquo; All Items</a>
<?php

if(isset($_GET['remove'])){ 
    $item_id=$_GET['remove'];
    $name=$_GET['item'];
        echo "This item will be removed";
    
    //UPDATE item to in_trash=1
    
        $update_item  = "UPDATE items SET in_trash = 1 ";
        $update_item .= "WHERE id = {$item_id} ";
        $result = mysqli_query($connection, $update_item);

        if ($result && mysqli_affected_rows($connection) == 1) {
        // Success 
            
             //INSERT into history table
            $date = date('d/m/Y H:i');
            $content = "DELETED item: <a href=\"item_details.php?id=".$item_id."\">".$name."</a>";
            $history  = "INSERT INTO history ( user_id, content, datetime ) VALUES ( {$_SESSION['user_id']}, '{$content}', '{$date}' ) ";
            $insert_history = mysqli_query($connection, $history); 
            
            
            $_SESSION["message"] = "Item Removed!";
        header('Location: ' . $_SERVER['HTTP_REFERER']);

        } else {
        // Failure
        $_SESSION["message"] = "Could not delete item";
        header('Location: ' . $_SERVER['HTTP_REFERER']);

        }//END REMOVE ITEM
    
    
   
    
}elseif(isset($_GET['id'])){ 
    $id=$_GET['id'];
    
    $query  = "SELECT * FROM items WHERE id={$id}"; 
    $result = mysqli_query($connection, $query);
    $num_rows=mysqli_num_rows($result);
//    if(!empty($result)){
    if($num_rows >= 1){
        //show each result value
        foreach($result as $show){
            
                //if item is not yours or if you are not employee, cannot view this item
            if($show['user_id']===$_SESSION['user_id'] || $_SESSION['is_employee']==1){
                
                if($show['in_trash']==1){
                   $in_trash= "This item was removed. <a href=\"#\">Restore it?</a>";
                }else{
                    $in_trash=" <a onclick=\"return confirm('DELETE this item?')\" href=\"item_details.php?remove=".$show['id']."&item=".$show['name']."\">Remove Item</a>";
                }
            
                echo "<h1>".$show['name']."</h1>"; 
                echo "<a href=\"edit_item.php?id=".$show['id']."\">Edit</a><br/>";
                
                
                $room_name=get_room_name($show['room_id']);
                $cat_name=get_category_name($show['category']);
                echo "Category: ".$cat_name."<br/>";
                echo "Room: ".$room_name;
                      
                echo "<br/>";
                //GET ALL OTHER DETAILS
                echo "Purchase Date: ".$show['purchase_date']."<br/>"; 
                echo "Purchase Price: ".$show['purchase_price']."<br/>"; 
                echo "Declared Value: ".$show['declared_value']."<br/>"; 
                echo "Description/Notes:<br/>".$show['notes']."<br/>"; 
                
                
                echo $in_trash;

                }else{
                //No permission to view this item
                echo "<br/><br/>Oops! It seems this is not your item.";
            }
        }
    }else{
        echo "This item seems to have been removed!";
    }
    
    
    
}else{
    echo "This item seems to have been removed!";
}
?>
 
 

           
 
        
      
        
<?php include("inc/footer.php"); ?>