<?php 
$current_page="inventory";
$sub_page="add_item";
include("inc/header.php"); ?>

<h1>New Item</h1> 

<?php
if (isset($_POST['submit'])) {
    $name= $_POST['name'];
    $name=addslashes($name);
    $name= htmlentities($name);
    
    $room= $_POST['room']; 
    $notes= $_POST['notes']; 
    $pdate= $_POST['purchase_date']; 
    $price= $_POST['purchase_price']; 
    
    //get only dollar amount INT of value
    $value= $_POST['declared_value'];                  
    $dollar= strtok($value, '.');
    $value=preg_replace("/[^0-9]/","",$dollar);
 
     
    
    $cat= $_POST['category'];  
    $date = date('m/d/Y H:i');
    
    if($cat=="--" && empty($name)){
//        $_SESSION['message']="Item name and Category cannot be empty!";
        echo "<div class=\"message\">Item name and Category cannot be empty!</div>";
    
    }elseif($cat=="--"){
//            $_SESSION['message']="Category cannot be empty!";
            echo "<div class=\"message\">Category cannot be empty!</div>";
        }elseif(empty($name)){
//            $_SESSION['message']="Category cannot be empty!";
           echo "<div class=\"message\">Item Name cannot be empty!</div>";
    }else{
    
    
        //INSERT ALL DATA EXCEPT PERMISSIONS
    $insert  = "INSERT INTO items ( user_id, name, room_id, notes, purchase_date, purchase_price, declared_value, category, upload_date, updated, in_trash ) VALUES ( {$_SESSION['user_id']}, '{$name}','{$room}','{$notes}','{$date}','{$price}','{$value}', {$cat}, '{$pdate}', '{$date}', 0 ) ";
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
        
        
        if(isset($_GET['walkthrough'])){
                      $update_profile  = "UPDATE users SET walkthrough_complete=3 WHERE id={$_SESSION['user_id']}";
                        $updated = mysqli_query($connection, $update_profile);
                        $_SESSION["walkthrough"] = "Saved your item! Walkthrough Complete!<br/>Welcome to your dashboard! You can take the walkthrough again by going to 'help'."; 
                        redirect_to('dashboard.php?walkthrough');
                    }else{
                        $_SESSION["message"] = "Item Saved!";
            redirect_to("item_details.php?id=".$item_id); 
                    }
        
                   
        }else{
            $_SESSION["message"] = "Item could not be saved";
            redirect_to("inventory.php");
        }//end insert uery    
        
        }//end make sure no required fields are empty
    }else{

    $name= ""; 
    $room= ""; 
    $notes=""; 
    $pdate= ""; 
    $price= ""; 
    $value= ""; 
    $cat= "";   

}//end check if form was submitted
?>




<!-- NEW ITEM FORM   -->


<form class='add_item' method="POST" >
              
    <label for="name"> Item Name: </label><input type="text"  style="border: 2px solid #90C32E;" id='name' name="name" placeholder=" i.e. Samsung Television" value="<?php echo $name; ?>" > 
     <!--    //GET ITEM CATEGORIES -->
   <?php
    $category_query  = "SELECT * FROM item_category"; 
    $categoryresult = mysqli_query($connection, $category_query);
    if($categoryresult){ 
        //CATEGORY SELECT BOX
        //OPTION VALUE -- NEEDS TO BE ADDED AS CONDITIONAL fOR EMPTY//////////////////////////////////////////
        echo "<label for=\"category\">Item Category: </label><select style=\"border: 2px solid #90C32E;\" id='category' name=\"category\">";
         echo "<option value=\"--\" >--Select Item Category--</option>";
        foreach($categoryresult as $category){
            //OPTIONS
            if($cat==$category['id']){ $selected="selected"; }else{ $selected=""; }
            echo "<option ".$selected." value=\"".$category['id']."\" >".$category['name']."</option>"; 
        }
        echo "</select>";
    }//end get categories

?> 
<!--    //GET ROOMS TO CHOOSE FROM -->
   <?php
        $room_query  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']}"; 
        $roomresult = mysqli_query($connection, $room_query);
        if($roomresult){ 
            //ROOM SELECT BOX
            echo "<label for=\"room\">Room: </label><select id='room' name=\"room\" >";
            foreach($roomresult as $room){
                //OPTIONS
                if($room==$room['id']){ $selected2="selected"; }else{ $selected2=""; }
                echo "<option ".$selected2." value=\"".$room['id']."\" >".$room['name']."</option>"; 
            }
            echo "</select>";
        }//end get rooms 
 ?>
    <fieldset class='form_blocks'>
        <label for="notes">Item Description/Notes: </label><textarea name="notes" id="notes" cols="30" rows="12" value="<?php echo $notes; ?>"><?php echo $notes; ?></textarea>
    </fieldset>

    <fieldset class='form_blocks'>
        <label for="purchase_date">Purchase Date: </label><input type="text" id="purchase_date" name="purchase_date" placeholder="mm/dd/yyyy" value="">
        <label for="purchase_price">Purchase Price: $</label><input type="text" id="purchase_price" name="purchase_price" placeholder="950" value="">
        <label for="declared_value">Declared Value: $</label><input type="text" id="declared_value" name="declared_value" placeholder="950" value="">
    </fieldset>
    <input type="submit" name="submit" value="Next">
   <? if(!isset($_GET['walkthrough'])){ ?>
     <a href="inventory.php" onclick="return confirm('Leave the page? This will not save your item!');"><i class="fa fa-times"></i> Cancel</a> 
  <?php } ?>
    
 </form>
 

        
              
    <script>
    //make sure not empty, before submit
        
        
        //CATEGORY
           $(document).ready(function () {
    $("#category").blur(function () {
      var input = $(this).val();
      if (input == '--') {
        $("#category").css({"border": "5px solid #E43633"});
      }else{
        $("#category").css({"border": "1px solid grey"});
      }
    });
  
          
     //TITLE
    $("#name").blur(function () {
      var input = $(this).val();
      if (input == '') {
        $("#name").css({"border": "5px solid #E43633"});
      }else{
        $("#name").css({"border": "1px solid grey"});
      }
    });
  });
 
     
     </script>      
<?php include("inc/footer.php"); ?>