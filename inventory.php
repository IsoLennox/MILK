<?php 
$current_page="inventory";
include("inc/header.php"); ?>



 
  <?php if(!isset($_GET['trash'])){ ?>
 
  <h1>Your Inventory</h1>

  
  <form class='inventory_search' method="POST">
      <h3>Refine Your Results</h3>
           <!--    //GET ITEM CATEGORIES TO CHOOSE FROM -->
   <?php
 
    
    //    get all categories this user has items in
  
        echo "<fieldset>";
        echo "<label for='category'>Category:</label>  <select name=\"category\"id='category'>";
        echo "<option value=\"all\" >All Categories</option>"; 
            $categories=$item['category']; 
            
                //only show categories if you have items in them
                $category_query  = "SELECT * FROM item_category ORDER BY name"; 
                $categoryresult = mysqli_query($connection, $category_query);
                if($categoryresult){  
                   
                    foreach($categoryresult as $category){
                        
                            $item_query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0 AND category={$category['id']}";  
                            $itemresult = mysqli_query($connection, $item_query);
                            $item_num = mysqli_num_rows($itemresult);
                            if($item_num >=1){ 
                                //OPTIONS
                                echo "<option name=\"category\" value=\"".$category['id']."\" >".$category['name']."</option>"; 
                
                            }//end loop through categories                    
                    }//end get categories 
                }
        echo "</select></fieldset>";
       
    
    
    
    
?>
 
 
 <!--    //GET ROOMS TO CHOOSE FROM -->
   <?php
            $room_query  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']} ORDER BY name"; 
                $roomresult = mysqli_query($connection, $room_query);
                if($roomresult){ 
                    //ROOM SELECT BOX
                    echo "<fieldset>";
                    echo "<label for='room'> Room: </label><select name=\"room\" id='room'>";
                    echo "<option value=\"all\" >All Rooms</option>"; 
                    foreach($roomresult as $room){
                        //OPTIONS
                        echo "<option name=\"room\" value=\"".$room['id']."\" >".$room['name']."</option>"; 
                    }
                    echo "</select></fieldset>";
                }//end get rooms 
 ?>
    <fieldset>
        <input type="submit" value="Find Items" name="submit">
    </fieldset>
    <div class="clearfix"></div>
    </form>
    
    <hr>
    <div class="half_link">
        <a href="add_item.php"><i class="fa fa-plus-circle"></i> Add Item</a>
        <a href="inventory.php?trash"><i class="fa fa-trash-o"></i> View Trash</a>
    </div>
    <div class="half_link">
        <a href="inventory.php?bars"><i class="fa fa-bars"></i></a>
        <a href="inventory.php?grid"><i class="fa fa-th"></i></a>
    </div>
    <div class="clearfix"></div>
  <?php } ?>

<!--//SHOW ALL ITEMS-->
    <!-- this was an input type=submit, it should just be a link? -->
    
  <?php 
