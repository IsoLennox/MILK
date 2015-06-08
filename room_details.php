<?php $current_page="inventory";
include("inc/header.php"); ?>
<?php 

if(isset($_GET['id'])){ ?>
<!--VIEW ROOM-->
<p><a href="rooms.php">&laquo; All Rooms</a></p>
 
 <?php
 				
    //Get room selected: 
    $query  = "SELECT * FROM rooms WHERE id={$_GET['id']}"; 
    $result = mysqli_query($connection, $query);
    if($result){
        foreach($result as $show){
            echo "<h2>".$show['name']."</h2>";
            echo "<p >".$show['notes']."</p>";
            echo "<a href=\"room_details.php?room=".$_GET['id']."\"><i class=\"fa fa-pencil\"></i> Edit Room Details</a> <br/><br/>";
            
                $item_query  = "SELECT * FROM items WHERE room_id={$_GET['id']} AND in_trash=0"; 
                $itemresult = mysqli_query($connection, $item_query);

               
                if($itemresult){
                    echo "<h3><strong>Items in this room: </strong><h3>";
                    // echo "<ul>";
                    foreach($itemresult as $item){

                    	$item_img = "SELECT * FROM item_img WHERE item_id={$item['id']} AND is_img=1 ORDER BY id DESC LIMIT 1 ";
		                $item_img_result = mysqli_query($connection, $item_img);
		                $total_img_array=mysqli_fetch_assoc($item_img_result);
		                $thumbnail=$total_img_array['file_path'];
		                $title=$total_img_array['title'];
                        $img_item_rows=mysqli_num_rows($item_img_result);


		                echo "<div class='img_full_thumb'><img src=\"{$thumbnail}\" onerror=\"this.src='http://lorempixel.com/300/300/abstract'\" alt=\"{$title}\">";
		                


                        echo "<div class='img_title'> <a href=\"item_details.php?id=".$item['id']."\">".$item['name']."</div></div>"; 
                    }
                    // echo "</ul>";
                }//end get items in room

            }
        }
  }elseif(isset($_GET['room'])){ 
    //EDIT ROOM
    $query  = "SELECT * FROM rooms WHERE id={$_GET['room']} "; 
    $result = mysqli_query($connection, $query);
    if($result){
        $room_details=mysqli_fetch_assoc($result);
        echo "<h1>Edit Room: ".$room_details['name']." </h1>"; ?>
             <form action="room_details.php?submit" method="POST">
                 
                 Name:<input type="text" name="name" id="name" value="<?php echo $room_details['name'] ?>"><br/>
                 Room Notes:<br/>
                 <input type="hidden" name="id" value="<?php echo $room_details['id'] ?>">
                 <textarea name="notes" id="notes" cols="20" rows="10" value="<?php echo $room_details['notes'] ?>"><?php echo $room_details['notes'] ?></textarea>
                 <input type="submit" name="submit" id="submit" value="Save Room">
             </form>
        
<?php     }
    
        echo "<a onclick=\"return confirm('Leave the page? This will not save your changes!')\" href=\"room_details.php?id=".$_GET['room']."\">Cancel</a>";

}elseif(isset($_GET['submit'])){ 
    //SAVE ROOM EDITS
    if(!empty($_POST['name'])){
        
        $name=mysql_escape_string($_POST['name']);
        $notes=mysql_escape_string($_POST['notes']);
        $id=$_POST['id'];
        
            $update_room  = "UPDATE rooms SET name = '{$name}', notes='{$notes}' ";
            $update_room .= "WHERE id = {$id} ";
            $result = mysqli_query($connection, $update_room);

            if ($result && mysqli_affected_rows($connection) == 1) {
                // Success 
                $_SESSION["message"] = "Room Updated!";
                redirect_to('room_details.php?id='.$id);

            } else {
                // Failure
                $_SESSION["message"] = "Could not update room";
                header('Location: ' . $_SERVER['HTTP_REFERER']);

            }
        
    
    }else{
        $_SESSION["message"] = "Name Cannot be Empty!";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }//end check that name field is not empty
        
      

}else{
    $_SESSION["message"] = "Room does not exist!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>

           
            
        
      
        
<?php include("inc/footer.php"); ?>