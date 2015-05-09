<?php include("inc/header.php"); ?>
<a href="inventory.php">&laquo; All Items</a>
<?php
if(isset($_GET['id'])){ 
    $id=$_GET['id'];
    
    $query  = "SELECT * FROM items WHERE id={$id}"; 
    $result = mysqli_query($connection, $query);
    if($result){
        //show each result value
        foreach($result as $show){
            
                //if item is not yours or if you are not employee, cannot view this item
            if($show['user_id']===$_SESSION['user_id'] || $_SESSION['is_employee']==1){
            
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
                
                
                

                }else{
                //No permission to view this item
                echo "<br/><br/>Oops! It seems this is not your item.";
            }
        }
    } 
    
    
    
}else{
    echo "This item seems to have been removed!";
}
?>
 
 

           
 
        
      
        
<?php include("inc/footer.php"); ?>