<?php 
$current_page="inventory";
$sub_page="view_rooms";
include("inc/header.php");  ?>
<!--<h1>Your Rooms</h1>-->
  <?php  

//INSERT NEW ROOM FROM FORM BELOW

    if(isset($_POST['submit'])){
        if(empty($_POST['name'])){
            $_SESSION["message"] = "Name Cannot be Empty";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }else{
            $name=$_POST['name'];
            if(!empty($_POST['notes'])){
            $notes=$_POST['notes'];
            }else{
            $notes="";
            }
            
                $query  = "INSERT INTO rooms (name, notes, user_id) VALUES ('{$name}','{$notes}', {$_SESSION['user_id']})";  
                $result = mysqli_query($connection, $query);
//                $num_rows=mysqli_num_rows($result);
//                if($num_rows>=1){
                if(!empty($result)){
                    
                    
                  if(isset($_GET['walkthrough'])){
                      $update_profile  = "UPDATE users SET walkthrough_complete=2 WHERE id={$_SESSION['user_id']}";
                       $updated = mysqli_query($connection, $update_profile);
                        $_SESSION["walkthrough"] = "Added ".$name."! <br/>Last Step: Let's add your first item!"; 
                        redirect_to('add_item.php?walkthrough');
                    }else{
                        $_SESSION["message"] = "Added ".$name."!"; 
                        redirect_to('rooms.php');
                    }
                    
                    
                    
                    }else{
                        echo "Could not add this room";
                    }
            
            
            
            }
    }  ?>
<!-- SHOW ALL ROOMS BELOGING TO LOGGED IN USER   -->

<div id="rooms" class="left half_div">

 <h2>Your Rooms</h2> 
<?php  

                function item_array($array, $key, $value){
                    $array[$key] = $value;
                    return $array;
                }

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
            echo "<div class=\"notes_container \">";
            echo "<h4><a href=\"room_details.php?id=".$show['id']."\">".$show['name']."</a> <br/>(".$item_count." items)</h4>";
           
                if(!empty($item_array)){
                     echo "<ul>";
                    foreach($item_array as $id=>$name){
                        echo "<li><a href=\"item_details.php?id=".$id."\" >".$name."</a></li>";
                    }
                    echo "</ul>";
                }
            echo "</div>";
 
            }
        }
 ?> 
</div> <!-- END ROOMS -->
      
<!--      ADD A ROOM  -->
<form class="fixed_add_room" method="POST">
    <h2>Add A Room</h2>
    <label for="room_name">Room Name: </label><input id='room_name' type="text" name="name" placeholder="e.x. Bedroom.."><br/>
    <label for="room_notes">Room Notes:</label><textarea id='room_notes' cols="20" rows="8"  name="notes" placeholder="e.x. This room is in the guest house..."></textarea><br/> 
    <input name="submit" type="submit" value="Save Room">
</form> 
          

<div class="clearfix"></div>
        
<?php include("inc/footer.php"); ?>