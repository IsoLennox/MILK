<?php include("inc/header.php"); ?>


<h1>New Item</h1> 
<form method="POST" >
               
     <!--    //GET ITEM CATEGORIES -->
   <?php
                $category_query  = "SELECT * FROM item_category"; 
                $categoryresult = mysqli_query($connection, $category_query);
                if($categoryresult){ 
                    //CATEGORY SELECT BOX
                    echo "<p>Category:  <select>";
                    foreach($categoryresult as $category){
                        //OPTIONS
                        echo "<option name=\"category\" value=\"".$category['id']."\" >".$category['name']."</option>"; 
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
                    echo "<p>Room: <select>";
                    foreach($roomresult as $room){
                        //OPTIONS
                        echo "<option name=\"room\" value=\"".$room['id']."\" >".$room['name']."</option>"; 
                    }
                    echo "</select></p>";
                }//end get rooms 
 ?>
   
   <p>Item Description/Notes: <textarea name="notes" id="notes" cols="30" rows="10" value=""></textarea></p>
     
    <p>Purchase Date: <input type="text" name="purchase_date" placeholder="mm/dd/yyyy" value=""></p>
    <p>Purchase Price: $<input type="text" name="purchase_price" placeholder="950.89" value=""></p>
    <p>Declared Value: $<input type="text" name="declared_value" placeholder="950.99" value=""></p>
   
    <p>Add File (e.x. Image/file of object, reciept, appraisal... )</p>
    <input type="submit" value="Save Item">
 </form>
     
        
     <a href="inventory.php" onclick="return confirm('Leave the page? This will not save your item!');">Cancel</a> 
        
<?php include("inc/footer.php"); ?>