//GET ITEMS IN ROOM/ITEM TYPE CHOSEN:

    if(isset($_POST['submit'])){ 
         
        //BOTH FIELDS WERE REFINED
        if($room=$_POST['room']!=="all" && $category=$_POST['category']!=="all"){
            $room= $_POST['room'];
            $category=$_POST['category'];
            $room_name=get_room_name($room);
            $cat_name=get_category_name($category);
            echo "<h3 class='dark_link'>".$cat_name." items in ".$room_name."</h3>";
            //show results based on refinements
            $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND room_id={$room} AND category={$category} AND in_trash=0 ORDER BY id DESC"; 
        }
        
        //ONLY A ROOM WAS CHOSEN
        if($room=$_POST['room']!=="all" && $category=$_POST['category']==="all"){
            
            $room= $_POST['room']; 
            $room_name=get_room_name($room);
            echo "<h3 class='dark_link'>All items in ".$room_name."</h3>";
            //show results based on refinements
            $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND room_id={$room} AND in_trash=0 ORDER BY id DESC"; 
        }
        

        //ONLY A CATEGORY WAS CHOSEN
        if($room=$_POST['room']==="all" && $category=$_POST['category']!=="all"){ 
            $category=$_POST['category'];
            $cat_name=get_category_name($category);
            echo "<h3 class='dark_link'>All ".$cat_name." items </h3>";
            //show results based on refinements
            $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND category={$category} AND in_trash=0 ORDER BY id DESC"; 
        }
        
        //IF both fields were "ALL"
        if($room=$_POST['room']==="all" && $category=$_POST['category']==="all"){ 
            echo "<h3 class='dark_link'>All items </h3>";
            $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0 ORDER BY id DESC"; 
        }
        

    }elseif(isset($_GET['trash'])){
        echo "<a href=\"inventory.php\">&laquo; Back to Inventory</a>";
        echo "<h1 style=\"color:#FF4503;\">Trash Can</h1>";
        //VIEW TRASH CAN
        $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=1 ORDER BY name"; 
    }else{
        //no search refinements, SHOW ALL ITEMS
        $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0 ORDER BY id DESCo"; 
    }


     
    $result = mysqli_query($connection, $query);
    if($result){

        if(isset($_GET['grid'])){
            $_SESSION['grid']=1;
        } elseif(isset($_GET['bars'])) {
            $_SESSION['grid']=0;
        }

        if($_SESSION['grid']==1){
            $class='grid_container';
        } else {
            $class='notes_container';
        }
        
        foreach($result as $show){
            
             //Check to see if involved in claim
            $item_claim_query  = "SELECT * FROM claim_items WHERE item_id={$show['id']}"; 
            $item_claim_result = mysqli_query($connection, $item_claim_query);
            $claim_item_rows=mysqli_num_rows($item_claim_result);
            if($claim_item_rows >= 1){
            	$claim_box = "red_box"; 
                $claim_class="<span style=\"color:#FF4503; font-weight:400;\"> Involved In Claim</span><br>"; 
            }else{
            	$claim_box='';
                $claim_class="";
            }

            //item name info
       		$id=$show['id'];
            $name=$show['name'];

            //get item image info
        	$item_img = "SELECT * FROM item_img WHERE item_id={$id} AND is_img=1 ORDER BY id DESC LIMIT 1 ";
            $item_img_result = mysqli_query($connection, $item_img);
            $total_img_array=mysqli_fetch_assoc($item_img_result);
            $thumbnail=$total_img_array['thumb_path'];
            $title=$total_img_array['title'];

           	//if it is grid container, HTML structure needs to change 
            if($class=='grid_container'){
            	$thumbnail=$total_img_array['file_path'];
                if(empty($thumbnail)){
                    $thumbnail="images/no_img.PNG";
                }
            	echo "<div class=\"img_full_thumb {$claim_box}\">";
            	echo "<a href=\"item_details.php?id=".$id."\"><img src=\"{$thumbnail}\" onerror=\"this.src='images/no_img.PNG'\"  alt=\"{$title}\">";
                echo "<div class='img_title'><p>".$name."<br> {$claim_class}</p></div></a></div>";

            //if not grid view display a whole bunch of other stuff
            } else {
	            echo "<div class=\"{$class}\"><div class='item_content'>";	            
	            echo "<p><a class='dark_link' href=\"item_details.php?id=".$id."\">".$name."</a><br/>";
	            echo $claim_class;

                // if($class!=='grid_container'){
                    $room_name=get_room_name($show['room_id']);
                    $cat_name=get_category_name($show['category']);
                    echo "Category: ".$cat_name."<br/>";
               
                if(empty($room_name)){
                    $room_name="Room not selected";
                }
                    echo "Room: ".$room_name . " ";
            
            //get number of items in rooms ]
            
                $item_count  = "SELECT count(*) as total FROM item_img WHERE item_id={$id}"; 
                $item_count_result = mysqli_query($connection, $item_count);
                $total_array=mysqli_fetch_assoc($item_count_result);
                $total=$total_array['total'];
                echo "<br/>".$total." Image/File Uploads</p>";
           
            	echo "</div>";
             


                // $item_img = "SELECT * FROM item_img WHERE item_id={$id} AND is_img=1 ORDER BY id DESC LIMIT 1 ";
                // $item_img_result = mysqli_query($connection, $item_img);
                // $total_img_array=mysqli_fetch_assoc($item_img_result);
                // $thumbnail=$total_img_array['thumb_path'];
                // $title=$total_img_array['title'];
                echo "<div class='item_img_content'><img src=\"{$thumbnail}\" onerror=\"this.src='images/no_img.PNG'\"  alt=\"{$title}\"></div>";
                echo "<div class=\"clearfix\"></div></div>";

                }//end hide details if grid view
            }
            echo "<div class=\"clearfix\"></div>";
        }
 ?>

      
        
<?php include("inc/footer.php"); ?>