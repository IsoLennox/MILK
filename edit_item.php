<?php
$current_page="inventory";
include("inc/header.php"); ?>

<?php 


if(isset($_POST['submit'])){
    echo "submitted!";
    // UPDATE TABLE : ADD 'updated' col
    $item_id=$_POST['item_id'];
    $name=$_POST['name'];
    $room=$_POST['room'];
    $category=$_POST['category'];
    $notes=$_POST['notes'];
    $purchase_date=$_POST['purchase_date'];
    $purchase_price=$_POST['purchase_price'];
    $declared_value=$_POST['declared_value'];
    $date = date('m/d/Y H:i');
    
    
    
        $update_item  = "UPDATE items SET name='{$name}', room_id={$room}, category={$category}, notes='{$notes}', purchase_date='{$purchase_date}', purchase_price='{$purchase_price}', declared_value='{$declared_value}', updated='{$date}' ";
//        $update_item  = "UPDATE items SET name='{$name}', room_id={$room}, updated='{$date}' ";
        $update_item .= "WHERE id = {$item_id} ";
        $result = mysqli_query($connection, $update_item);

        if ($result && mysqli_affected_rows($connection) == 1) {
        // Success 
            
             //INSERT into history table
            
            $content = "Edited item: <a href=\"item_details.php?id=".$item_id."\">".$name."</a>";
            $history  = "INSERT INTO history ( user_id, content, datetime ) VALUES ( {$_SESSION['user_id']}, '{$content}', '{$date}' ) ";
            $insert_history = mysqli_query($connection, $history); 
            
            
            $_SESSION["message"] = "Updated Item!";
            redirect_to('item_details.php?id='.$item_id);

        } else {
        // Failure
        $_SESSION["message"] = "Could not update item room#".$room;
        header('Location: ' . $_SERVER['HTTP_REFERER']);

        }//END EDIT ITEM
    
    
    //ADD TO HISTORY
    //  REDIRECT TO ITEM DETAILS
}
    
    
    if(isset($_GET['id'])){
     $id= $_GET['id'];                        
    $name= get_item_details($id);
        
?>


<h1>Editing <?php echo $name['name']; ?></h1> 



<form method="POST" >
               
     <!--    //GET ITEM CATEGORIES -->
   <?php
                $category_query  = "SELECT * FROM item_category"; 
                $categoryresult = mysqli_query($connection, $category_query);
                if($categoryresult){ 
                    //CATEGORY SELECT BOX
                    echo "<p>Category:  <select name=\"category\" >";
                    foreach($categoryresult as $category){
                        //OPTIONS
                        
                        if($category['id']==$name['category']){ $selected = "selected";}else{ $selected="";}
                        echo "<option ".$selected." value=\"".$category['id']."\" >".$category['name']."</option>";  
                    }
                    echo "</select></p>";
                }//end get categories

?> 
    <p>Item Title: <input type="text" name="name" placeholder="i.e. Samsung Television" value="<?php echo $name['name']; ?>" ></p>
    
<!--    //GET ROOMS TO CHOOSE FROM -->
   <?php
                $room_query  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']}"; 
                $roomresult = mysqli_query($connection, $room_query);
                if($roomresult){ 
                    //ROOM SELECT BOX
                    echo "<p>Room: <select name=\"room\" >";
                    foreach($roomresult as $room){
                        //OPTIONS
                         if($room['id']==$name['room_id']){ $selected = "selected";}else{ $selected="";}
                        echo "<option ".$selected." value=\"".$room['id']."\" >".$room['name']."</option>"; 
                        
                    }
                    echo "</select></p>";
                }//end get rooms 
 ?>
   
   <p>Item Description/Notes: <textarea name="notes" id="notes" cols="30" rows="10" value="<?php echo $name['notes']; ?>"><?php echo $name['notes']; ?></textarea></p>
     
    <p>Purchase Date: <input type="text" name="purchase_date" placeholder="mm/dd/yyyy" value="<?php echo $name['purchase_date']; ?>"></p>
    <p>Purchase Price: $<input type="text" name="purchase_price" placeholder="950.89" value="<?php echo $name['purchase_price']; ?>"></p>
    <p>Declared Value: $<input type="text" name="declared_value" placeholder="950.99" value="<?php echo $name['declared_value']; ?>"></p>
   
    <p>Add File (e.x. Image/file of object, reciept, appraisal... )</p>
    <input type="hidden" name="item_id" value="<?php echo $name['id']; ?>">
    <input type="submit" name="submit" value="Save Item">
 </form>
     
         
<a href="item_details.php?id=<?php echo $id; ?>"  onclick="return confirm('Leave the page? This will not save your item!')" >Cancel</a>
           <?php } ?>
           
           
           
 
     
        
      
        
<?php include("inc/footer.php"); ?>