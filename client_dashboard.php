<?php 

                    //*****************
                    //    ROOMS
                    //*****************



//GET NUMBER OF ROOMS
    $rooms=0;
    $room_count  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']} ORDER BY name";  
    $room_result = mysqli_query($connection, $room_count);
    $num_rooms=mysqli_num_rows($room_result);
    
    //get items for each room

function item_array($array, $key, $value){
                    $array[$key] = $value;
                    return $array;
                }

 echo "<div class=\"stats\"> ";
//echo "<h3>You have ".$num_rooms." rooms <h3>";
echo "<h3>You have ".$num_rooms." rooms </h3> <p>Showing 4 of ".$num_rooms." Rooms</p><br/>";
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
    //ordered by most recent and added room for another room!//////////////////////////////////////////////////////////////
    $roomquery  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']} ORDER BY id DESC LIMIT 4";  
    $roomresult = mysqli_query($connection, $roomquery);
    if($roomresult){ 
        $rooms=array();
        //show each result value
       
        foreach($roomresult as $show){
              echo "<div class=\"one-third\"> ";
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
            echo "<h4><a href=\"room_details.php?id=".$show['id']."\">".$show['name']."</a><br/> (".$item_count." items)</h4>";
            
            //PUT ALL ROOMS INTO ARRAY TO USSE IN HIGHCHARTS
//            array_push($rooms , "{name: '".$show['name']."', data: [5, 3, 4, 7, 2] }");
           
                if(!empty($item_array)){
                     echo "<ul>";
                        foreach($item_array as $id=>$name){
                            echo "<li><a href=\"item_details.php?id=".$id."\" >".$name."</a></li>";
                        }
                    echo "</ul>"; //end item list
                }
            
            echo "</div>"; //end one-third
            }
        echo "<div class=\"clearfix\"></div>";
        echo "<br><p><a class=\"right\" href=\"rooms.php\">View all rooms <i class=\"fa fa-angle-double-right\"></i></a></p>";
        
        }//END SHOW 3 ROOMS AND ITEMS IN THEM
        

        //COUNT ROOMS FOR FOR LOOP TO ECHO EACH OUT IN HIGH CHARTS
        $count_rooms=0;
        foreach($rooms as $room_array){
            $count_rooms++;
        //    echo $room_array; 
        }
                   
            echo "</div>";




                    //*****************
                    //    ITEMS
                    //*****************





          echo "<div class=\"stats\">";

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
            
            
            if($total_items==0){
                echo "<a href=\"add_item.php\">Add your first item!</a>";
               
            }


//            GET 10 ITEMS ORDER BY LAST ADDED
            echo "<div class=\"half_div\">";
                echo "<h3>You have ".$total_items." items</h3>";

    //            SHOW ITEM TYPES

                if(!empty($categories)){
                $words = explode(",", $categories);
                $result = array_combine($words, array_fill(0, count($words), 0));

                foreach($words as $word) {
                $result[$word]++;
                }
                        echo "<ul>";
                foreach($result as $word => $count) {
                    if($word!==""){
                        echo "<li>$count items in $word.</li>";
                    }
                }
                    echo "</ul>";
                }

            echo "</div>"; //end half
if(!empty($total_items)){
            echo "<span class=\"half_div\">"; 
                //SHOW RECENTLY ADDED ITEMS
                $recent_item_query  =  "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0 ORDER BY id DESC LIMIT 10";   
                $recent_item_result = mysqli_query($connection, $recent_item_query);
                if($recent_item_result){
                    echo "<h3>Recently Added Items</h3>";
                    echo "<ul>";
                foreach($recent_item_result as $item){ echo "<li><a href=\"item_details.php?id=".$item['id']."\">".$item['name']."</a></li>"; }
                    echo "</ul>";
                    echo "<br/><p><a class=\"right\" href=\"inventory.php\">View all items <i class=\"fa fa-angle-double-right\"></i></a></p>";
                    }//end get recent items

            echo "</span>"; //end half
}
    
       
       echo "</div>";



                    //*****************
                    //    CLAIMS
                    //*****************




        echo "<div class=\"stats\">";
   
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
          
          <span class="half_div">
              
            <a href="claim_history.php"><i class="fa fa-folder-open"></i> All Claims</a> (<?php echo $data['total']; ?>)<br/>
            <a href="claim_history.php?approved"><i class="fa fa-check green"></i> Approved </a> (<?php echo $adata['total']; ?>)<br/>
            <a href="claim_history.php?denied"><i class="fa fa-times red"></i> Denied </a> (<?php echo $ddata['total']; ?>)<br/>             
            <a href="claim_history.php?pending"><i class="fa fa-clock-o "></i> Processing </a> (<?php echo $pdata['total']; ?>)<br/>            
            <a href="claim_history.php?changes"><i class="fa fa-pencil"></i> Pending Changes </a> (<?php echo $cdata['total']; ?>) <br/>
            <a href="claim_history.php?draft"><i class="fa fa-file-o "></i> Drafts </a> (<?php echo $drdata['total']; ?>) <br/>
            
            </span>
            
            
            <span class="half_div">
<!--            IF ANY DRAFTS, SHOW BY ID ASC-->
   <?php
    $get_draft  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=1 ORDER BY id LIMIT 1";  
    $draft_result = mysqli_query($connection, $get_draft); 
    $draft_rows=mysqli_num_rows($draft_result);
    if($draft_rows >=1){
        echo "<h2>Finish This Draft</h2><br/>";
         $draft_details=mysqli_fetch_assoc($draft_result);
        echo "<h4>".$draft_details['title']."</h4>";
        echo "<p>".$draft_details['notes']."</p>";
        echo "<a href=\"claim_details.php?id=".$draft_details['id']."\">Edit Claim</a>";
    }else{
//    IF NO DRAFTS, SHOW LAST CLAIM SUBMITTED, AND ITS STATUS
        echo "<h2>Most Recent Claim</h2><br/>";
        $get_claim  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} ORDER BY id LIMIT 1";  
        $claim_result = mysqli_query($connection, $get_claim); 
        $claim_rows=mysqli_num_rows($claim_result);
        if($claim_rows >=1){
             $claim_details=mysqli_fetch_assoc($claim_result);
            echo "<h4>".$claim_details['title']."</h4>";
            echo "<p>".$claim_details['notes']."</p>";
            echo "<a href=\"claim_details.php?id=".$claim_details['id']."\">View Claim</a>";

        }else{

            //IF NO CLAIMS SUBMITTED, SHOW...
            echo "<h2>You have made no claims!</h2>";
        }
    
    }
?> 
            
</span>
            
            
<!--            MOST RECENTLY ADDED ITEMS -->

    </ul>
    </div>
<!--    </div>-->

 