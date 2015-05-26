<?php
$current_page="claims";
include("inc/header.php"); ?>

<!-- FOR EMPLOYEES -->

 

<?php
if(isset($_POST['submit'])){
    $claim_id=$_GET['id'];
    $new_status=$_POST['status'];
    $notes=$_POST['notes'];
    $append_prefix= "<br><hr/><br><strong>Claim Adjuster Notes: </strong>";
    $date = date('m/d/Y H:i');
    
                            //GET CLAIM NOTES
    $note_query  = "SELECT * FROM claims WHERE id={$claim_id}";  
    $note_result = mysqli_query($connection, $note_query);
    if($note_result){
        $note_array=mysqli_fetch_assoc($note_result);
        $claim_notes=$note_array['notes'];
    }else{
        $claim_notes="User made no notes";
    }
    
    $notes=$claim_notes." ".$append_prefix." ".$notes;
     
    //UPDATE CLAIM
    $insert  = "UPDATE claims SET notes='{$notes}', status_id='{$new_status}', updated='{$date}' WHERE id='{$claim_id}'";
    $insert_result = mysqli_query($connection, $insert); 
     if ($insert_result && mysqli_affected_rows($connection) == 1) {
    
        //ADD TO HISTORY        
            $content = "Updated <a href=\"claim_details.php?id=".$claim_id."\">Claim #".$claim_id."</a>";
            $history  = "INSERT INTO history ( user_id, content, datetime, is_employee ) VALUES ( {$_SESSION['user_id']}, '{$content}', '{$date}', 1 ) ";
            $insert_history = mysqli_query($connection, $history); 
         //REDIRECT
            $_SESSION['message']= "Claim #".$claim_id." Updated";
            redirect_to('claims.php');
     }else{
            $_SESSION['message']="Could not update this claim";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
     }
    
    
 
 }elseif(isset($_GET['id'])){
   
    //CHECK PERMISSIONS
    if($_SESSION['is_employee']==1){
        
                //GET PERMISSIONS FOR THIS PAGE
 foreach($_SESSION['permissions'] as $key => $val){   
    if($val==4){  
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
                        echo "<li> <a href=\"item_details.php?id=".$itemname['id']."\">".$itemname['name']."</a> - $".$itemname['declared_value']."</li>";
                    } 
            }
                  echo "</ul>";
                  
            echo "Notes/Description: ".$show['notes']."<br/>";    
            echo "<hr/>";
            echo "<h2>Actions</h2>";
            
            ?>
            <form action="update_claim.php?id=<?php echo $show['id']; ?>" method="POST">
               
                          <?php
            $status_query  = "SELECT * FROM status_types WHERE id != 1 AND id != 0";  
            $status_result = mysqli_query($connection, $status_query);
            foreach($status_result as $status){ 
                if($status['id']==$show['status_id']){ $checked="checked";}else{ $checked="";}
                   echo "<input ".$checked." id=\"update_claim\" type=\"radio\" name=\"status\" value=\"".$status['id']."\">".$status['name'];
            }
            ?> 
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