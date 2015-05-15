<?php
$current_page="inventory";
include("inc/header.php"); ?>

<?php 


if(isset($_POST['submit'])){
    echo "submitted!";
    // UPDATE TABLE 
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
                    echo "<p>Category:  <select>";
                    foreach($categoryresult as $category){
                        //OPTIONS
                        
                        if($category['id']==$name['category']){ $selected = "selected";}else{ $selected="";}
                        echo "<option {$selected} name=\"category\" value=\"".$category['id']."\" >".$category['name']."</option>";  
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
                    echo "<p>Room: <select>";
                    foreach($roomresult as $room){
                        //OPTIONS
                         if($room['id']==$name['room_id']){ $selected = "selected";}else{ $selected="";}
                        echo "<option {$selected} name=\"room\" value=\"".$room['id']."\" >".$room['name']."</option>"; 
                    }
                    echo "</select></p>";
                }//end get rooms 
 ?>
   
   <p>Item Description/Notes: <textarea name="notes" id="notes" cols="30" rows="10" value="<?php echo $name['notes']; ?>"><?php echo $name['notes']; ?></textarea></p>
     
    <p>Purchase Date: <input type="text" name="purchase_date" placeholder="mm/dd/yyyy" value="<?php echo $name['purchase_date']; ?>"></p>
    <p>Purchase Price: $<input type="text" name="purchase_price" placeholder="950.89" value="<?php echo $name['purchase_price']; ?>"></p>
    <p>Declared Value: $<input type="text" name="declared_value" placeholder="950.99" value="<?php echo $name['declared_value']; ?>"></p>
   
    <p>Add File (e.x. Image/file of object, reciept, appraisal... )</p>
    <input type="submit" name="submit" value="Save Item">
 </form>
     
         
<a href="item_details.php?id=<?php echo $id; ?>"  onclick="return confirm('Leave the page? This will not save your item!')" >Cancel</a>
           <?php } ?>
           
           
           
 
     
        
      
        
<?php include("inc/footer.php"); ?>