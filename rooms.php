<?php include("inc/header.php"); ?>


<h1>Your Rooms</h1>
  <?php  if(isset($_POST['submit'])){
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
                    $_SESSION["message"] = "Added ".$name."!";
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    }else{
                        echo "Could not add this room";
                    }
            
            
            
            }
    }  ?>

      
 <form method="POST">
    Add Room: <input type="text" name="name" placeholder="e.x. Bedroom.."><br/>
     Room Notes: <br/><textarea cols="20" rows="8"  name="notes" placeholder="e.x. This room is in the guest house..."></textarea><br/> 
    <input name="submit" type="submit" value="Save Room">
 </form> 
         


 <h2>Your Rooms:</h2> 
<?php //GET ROOMS OF THIS USER

    $roomquery  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']}";  
    $roomresult = mysqli_query($connection, $roomquery);
    if($roomresult){
        //show each result value
        foreach($roomresult as $show){
            echo "<h4><a href=\"room_details.php?id=".$show['id']."\">".$show['name']."</a></h4>";
            echo $show['notes']."<br/>";
            }
        }
 ?>
     
        
      <br/>
      <br/>
      <br/>
      <br/>
      <br/>
        
<?php include("inc/footer.php"); ?>