<?php
$current_page="claims";
include("inc/header.php"); ?>

<!-- if employee, back to claims, else back to claims history -->

 

<?php
if(isset($_POST['submit'])){
    $claim_id=$_POST['id'];
    $new_status=$_POST['status'];
    $notes=$_POST['notes'];
    $append_prefix= "<br><hr/><br><strong>Claim Adjuster Notes: </strong>";
    
    echo "You've submitted: <br/>Status: ".$new_status."<br/>Notes: ".$append_prefix.$notes;
 
 }elseif(isset($_GET['id'])){
   
    //CHECK PERMISSIONS
    if($_SESSION['is_employee']==1){
        
                //GET PERMISSIONS FOR THIS PAGE
 foreach($_SESSION['permissions'] as $key => $val){   
    if($key===4){  
        $permission=1; 
        }//end show link if has claims permissions 
    }//end check permissions
        if($permission!==1){ redirect_to('claims.php'); }
       
        
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
            
            if($show['status_id']==0){
                $status="Pending"; 
            }elseif($show['status_id']==2){
                $status="Approved"; 
            }elseif($show['status_id']==3){
                $status="Denied"; 
            }
            echo "<h2>Status: ".$status."</h2>"; 
            
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
            <form action="update_claim.php?id=<?php echo $show['id']; ?>" method="POST">
                
                <input checked type="radio" name="status" value="0">Pending
                <input type="radio" name="status" value="2">Approve
                <input type="radio" name="status" value="3">Deny
                <br/>
                <textarea name="notes" id="notes" cols="30" rows="10" placeholder="Append notes..."></textarea>
                <input type="submit" id="submit" name="submit" value="Update Claim">
            </form>
            <a href="#" onlick="return confirm('Cancel this operation? Your progress will not be saved!'); ">Cancel</a>
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