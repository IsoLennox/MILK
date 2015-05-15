<?php
$current_page="claims";
include("inc/header.php"); ?>

<!-- if employee, back to claims, else back to claims history -->

 

<?php
if(isset($_GET['submit'])){
    $new_status=$_GET['status'];
    $notes=$_GET['notes'];
    $append_prefix= "<br><hr/><br><strong>Claim Adjuster Notes: </strong>";
 
 }
if(isset($_GET['id'])){
   
    //CHECK PERMISSIONS
    if($_SESSION['is_employee']==1){
       
        
    $query  = "SELECT * FROM claims WHERE id={$_GET['id']}";  
    $result = mysqli_query($connection, $query);
    if($result){ 
        //show each result value
        foreach($result as $show){ 
           
            
                        //GET CLAIM TYPE NAME
    $type_query  = "SELECT * FROM claim_types WHERE id={$show['claim_type']}";  
    $type_result = mysqli_query($connection, $type_query);
    if($type_result){
        $type_array=mysqli_fetch_assoc($type_result);
        $claim_type=$type_array['name'];
    }
            
            
            echo "<h1>Updating: ".$show['title']."</h1>";
            echo "<h2>Status: ".$show['status_id']."</h2>"; 
            
                  $user=find_user_by_id($show['user_id']);
                  $username=$user['first_name']." ".$user['last_name'];
                  
            echo "Filed By: <a href=\"profile.php?user=".$user['id']."\">".$username."</a><br/>";
            echo "Date Filed: ".$show['datetime']."<br/>";
            
            echo "Claim Type: ".$claim_type."<br/>";
            echo "Items: <ul>";
                  
            $item_query  = "SELECT * FROM claim_items WHERE claim_id={$show['id']}";  
            $item_result = mysqli_query($connection, $item_query);
            foreach($item_result as $item){ 
                  $itemname_query  = "SELECT * FROM items WHERE id={$item['item_id']}";  
                  $itemname_result = mysqli_query($connection, $itemname_query);
                  foreach($itemname_result as $itemname){
                        echo "<li> <a href=\"item_details.php?id=".$itemname['id']."\">".$itemname['name']."</a></li>";
                    } 
            }
                  echo "</ul>";
                  
            echo "Notes/Description: ".$show['notes']."<br/>";    
            echo "<hr/>";
            echo "<h2>Actions</h2>";
            
            ?>
            <form method="POST">
                
                <input type="radio" name="status">Approve
                <input type="radio" name="status">Deny
                <br/>
                <textarea name="notes" id="notes" cols="30" rows="10" placeholder="Append notes..."></textarea>
                <input type="submit" name="submit" value="Update Claim">
            </form>
            <?php 
        }
     }
        
        
        


    }else{
        //redirect to a sweet no permissions page
        echo "You do not have permission to view this page!";

    } //end get permissions
}else{

    echo "This claim does not exist!";
}
 ?>
     
        
      
        
<?php include("inc/footer.php"); ?>