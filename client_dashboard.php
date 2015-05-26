    <ul>  
<?php //NUMBER OF ROOMS
    $rooms=0;
    $room_count  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']}";  
    $room_result = mysqli_query($connection, $room_count);
    $num_rooms=mysqli_num_rows($room_result);
    
    //get items for each room

function item_array($array, $key, $value){
                    $array[$key] = $value;
                    return $array;
                }

 echo "<div class=\"one-third\">";
echo "<li>You have ".$num_rooms." rooms: </li>";
if($num_rooms==0){
?>
        
    
        <!--      ADD A ROOM  -->
<form  method="POST" action="rooms.php">
    <h2>Add A Room</h2>
    <label for="room_name">Room Name: </label><input id='room_name' type="text" name="name" placeholder="e.x. Bedroom.."><br/>
    <label for="room_notes">Room Notes:</label><textarea id='room_notes' cols="20" rows="8"  name="notes" placeholder="e.x. This room is in the guest house..."></textarea><br/> 
    <input name="submit" type="submit" value="Save Room">
</form> 
            
            <?php }
  
    $roomquery  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']}";  
    $roomresult = mysqli_query($connection, $roomquery);
    if($roomresult){ 
        //show each result value
        foreach($roomresult as $show){
                $item_count=0;
                $item_array=array();

            
                $item_query  = "SELECT * FROM items WHERE room_id={$show['id']} AND in_trash=0";  
                $item_result = mysqli_query($connection, $item_query);
            if($item_result){
                foreach($item_result as $item){  
                    $item_count++; 
                    $item_array = item_array($item_array, $item['id'], $item['name']);
                 }
            }
            echo "<h4><a href=\"room_details.php?id=".$show['id']."\">".$show['name']."</a> (".$item_count." items)</h4>";
           
                if(!empty($item_array)){
                     echo "<ul>";
                    foreach($item_array as $id=>$name){
                        echo "<li><a href=\"item_details.php?id=".$id."\" >".$name."</a></li>";
                    }
                    echo "</ul>";
                }
 
            }
        }
        
            echo "</div>";
          echo "<div class=\"one-third\">";

//TOTAL ITEMS  
            $total_item_query  =  "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0";   
            $total_item_result = mysqli_query($connection, $total_item_query);
            $total_items=0; 
            $categories;
            foreach($total_item_result as $item){
                    $total_items++;
                
                //TOTAL ITEMS IN EACH CATEGORY
                $category_query  = "SELECT * from item_category WHERE id={$item['category']}";   
                $category_result = mysqli_query($connection, $category_query);
                foreach($category_result as $cat){
//                    array_push($categories,$cat['name']);
                    $categories=$categories.",".$cat['name'];
                }
                
                
            }
            echo "You have ".$total_items." items<br/>";
            
            if($total_items==0){
//                echo "<a href=\"add_item.php\">Add your first item!</a>";
                ?>
                <br/>
                <h2>Add Item</h2>
                <form class='add_item' action="add_item.php" method="POST" >
              
    <label for="name"> Item Name: </label><input type="text"  style="border: 2px solid #90C32E;" id='name' name="name" placeholder=" i.e. Samsung Television" value="<?php echo $name; ?>" > 
     <!--    //GET ITEM CATEGORIES -->
   <?php
    $category_query  = "SELECT * FROM item_category"; 
    $categoryresult = mysqli_query($connection, $category_query);
    if($categoryresult){  
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

<!--    <fieldset class='form_blocks'>-->
        <label for="purchase_date">Purchase Date: </label><input type="text" id="purchase_date" name="purchase_date" placeholder="mm/dd/yyyy" value="">
        <label for="purchase_price">Purchase Price: $</label><input type="text" id="purchase_price" name="purchase_price" placeholder="950" value="">
        <label for="declared_value">Declared Value: $</label><input type="text" id="declared_value" name="declared_value" placeholder="950" value="">
<!--    </fieldset>-->
    <input type="submit" name="submit" value="Next"> 
 </form>
           
           
           <?php
            }

            $words = explode(",", $categories);
            $result = array_combine($words, array_fill(0, count($words), 0));

            foreach($words as $word) {
            $result[$word]++;
            }

            foreach($result as $word => $count) {
                if($word!==""){
                    echo "There are $count instances of $word.<br/>";
                }
            }

            
    
    
       
       echo "</div>";
        echo "<div class=\"one-third\">";
   
    $claims=0;
    $claim_count  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']}";  
    $claim_result = mysqli_query($connection, $claim_count);
    $num_claims=0;
    if($claim_result){
        foreach($claim_result as $claim){
        $num_claims++;
    }
    }
//    echo "<li>You have made ".$num_claims." claims</li>";



 
        //GET COUNTS
            $all_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']}";   
            $all_result = mysqli_query($connection, $all_query);
            $data=mysqli_fetch_assoc($all_result);

            $pending_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=0";   
            $pending_result = mysqli_query($connection, $pending_query);
            $pdata=mysqli_fetch_assoc($pending_result); 
                
            $draft_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=1";   
            $draft_result = mysqli_query($connection, $draft_query);
            $drdata=mysqli_fetch_assoc($draft_result); 

                
            $changes_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=4";   
            $changes_result = mysqli_query($connection, $changes_query);
            $cdata=mysqli_fetch_assoc($changes_result); 


            $approved_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=2";   
            $approved_result = mysqli_query($connection, $approved_query);
            $adata=mysqli_fetch_assoc($approved_result); 

            $denied_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=3";   
            $denied_result = mysqli_query($connection, $denied_query);
            $ddata=mysqli_fetch_assoc($denied_result); 
        ?>
          
          <li><a href="claim_history.php"><i class="fa fa-list black"></i> All Claims </a> (<?php echo $data['total']; ?>)</li>
           <li><a href="claim_history.php?draft"><i class="fa fa-caret-square-o-right orange"></i> Drafts </a> (<?php echo $drdata['total']; ?>)</li>
           <li><a href="claim_history.php?pending"><i class="fa fa-caret-square-o-right blue"></i> Processing </a> (<?php echo $pdata['total']; ?>)</li>
           <li><a href="claim_history.php?approved"><i class="fa fa-caret-square-o-right green"></i> Approved </a> (<?php echo $adata['total']; ?>)</li>
           <li><a href="claim_history.php?changes"><i class="fa fa-caret-square-o-right yellow"></i> Pending Changes </a> (<?php echo $cdata['total']; ?>)</li>
           <li><a href="claim_history.php?denied"><i class="fa fa-caret-square-o-right red"></i> Denied </a> (<?php echo $ddata['total']; ?>)</li>

    </ul>
    </div></div>