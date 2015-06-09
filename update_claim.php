<?php
$current_page="claims";
include("inc/header.php"); ?>

<!-- FOR EMPLOYEES -->

 

<?php
if(isset($_POST['submit'])){
    $claim_id=$_GET['id'];
    $new_status=$_POST['status'];
    $notes=$_POST['notes'];
    $date = date('m/d/Y H:i');
    $append_prefix= "<br><hr/><br><strong>(".$date.") Claim Adjuster Notes: </strong>";
    
    
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
            $content = "<span class=\"updated_claim_history\">Updated <a href=\"claim_details.php?id=".$claim_id."\">Claim #".$claim_id."</a></span>";
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
                $status="Processing"; 
            }elseif($show['status_id']==2){
                $status="Approved"; 
            }elseif($show['status_id']==3){
                $status="Denied"; 
            }
            echo "<div class=\"item_display\">";
            echo "<h3>Status: ".$status."</h3>"; 
            
                  $user=find_user_by_id($show['user_id']);
                  $username=$user['first_name']." ".$user['last_name'];
            echo "<p><strong>Claim Type: </strong>".$claim_type."<br/>";    
            echo "<strong>Filed By: </strong><a href=\"profile.php?user=".$user['id']."\">".$username."</a><br/>";
            echo "<strong>Date Filed: </strong>".$show['datetime']."</p><br/>";
            
           
            echo "<br><h3>Items Involved In This Claim:</h3> <ul class='form_id'>";
                  
            // $item_query  = "SELECT * FROM claim_items WHERE claim_id={$show['id']}";  
            // $item_result = mysqli_query($connection, $item_query);
            // foreach($item_result as $item){ 
            //       $itemname_query  = "SELECT * FROM items WHERE id={$item['item_id']}";  
            //       $itemname_result = mysqli_query($connection, $itemname_query);
            //       foreach($itemname_result as $itemname){
            //             echo "<li> <a href=\"item_details.php?id=".$itemname['id']."\">".$itemname['name']."</a> - $".$itemname['declared_value']."</li>";
            //         } 
            // }
            //       echo "</ul>";
                  
            // echo "Notes/Description: ".$show['notes']."<br/>"; 

            $item_query  = "SELECT * FROM claim_items WHERE claim_id={$show['id']}";  
            $item_result = mysqli_query($connection, $item_query);
                  $total_value=0;
            foreach($item_result as $item){ 
                  $itemname_query  = "SELECT * FROM items WHERE id={$item['item_id']}";  
                  $itemname_result = mysqli_query($connection, $itemname_query);
                  foreach($itemname_result as $itemname){
                      
                        $dollar= strtok($itemname['declared_value'], '.');
                        $value=preg_replace("/[^0-9]/","",$dollar);
                      if(empty($value)){ $value="0"; }
                      
                      $item_img = "SELECT * FROM item_img WHERE item_id={$itemname['id']} AND is_img=1 ORDER BY id DESC LIMIT 1 ";
                        $item_img_result = mysqli_query($connection, $item_img);
                        $total_img_array=mysqli_fetch_assoc($item_img_result);
                        $thumbnail=$total_img_array['thumb_path'];
                        $title=$total_img_array['title'];
                     
                        echo "<li><div class=\"small_thumb_container\"> <a href=\"item_details.php?id=".$itemname['id']."\"><img class=\"thumb_avatar\" src=\"{$thumbnail}\" onerror=\"this.src='http://lorempixel.com/50/50/abstract'\"  alt=\"{$title}\"></div><br/> <strong> ".$itemname['name']."</strong></a> <br> $".$value."</li>";
                        $total_value=$total_value+$value;
                    } 
            }
                  
            echo "<div class=\"clearfix\"></div></ul>";
            echo "<br><p><strong>Total Claim Value: $".$total_value."</strong></p><br></div>";

            if(empty($show['notes'])){$show['notes']="<em>No Description</em>";}
            echo "<div class=\"item_display\"><p><strong>Notes/Description:</strong> </p><div class=\"notes_container\">".$show['notes']."</div></div><br/>"; 
            echo "<div class=\"clearfix\"></div>"; 

            ///////////////////////////////

            $image_query  = "SELECT * FROM claims_img WHERE claim_id={$show['id']}";  
            $image_result = mysqli_query($connection, $image_query);
            $image_num_rows = mysqli_num_rows($image_result);
            if(($image_result) && ($image_num_rows!=0)){

                // if($image_num_rows!=0){
                    echo "<hr><div class=\"gallery\">";
                    echo "<h3>Images Added To This Claim</h3>";
                    // echo "<hr>";
                   // }                   

                        foreach($image_result as $image){
                        
                        //IF ! ENDS IN PDF, SHOW IMAGE, ELSE SHOW ICON
                        echo "<div>";
                        if($image['is_img']==1){
                            $file= "<a href=\"" .$image['filepath'] . "\" title='" .$image['title']. "' class='fancybox' rel=\"group\"><div class=\"img_container\"><img class=\"thumbnail\" onerror=\"this.src='img/Tulips.jpg'\"  src=\"".$image['thumb_path']."\"></div></a>";

                        }else{ 
                            $file= "<p><i class=\"fa fa-5x fa-file-pdf-o\"></i></p>";
                        }

                        if(empty($image['title'])){ $image['title']="Untitled";}
 
                        echo $file ."<h5>".$image['title']."</h5>"; 
                        echo "</div>"; //end each container
                    }
                    echo "</div>";//end gallery
                    echo "<div class=\"clearfix\"></div>";
                }



            // ////////////////////////////   
            // echo "<hr/>";
            
            echo "<hr><h2>Actions</h2>";
            
            ?>
            <form action="update_claim.php?id=<?php echo $show['id']; ?>" method="POST">
               
                          <?php
            $status_query  = "SELECT * FROM status_types WHERE id != 1 AND id != 0";  
            $status_result = mysqli_query($connection, $status_query);
            foreach($status_result as $status){ 
                if($status['id']==$show['status_id']){ $checked="checked";}else{ $checked="";}
                   echo "<input ".$checked." type=\"radio\" name=\"status\" id=\"".$status['id']."\" value=\"".$status['id']."\"> <label for='".$status['id']."'> ".$status['name'] . "</label>";
            }
            ?> 
                <br/>
                <textarea name="notes" id="notes" cols="30" rows="10" placeholder="Append notes..."></textarea><br>
                <input type="submit" id="submit" name="submit" value="Update Claim">
                <a href=<?php echo "claim_details.php?id=".$show['id']; ?> onlick="return confirm('Cancel this operation? Your progress will not be saved!'); "><i class="fa fa-times"></i> Cancel</a>

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