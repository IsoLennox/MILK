<?php include("inc/header.php"); ?>


<h1>New Item</h1> 

<?php
if (isset($_POST['submit'])) {
    $name= $_POST['name']; 
    $room= $_POST['room']; 
    $notes= $_POST['notes']; 
    $date= $_POST['purchase_date']; 
    $price= $_POST['purchase_price']; 
    $value= $_POST['declared_value']; 
    $cat= $_POST['category'];  
    $date = date('d/m/Y H:i');
    
    
        //INSERT ALL DATA EXCEPT PERMISSIONS
    $insert  = "INSERT INTO items ( user_id, name, room_id, notes, purchase_date, purchase_price, declared_value, category, upload_date, updated, in_trash ) VALUES ( {$_SESSION['user_id']}, '{$name}','{$room}','{$notes}','{$date}','{$price}','{$value}', {$cat}, '{$date}', '{$date}', 0 ) ";
    $insert_result = mysqli_query($connection, $insert);
    if($insert_result){ 
             
        //INSERT INTO HISTORY
        
            //get item id for link in history content
            $get_item = "SELECT * FROM items WHERE name='{$name}' AND user_id={$_SESSION['user_id']} ORDER BY id DESC "; 
            $itemresult = mysqli_query($connection, $get_item);
            if($itemresult){
                $item_found=mysqli_fetch_assoc($itemresult);
                $item_id=$item_found['id'];
            }else{
                $item_id="";
            }
        
            $content = "Added item: <a href=\"item_details.php?id=".$item_id."\">".$name."</a>";
            $history  = "INSERT INTO history ( user_id, content, datetime ) VALUES ( {$_SESSION['user_id']}, '{$content}', '{$date}' ) ";
            $insert_history = mysqli_query($connection, $history); 
        
            $_SESSION["message"] = "Item Saved!";
            redirect_to("inventory.php");        
        }else{
            $_SESSION["message"] = "Item could not be saved";
            redirect_to("inventory.php");
        }//end insert uery    
    }//end check if form was submitted
?>


<form method="POST" >
               
     <!--    //GET ITEM CATEGORIES -->
   <?php
    $category_query  = "SELECT * FROM item_category"; 
    $categoryresult = mysqli_query($connection, $category_query);
    if($categoryresult){ 
        //CATEGORY SELECT BOX
        echo "<p>Category:  <select  name=\"category\">";
        foreach($categoryresult as $category){
            //OPTIONS
            echo "<option value=\"".$category['id']."\" >".$category['name']."</option>"; 
        }
        echo "</select></p>";
    }//end get categories

?>



    <p>Item Title: <input type="text" name="name" placeholder="i.e. Samsung Television" value="" ></p>
    
<!--    //GET ROOMS TO CHOOSE FROM -->
   <?php
        $room_query  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']}"; 
        $roomresult = mysqli_query($connection, $room_query);
        if($roomresult){ 
            //ROOM SELECT BOX
            echo "<p>Room: <select name=\"room\" >";
            foreach($roomresult as $room){
                //OPTIONS
                echo "<option value=\"".$room['id']."\" >".$room['name']."</option>"; 
            }
            echo "</select></p>";
        }//end get rooms 
 ?>
   
   <p>Item Description/Notes: <textarea name="notes" id="notes" cols="30" rows="10" value=""></textarea></p>
     
    <p>Purchase Date: <input type="text" name="purchase_date" placeholder="mm/dd/yyyy" value=""></p>
    <p>Purchase Price: $<input type="text" name="purchase_price" placeholder="950.89" value=""></p>
    <p>Declared Value: $<input type="text" name="declared_value" placeholder="950.99" value=""></p>
   
    <p>Add File (e.x. Image/file of object, reciept, appraisal... )</p>
    <input type="submit" name="submit" value="Save Item">
 </form>
     
        
     <a href="inventory.php" onclick="return confirm('Leave the page? This will not save your item!');">Cancel</a> 
        
<?php include("inc/footer.php"); ?>