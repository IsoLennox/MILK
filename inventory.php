<?php include("inc/header.php"); ?>


<h1>Your Inventory</h1>

<a href="add_item.php">+ Add Item</a>
 
  
  <form method="POST">
      <h3>Refine Your Results</h3>
           <!--    //GET ITEM CATEGORIES TO CHOOSE FROM -->
   <?php

//    get all categories this user has items in
    $item_query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0";  
    $itemresult = mysqli_query($connection, $item_query);
    if($itemresult){ 
        echo "<p>Category:  <select name=\"category\">";
         echo "<option value=\"all\" >All Categories</option>"; 
        foreach($itemresult as $item){
            $categories=$item['category']; 
            
                //only show categories if you have items in them
                $category_query  = "SELECT * FROM item_category WHERE id = {$categories}"; 
                $categoryresult = mysqli_query($connection, $category_query);
                if($categoryresult){  
                   
                    foreach($categoryresult as $category){
                        //OPTIONS
                        echo "<option name=\"category\" value=\"".$category['id']."\" >".$category['name']."</option>"; 
                    }//end loop through categories                    
                }//end get categories
            
            }//end items found with categories
        echo "</select></p>";
        echo "</ul>";
        } 
?>
 
 
 <!--    //GET ROOMS TO CHOOSE FROM -->
   <?php
            $room_query  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']}"; 
                $roomresult = mysqli_query($connection, $room_query);
                if($roomresult){ 
                    //ROOM SELECT BOX
                    echo "<p>Room: <select name=\"room\">";
                    echo "<option value=\"all\" >All Rooms</option>"; 
                    foreach($roomresult as $room){
                        //OPTIONS
                        echo "<option name=\"room\" value=\"".$room['id']."\" >".$room['name']."</option>"; 
                    }
                    echo "</select></p>";
                }//end get rooms 
 ?>
     <input type="submit" value="Find Items" name="submit">
 
  </form>
  
  

  <?php 
//GET ITEMS IN ROOM/ITEM TYPE CHOSEN:

    if(isset($_POST['submit'])){ 
         
        //BOTH FIELDS WERE REFINED
        if($room=$_POST['room']!=="all" && $category=$_POST['category']!=="all"){
            $room= $_POST['room'];
            $category=$_POST['category'];
            $room_name=get_room_name($room);
            $cat_name=get_category_name($room);
            echo "<h3>".$cat_name."items in ".$room_name."</h3>";
            //show results based on refinements
            $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND room_id={$room} AND category={$category} AND in_trash=0"; 
        }
        
        //ONLY A ROOM WAS CHOSEN
        if($room=$_POST['room']!=="all" && $category=$_POST['category']==="all"){
            
            $room= $_POST['room']; 
            $room_name=get_room_name($room);
            echo "All items in ".$room_name;
            //show results based on refinements
            $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND room_id={$room} AND in_trash=0"; 
        }
        

        //ONLY A CATEGORY WAS CHOSEN
        if($room=$_POST['room']==="all" && $category=$_POST['category']!=="all"){ 
            $category=$_POST['category'];
            $cat_name=get_category_name($category);
            echo "All items in category: ".$cat_name;
            //show results based on refinements
            $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND category={$category} AND in_trash=0"; 
        }
        
        //IF both fields were "ALL"
        if($room=$_POST['room']==="all" && $category=$_POST['category']==="all"){ 
            $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0"; 
        }
        

    }else{
        //no search refinements, SHOW ALL ITEMS
        $query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0"; 
    }


     
    $result = mysqli_query($connection, $query);
    if($result){
        //show each result value
        echo "<ul>";
        foreach($result as $show){
            
            $id=$show['id'];
            $name=$show['name'];
            echo "<li><a href=\"item_details.php?id=".$id."\">".$name."</a></li>";
                $room_name=get_room_name($show['room_id']);
                $cat_name=get_category_name($show['category']);
                echo "Category: ".$cat_name."<br/>";
                echo "Room: ".$room_name;
            
            
            }
        echo "</ul>";
        }
 ?>
     
        
      
        
<?php include("inc/footer.php"); ?>