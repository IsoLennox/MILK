<?php $current_page="inventory";
include("inc/header.php"); 
$_SESSION['upload_type'] = 'item';
?>

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
            $content = "<span class=\"remove_history\">Removed item: <a href=\"item_details.php?id=".$item_id."\">".$name."</a></span>";
            $history  = "INSERT INTO history ( user_id, content, datetime ) VALUES ( {$_SESSION['user_id']}, '{$content}', '{$date}' ) ";
            $insert_history = mysqli_query($connection, $history); 
            
            
        $_SESSION["message"] = "Item Removed!";
        redirect_to('inventory.php');

        } else {
        // Failure
        $_SESSION["message"] = "Could not delete item";
       header('Location: ' . $_SERVER['HTTP_REFERER']);

        }//END REMOVE ITEM
    
    
   
    
}elseif(isset($_GET['remove_img'])){ 
    $item_id=$_GET['remove_img'];  
    
        $update_item  = "DELETE FROM item_img WHERE id = {$item_id} LIMIT 1";
        $result = mysqli_query($connection, $update_item);

        if ($result && mysqli_affected_rows($connection) == 1) {
        // Success 

            $_SESSION["message"] = "Item Document Removed!";
            header('Location: ' . $_SERVER['HTTP_REFERER']);

        } else {
        // Failure
            $_SESSION["message"] = "Could not delete item document";
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
    
    
   
    
}elseif(isset($_POST['save_title'])){ 
    
     
    
    $item_id=$_GET['id'];
    $image_id=$_GET['edit_img'];
    $new_title=addslashes($_POST['new_title']);
    
        $item_img  = "UPDATE item_img SET title = '{$new_title}' WHERE id={$image_id} ";
        $insert_item_img = mysqli_query($connection, $item_img); 
    if($insert_item_img){

        $_SESSION["message"] = "Image Renamed!";
        redirect_to('item_details.php?id='.$item_id);

        } else {
        // Failure
        $_SESSION["message"] = "Could not rename image";
       redirect_to('item_details.php?id='.$item_id);

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
                    $edit="<p class='disabled text_left'><i class=\"fa fa-pencil\"></i> Cannot Edit</p>";
                    $upload="<button type=\"button\" disabled>Add Photos &amp; Files</button>";
                    $upload_form="";
                    $img_delete=" <p class='disabled text_right'> <i class=\"fa fa-trash-o\"></i></p>";
                    $img_edit="<p class='disabled text_left'><i class=\"fa fa-pencil\"></i></p>";
                    
                    echo "<h1>".$show['name']."</h1>";
                    if($show['user_id']===$_SESSION['user_id']){ 
                        echo $edit;
                        echo $in_trash;
                    }
                    echo "<hr>";
                    echo "<div class=\"item_display\">";              
                    echo "<h3>Item Details</h3>";
                    echo "<p><a href=\"claim_details.php?id=".$claim_array['claim_id']."\" ><strong  style=\"color:#FF4503;\">This Item Is Involved In Claim <span class='dark_link'>#".$claim_array['claim_id']."</span></strong></a></p>";
                    

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
                    

                    $upload_form="<form action=\"image_handling1.php\" method=\"post\" enctype=\"multipart/form-data\">
                                Upload an Image or PDF:<br/>
                                <input type=\"file\" name=\"image\" id=\"fileToUpload\"><br/>
                                <input type=\"hidden\" value=\"".$_GET['id']."\" name=\"item_id\">
                               <p> Title: <input type=\"text\" value=\"\" name=\"title\" placeholder=\"i.e. Image of item..\" ></p><br/>
                                <input type=\"submit\" value=\"Upload File\" name=\"submit\">
                                </form>";
                }

                    $room_name=get_room_name($show['room_id']);
                    $cat_name=get_category_name($show['category']);
                    echo "<p><strong>Category:</strong> ".$cat_name."</p>";
                  if(empty($room_name)){
                        $room_name="Room not selected";
                    }
                    echo "<p><strong>Room:</strong> ".$room_name . "</p>";
                    //GET ALL OTHER DETAILS
                    echo "<p><strong>Purchase Date:</strong> ".$show['purchase_date']."</p>"; 
                    echo "<p><strong>Purchase Price:</strong> $".$show['purchase_price']."</p>"; 
                    echo "<p><strong>Declared Value:</strong> $".$show['declared_value']."</p>"; 
                    echo "<p><strong>Description/Notes:</strong><br/><div class=\"notes_container\">".$show['notes']."</div></p>";

                

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
                        if(($show['in_trash']==0) && ($show['user_id']===$_SESSION['user_id'])){
                            echo $upload;
                        }
                    }
                    echo "</div>"; //end container
                    echo "<div class=\"clearfix\"></div>";
    //            GET GALLERY  
                    $image_query  = "SELECT * FROM item_img WHERE item_id={$id}"; 
                    $image_result = mysqli_query($connection, $image_query);
                    $image_num = mysqli_num_rows($image_result);
                if($image_num >=1){
                    echo "<div class=\"gallery\">";

                        foreach($image_result as $image){
                        if($claim_num == 0){
                            $img_edit="<a class='img_edit' href=\"item_details.php?id=".$id."&edit_img=".$image['id']."\"><i class=\"fa fa-pencil\"></i> Edit </a>";
                            $img_delete="<a class='img_edit' onclick=\"return confirm('DELETE this document? This cannot be undone.');\" href=\"item_details.php?remove_img=".$image['id']."\"> <i class=\"fa fa-trash-o\"></i> Delete</a>";
                        }   
                        //IF ! ENDS IN PDF, SHOW IMAGE, ELSE SHOW ICON
                        echo "<div>";
                        if($image['is_img']==1){
                            $file= "<a href=\"" .$image['file_path'] . "\" title='" .$image['title']. "' class='fancybox' rel=\"group\"><div class=\"img_container\"><img class=\"thumb_avatar\" onerror=\"this.src='images/no_img.PNG'\"  src=\"".$image['thumb_path']."\"></div></a>";

                        }else{ 
                            $file= "<p><i class=\"fa fa-5x fa-file-pdf-o\"></i></p>";
                        }

                        if(empty($image['title'])){ $image['title']="Untitled";}
 
                        echo $file ."<h5>".$image['title']."</h5>";  
                        if(isset($_GET['edit_img']) && $_GET['edit_img']==$image['id']){
                            //Show edit title form
                            ?>
                            <div id="edit_img_title">
                            <form method="POST">
                                <input type="text" name="new_title" value="<?php echo $image['title']; ?>">
                                <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>"> 
                                <input type="submit" name="save_title" value="Save Title">
                            </form>
                            <a href="item_details.php?id=<?php echo $id; ?>">Cancel</a>
                            </div>
                            <hr/>
                            <?php
                        
                        }else{
                            if ($show['user_id']===$_SESSION['user_id']){
                                echo $img_edit;
                                echo $img_delete;
                            }
                        }
                        echo "</div>"; //end each container
                    }
                    echo "</div>";//end gallery
                
            
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
     
 
        
    <script type="text/javascript">
        $(document).ready(function() {
            $(".fancybox").fancybox({
                //for alt text
              afterShow: function(){
                $('.fancybox-title').wrapInner('<div />').show();

                $('.fancybox-wrap').hover(function(){
                  $('.fancybox-title').show(); //when hover on show title
                }, function(){
                  $('.fancybox-title').hide(); //when hover off hide title
                }); //end hover
              }, //end after show
              helpers: {
                title: {
                  type: 'over'
                } //title
              } //helper
            });
        });
    </script>     
        
<?php include("inc/footer.php"); ?>