<?php $current_page="inventory";
include("inc/header.php"); ?>
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
            $date = date('m/d/Y H:i');
            $content = "Removed item: <a href=\"item_details.php?id=".$item_id."\">".$name."</a>";
            $history  = "INSERT INTO history ( user_id, content, datetime ) VALUES ( {$_SESSION['user_id']}, '{$content}', '{$date}' ) ";
            $insert_history = mysqli_query($connection, $history); 
            
            
        $_SESSION["message"] = "Item Removed!";
        redirect_to('inventory.php');

        } else {
        // Failure
        $_SESSION["message"] = "Could not delete item";
       header('Location: ' . $_SERVER['HTTP_REFERER']);

        }//END REMOVE ITEM
    
    
   
    
}elseif(isset($_GET['restore'])){ 
    $item_id=$_GET['restore'];
    $name=$_GET['item']; 
    
    //UPDATE item to in_trash=1
    
        $update_item  = "UPDATE items SET in_trash = 0 ";
        $update_item .= "WHERE id = {$item_id} ";
        $result = mysqli_query($connection, $update_item);

        if ($result && mysqli_affected_rows($connection) == 1) {
        // Success 
            
             //INSERT into history table
            $date = date('m/d/Y H:i');
            $content = "Restored item: <a href=\"item_details.php?id=".$item_id."\">".$name."</a>";
            $history  = "INSERT INTO history ( user_id, content, datetime ) VALUES ( {$_SESSION['user_id']}, '{$content}', '{$date}' ) ";
            $insert_history = mysqli_query($connection, $history); 
            
            
            $_SESSION["message"] = "Item Restored!";
            redirect_to('item_details.php?id='.$item_id);

        } else {
        // Failure
        $_SESSION["message"] = "Could not restore item";
        redirect_to('inventory.php');

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
                
                //SEE IF ITEM IS IN TRASH
                if($show['in_trash']==1){
                   $in_trash= "<p class='alert_message'><a class='large_link' href=\"item_details.php?restore=".$show['id']."&item=".$show['name']."\">This item was removed. Restore it?</a></p><br>";
                }else{
                    $in_trash=" <a class='large_link text_right ' onclick=\"return confirm('DELETE this item?')\" href=\"item_details.php?remove=".$show['id']."&item=".$show['name']."\"><i class=\"fa fa-trash-o\"></i> Remove Item</a>";
                } 

                    //IF IS INVOLDED IN CLAIM, SHOW CLAIM ID/LINK AND REMOVE TRASH/EDIT OPTION
                    $claim_query  = "SELECT * FROM claim_items WHERE item_id={$id}"; 
                    $claim_result = mysqli_query($connection, $claim_query);
                    $claim_num = mysqli_num_rows($claim_result);
    //            if($claim_result){
                if($claim_num >=1){
                    $claim_array=mysqli_fetch_assoc($claim_result);
                    $in_trash=" <p class='disabled text_right'> <i class=\"fa fa-trash-o\"></i> Cannot Remove Item</p>";
                    $edit="<p class='disabled text_left' href=\"edit_item.php?id=".$show['id']."\"><i class=\"fa fa-pencil\"></i> Cannot Edit</p>";
                    $upload="<button type=\"button\" disabled>Add Photos &amp; Files</button>";
                    $upload_form="";
                    echo "<h1>".$show['name']."</h1>"; 
                    echo $edit;
                    echo $in_trash;
                    echo "<hr>";
                    echo "<div class=\"item_display\">";              
                    echo "<h3>Item Details</h3>";
                    echo "<p><strong>This item is involved in <a href=\"claim_details.php?id=".$claim_array['claim_id']."\">CLAIM #".$claim_array['claim_id']."</a></strong></p>";
                    

                }else{
                    $edit="<a class='large_link text_left' href=\"edit_item.php?id=".$show['id']."\"><i class=\"fa fa-pencil\"></i> Edit Item</a>";
                    $upload="<a href=\"item_details.php?add_image&id=".$show['id']."\"><input type=\"submit\" value=\"Add Photos &amp; Files\"></a>";

                    echo "<h1>".$show['name']."</h1>"; 
                    if($show['in_trash']==0){
                        echo $edit;
                    }
                    echo $in_trash;
                    echo "<hr>";
                    echo "<div class=\"item_display\">";
                  
                    echo "<h3>Item Details</h3>";
                    

                    $upload_form="<form action=\"upload_item_img.php\" method=\"post\" enctype=\"multipart/form-data\">
                                Upload an Image or PDF:<br/>
                                <input type=\"file\" name=\"image\" id=\"fileToUpload\"><br/>
                                <input type=\"hidden\" value=\"".$_GET['id']."\" name=\"item_id\">
                               <p> Title: <input type=\"text\" value=\"\" name=\"title\" placeholder=\"i.e. Image of item..\" ></p><br/>
                                <input type=\"submit\" value=\"Upload File\" name=\"submit\">
                                </form>";
                }

                    $room_name=get_room_name($show['room_id']);
                    $cat_name=get_category_name($show['category']);
                    echo "<p>Category: ".$cat_name."</p>";
                  if(empty($room_name)){
                        $room_name="Room not selected";
                    }
                    echo "<p>Room: ".$room_name . "</p>";
                    //GET ALL OTHER DETAILS
                    echo "<p>Purchase Date: ".$show['purchase_date']."</p>"; 
                    echo "<p>Purchase Price: $".$show['purchase_price']."</p>"; 
                    echo "<p>Declared Value: $".$show['declared_value']."</p>"; 
                    echo "<p>Description/Notes:<br/>".$show['notes']."</p>";

                

                echo "</div>";//end container
                
                echo "<div class=\"item_display\">";
                
                    echo "<h3>File Attachments</h3>";
                    echo "<p>Images, Reciepts, Appraisals, and other documents that prove the condition, value, and ownership of this item.</p>";
                    if(isset($_GET['add_image'])){ 
                        $item_id=$_GET['add_image']; 
                        if($show['in_trash']==0){
                            echo $upload_form;
                        }
                    }else{
                        if($show['in_trash']==0){
                            echo $upload;
                        }
                    }

    //            GET GALLERY
                    //HOW TO COMPRESS IMAGES???
                    $image_query  = "SELECT * FROM item_img WHERE item_id={$id}"; 
                    $image_result = mysqli_query($connection, $image_query);
                    $image_num = mysqli_num_rows($image_result);
                if($image_num >=1){
                    echo "<div class=\"gallery\">";

                        foreach($image_result as $image){ 
                        //IF ! ENDS IN PDF, SHOW IMAGE, ELSE SHOW ICON
                        if($image['is_img']==1){
                            $file= "<img style=\"width:50px;\" class=\"thumbnail\" src=\"".$image['file_path']."\">";

                        }else{
                            $file= "<i class=\"fa fa-file-o\"></i>";
                        }
                        if(empty($image['title'])){ $image['title']="Untitled";}
                        echo "
                        <a href=\"#\" alt=\"View full size image\" >".$file."</a>
                        <span class=\"caption\">".$image['title']."</span> 
                        <span class=\"right\">
                        <a href=\"#\"><i class=\"fa fa-pencil\"></i> Edit</a>
                        <a href=\"#\"><i class=\"fa fa-trash-o\"></i> Delete</a></span>";
                        }
                    echo "</div>";//end gallery
                echo "</div>"; //end container
            
            }
                
              
                //obviously, we will style this to make it a button/icon and out of the way
                
                // echo $in_trash;

                }else{
                //No permission to view this item
                echo "<p>Oops! It seems this is not your item.</p>";
            }
        }
    }else{
        echo "<p>This item seems to have been removed!</p>";
    }
    
    
    
}else{
    echo "<p>This item seems to have been removed!</p>";
}
echo "<div class=\"clearfix\"></div>";
?>
 
 

           
 
        
      
        
<?php include("inc/footer.php"); ?>