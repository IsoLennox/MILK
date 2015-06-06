<?php
$current_page="claims";
include("inc/header.php"); 
$_SESSION['upload_type'] = 'claim';
?>

<!-- if employee, back to claims, else back to claims history -->


<?php
if(isset($_GET['remove_img'])){ 
    $item_id=$_GET['remove_img'];  
    
        $update_item  = "DELETE FROM claims_img WHERE id = {$item_id} LIMIT 1";
        $result = mysqli_query($connection, $update_item);

        if ($result && mysqli_affected_rows($connection) == 1) {
        // Success 

            $_SESSION["message"] = "Item Document Removed!";
            header('Location: ' . $_SERVER['HTTP_REFERER']);

        } else {
        // Failure
            $_SESSION["message"] = "Could not delete item document";
           header('Location: ' . $_SERVER['HTTP_REFERER']);

        }//END REMOVE ITEM
    
    
   
    
}elseif(isset($_POST['save_title'])){ 
     
    
    $item_id=$_GET['id'];
    $image_id=$_POST['image_id'];
    $new_title=addslashes($_POST['new_title']);
    
        $item_img  = "UPDATE claims_img SET title = '{$new_title}' WHERE id={$image_id} ";
        $insert_item_img = mysqli_query($connection, $item_img); 
    if($insert_item_img){

        $_SESSION["message"] = "Document Renamed!";
        redirect_to('claim_details.php?id='.$item_id); 

        } else {
        // Failure
        $_SESSION["message"] = "Could not rename document";
       redirect_to('claim_details.php?id='.$item_id); 

        }//END REMOVE ITEM
    


    
}elseif(isset($_GET['id'])){
    
    $query  = "SELECT * FROM claims WHERE id={$_GET['id']}";  
    $result = mysqli_query($connection, $query);
    if($result){ 
        //show each result value
        foreach($result as $show){
            
              if($_SESSION['is_employee']==1 || $show['user_id']===$_SESSION['user_id'] ){
            
                        //GET CLAIM TYPE NAME
                    $draft=0;
                    $type_query  = "SELECT * FROM claim_types WHERE id={$show['claim_type']}";  
                    $type_result = mysqli_query($connection, $type_query);
                    if($type_result){
                        $type_array=mysqli_fetch_assoc($type_result);
                        $claim_type=$type_array['name'];
                    }
                   echo "<h1>".$show['title']."</h1>";
                                  //GET CLAIM STATUS NAME
                    $status_query  = "SELECT * FROM status_types WHERE id={$show['status_id']}";  
                    $status_result = mysqli_query($connection, $status_query);
                    if($status_result){
                        $status_array=mysqli_fetch_assoc($status_result);
                        $status=$status_array['name'];
                    }   
     
                    //GET PERMISSIONS 
                    if($_SESSION['is_employee']==1){  
                        //show status of claim
                        echo "<h3>Claim Status: ".$status."</h3>";
                        //SEE IF HAS PERMISSIONS TO UPDATE CLAIMS
                     foreach($_SESSION['permissions'] as $key => $val){ 
                        if($val==4){  
                           $permission=1;
                            }//end show link if has claims permissions 
                        }//end check permissions 
                        if($permission==1){
                        //has permissions to update claim, show link 
                             echo "<a class=\"green_submit right\" href=\"update_claim.php?id=".$_GET['id']."\"><i class=\"fa fa-pencil\"></i> Update This Claim</a><br/>";
                        }
                    } //end check if employee
                  
                    //    STATUS BAR
                         if($show['user_id']===$_SESSION['user_id'] ){
                             if($status=="Draft"){
                                $status="Add Images/Revise Draft";
                             }
                             
                             if($status=="Approved" || $status=="Denied"){
                                $next_step="";
                             }else{ $next_step="> Approved/Denied";}
                             echo "<div class=\"fake_status\">Draft > <span id=\"current_status\">".$status."</span> ".$next_step." </div>"; 
                        //                 echo "<a href=\"claim_details.php?revoke=".$_GET['id']."\">Revoke this claim</a><br/>";
                             //IF A DRAFT, OPTIONS TO EDIT OR SUBMIT
                             if($show['status_id']==1 || $show['status_id']==4){
                                 //can edit if a draft, or pending changes
                                 $draft=1; 
                             }else{ $draft=0; }
                         }//end check if draft/pending client changes
                  
//              SHOW CLAIM DETAILS     
            
            echo "<p>Claim Type: ".$claim_type."<br/>";
                  
            $user=find_user_by_id($show['user_id']);
            $username=$user['first_name']." ".$user['last_name'];     
            echo "Filed By: <a href=\"profile.php?user=".$user['id']."\">".$username."</a><br/>";
            echo "Date Filed: ".$show['datetime']."</p><br/>";
            
            
                  
            echo "<p>Items:</p> <ul>";
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
                     
                        echo "<li> <a href=\"item_details.php?id=".$itemname['id']."\"><img class=\"thumb_avatar\" src=\"{$thumbnail}\" onerror=\"this.src='http://lorempixel.com/40/40/abstract'\"  alt=\"{$title}\"><br/>  ".$itemname['name']."</a> - $".$value."</li>";
                        $total_value=$total_value+$value;
                    } 
            }
                  echo "<strong>Total Claim Value: $".$total_value."</strong>";
            echo "</ul>";
            echo "<br/><br/>";
                  if(empty($show['notes'])){$show['notes']="<em>No Description</em>";}
            echo "Notes/Description: <div class=\"notes_container\">".$show['notes']."</div><br/>"; 
                  
                  
                if($draft==1){
                  $upload="<a href=\"claim_details.php?add_image&id=".$show['id']."\"><input type=\"submit\" value=\"Add Photos &amp; Files\"></a>";
                  $upload_form="<form action=\"image_handling1.php\" method=\"post\" enctype=\"multipart/form-data\">
                  Upload an Image or PDF:<br/>
                  <input type=\"file\" name=\"image\" id=\"fileToUpload\"><br/>
                  <input type=\"hidden\" value=\"".$_GET['id']."\" name=\"claim_id\">
                  <p> Title: <input type=\"text\" value=\"\" name=\"title\" placeholder=\"i.e. Image of item..\" ></p><br/>
                  <input type=\"submit\" value=\"Upload File\" name=\"submit\">
                  </form>"; 
                  echo "<a class=\"green_submit\" href=\"claim_details.php?edit={$show['id']}\"><i class=\"fa fa-pencil\"></i> Edit Details</a><br/>";
              
                  echo "<br/><a onclick=\"return confirm('Permanently DELETE this claim?');\" href=\"claim_details.php?delete=".$show['id']."&title=".$show['title']."\"><i class=\"fa fa-trash-o\"></i> Delete Claim </a><br/>";
              
                  echo "<br/><br/>";
                  echo "<h3>File Attachments</h3>";
                  echo "<p> Attach Images or PDFs of Reports, Damages, Reciepts, or any other details that may help our progress in Approving your claim.</p>"; 
                  echo "<br/><br/>";
                  if(isset($_GET['add_image'])){ 
                    $claim_id=$_GET['add_image'];
                    echo $upload_form;
                  } else {
                     echo $upload;
                  }
                  echo "";
                  echo "<br/><br/>";
                  echo "<a class=\"red_submit\" onclick=\"return confirm('Submit this claim? You cannot edit this claim after submitting');\" href=\"claim_details.php?submit=".$show['id']."&title=".$show['title']."\">Submit Claim </a><br/>";
                    
                        
                  }
                  
                  //SHOW GALLERY
            $image_query  = "SELECT * FROM claims_img WHERE claim_id={$show['id']}";  
            $image_result = mysqli_query($connection, $image_query);
            if($image_result){
               
                  echo "<div class=\"gallery\">";

                        foreach($image_result as $image){
                        if($claim_num == 0){
                            $img_edit="<a class='img_edit' href=\"claim_details.php?id=".$show['id']."&edit_img=".$image['id']."\"><i class=\"fa fa-pencil\"></i> Edit </a>";
                            $img_delete="<a class='img_edit' onclick=\"return confirm('DELETE this document? This cannot be undone.');\" href=\"claim_details.php?remove_img=".$image['id']."\"> <i class=\"fa fa-trash-o\"></i> Delete</a>";
                        }   
                        //IF ! ENDS IN PDF, SHOW IMAGE, ELSE SHOW ICON
                        echo "<div>";
                        if($image['is_img']==1){
                            $file= "<a href=\"" .$image['file_path'] . "\" title='" .$image['title']. "' class='fancybox' rel=\"group\"><div class=\"img_container\"><img class=\"thumbnail\" onerror=\"this.src='img/Tulips.jpg'\"  src=\"".$image['thumb_path']."\"></div></a>";

                        }else{ 
                            $file= "<p><i class=\"fa fa-5x fa-file-pdf-o\"></i></p>";
                        }

                        if(empty($image['title'])){ $image['title']="Untitled";}
 
                        echo $file ."<h5>".$image['title']."</h5>"; 
                             
                        if(isset($_GET['edit_img']) && $_GET['edit_img']==$image['id']){
                            //Show edit title form
                            ?>
                            <div id="edit_img_title">
                            <form method="POST">
                                <input type="text" name="new_title" value="<?php echo $image['title']; ?>">
                                <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>"> 
                                <input type="submit" name="save_title" value="Save Title">
                            </form>
                            <a href="claim_details.php?id=<?php echo $show['id']; ?>">Cancel</a>
                            </div>
                            <hr/>
                            <?php
                        
                        }else{
                            if($_SESSION['user_id']==$show['user_id']){
                                echo $img_edit;
                                echo $img_delete;
                            }
                        }
                        echo "</div>"; //end each container
                    }
                    echo "</div>";//end gallery
               
            }
                  
                  
                  
    
    }else{
        echo "Oops! It looks like you do not have permission to be here";
     }  
        }
     }
    
}elseif(isset($_GET['edit'])){
    
    $claim_id=$_GET['edit'];
    
    
    
    
    $query  = "SELECT * FROM claims WHERE id={$claim_id} AND user_id={$_SESSION['user_id']}";  
    $result = mysqli_query($connection, $query);
    if($result){ 
        $claim=mysqli_fetch_assoc($result);
        $old_title=$claim['title'];
        $old_notes=$claim['notes'];
        $status=$claim['status_id'];
    }
    
    
        //GET CLAIM STATUS NAME
    $status_query  = "SELECT * FROM status_types WHERE id={$status}";  
    $status_result = mysqli_query($connection, $status_query);
    if($status_result){
        $status_array=mysqli_fetch_assoc($status_result);
        $status_name=$status_array['name'];
    }   
     echo "<h2>".$status_name."</h2>";
    ?>
    
     <form action="claim_details.php?save_changes=<?php echo $claim_id; ?>" method="POST"> 
      
          <label for="title"> Title: </label><input type="text" id='title' name="title" value="<?php echo $old_title; ?>">
       <?php
    
    
               echo "Items In This Claim: <ul>";
                  
            $item_query  = "SELECT * FROM claim_items WHERE claim_id={$claim['id']}";  
            $item_result = mysqli_query($connection, $item_query);
            foreach($item_result as $item){ 
                  $itemname_query  = "SELECT * FROM items WHERE id={$item['item_id']}";  
                  $itemname_result = mysqli_query($connection, $itemname_query);
                  foreach($itemname_result as $itemname){
                        echo "<li> <a href=\"item_details.php?id=".$itemname['id']."\">";
                      
                $item_img = "SELECT * FROM item_img WHERE item_id={$itemname['id']} AND is_img=1 ORDER BY id DESC LIMIT 1 ";
                $item_img_result = mysqli_query($connection, $item_img);
                $total_img_array=mysqli_fetch_assoc($item_img_result);
                $thumbnail=$total_img_array['thumb_path'];
                $title=$total_img_array['title'];
                      
                echo "<img class=\"thumb_avatar\" src=\"{$thumbnail}\" onerror=\"this.src='http://lorempixel.com/40/40/abstract'\"  alt=\"{$title}\"> ".$itemname['name']."</a> - $".$itemname['declared_value']." - <a href=\"claim_details.php?remove_item=".$itemname['id']."\"><i class=\"fa fa-trash-o\"></i></a></li>";
                    } 
            }
                  echo "</ul><br>";
    
    
    
        
            $item_query  = "SELECT * FROM items WHERE in_trash=0 AND user_id={$_SESSION['user_id']} ORDER BY name"; 
                $itemresult = mysqli_query($connection, $item_query);
                if($itemresult){ 
                    //item SELECT BOX
                    echo "<p>Add Items: <br/>"; 
                    ?> <ul id="form_id">
<!--
                        <li>
                          <label for="select_input">
-->
                          
<!--                          someone removed this script, cannot find it-->
<!--                            <input id="select_input" type="checkbox" onClick="select_all('items');" class="custom"> Select all-->
<!--                          </label>-->
<!--                        </li> -->
                         <?php
                          
                    foreach($itemresult as $item){
                        
                        //Check to see that item is not already involved in claim
                        $item_claim_query  = "SELECT * FROM claim_items WHERE item_id={$item['id']}"; 
                        $item_claim_result = mysqli_query($connection, $item_claim_query);
                        $claim_item_rows=mysqli_num_rows($item_claim_result);
                        if($claim_item_rows < 1){ 
                            //OPTIONS
                            echo "<li><input type=\"checkbox\" name=\"items[]\" id=\"".$item['id']."\" value=\"".$item['id']."\" ><label for='".$item['id'] . "'>". $item['name']."</label></li>"; 
                            
                        }else{
//                            echo "<li>".$item['name']." is in a claim</li>";
                        } 
                    }
                    echo "</ul></p>";
                    echo "<div class=\"clearfix\"></div>";
                }//end get items  
    
    echo "<br/><br/>";
    
     
                    $claim_type_query  = "SELECT * FROM claim_types ORDER BY name"; 
                        $claim_typeresult = mysqli_query($connection, $claim_type_query);
                        if($claim_typeresult){ 
                            //claim_type SELECT BOX
                            echo "<p>Claim Type: <select name=\"claim_type\">"; 
                            foreach($claim_typeresult as $claim_type){
                                if($claim_type['id']==$claim['claim_type']){
                                    $selected="selected";
                                }else{
                                    $selected="";
                                }
                                //OPTIONS
                                echo "<option ".$selected." value=\"".$claim_type['id']."\" >".$claim_type['name']."</option>"; 
                            }
                            echo "</select></p>";
                        }//end get claim_types 
         ?>
   
    
    <p>Notes and Details:<br/></p>
    
         <?php  if($status==4){
             //claim pending changes: can only append notes
             echo "<div class=\"notes_container\">".$old_notes."</div><hr/>"; ?>
            <textarea name="notes" id="notes" cols="30" rows="10" maxlength="250" placeholder="Add details..."></textarea>
    <?php }else{ ?>
         
         <textarea name="notes" id="notes" cols="30" rows="10" maxlength="250" placeholder="Describe the nature of the claim..." value="<?php echo $old_notes; ?>"><?php echo $old_notes; ?></textarea>
         
         <?php } ?>
    
    
     <input type="hidden" name="id" value="<?php echo $claim_id; ?>">
    <input type="submit" name="submit" value="Save Changes"> 
 </form>
     
<a href="claim_details.php?id=<?php echo $claim_id; ?>" onclick="return confirm('Leave the page? This will not save your changes!');">Cancel</a>

<?php
}elseif(isset($_GET['remove_item'])){
    $item_id=$_GET['remove_item'];
    //DELETE ITEMS FROM CLAIMS_ITEMS TABLE    
    $query  = "DELETE FROM claim_items WHERE item_id={$item_id} LIMIT 1";  
    $result = mysqli_query($connection, $query);
    if($result){ 
            $_SESSION["message"] = "Removed item";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
    }else{
     $_SESSION["message"] = "Could not remove item";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    
}elseif(isset($_GET['save_changes'])){
    
    $id= $_GET['save_changes'];  
    $items_array= $_POST['items'];  
    $title= $_POST['title']; 
    $notes= $_POST['notes']; 
    $claim_type= $_POST['claim_type'];  
    $date = date('d/m/Y H:i');
    
    //GET OLD NOTES
    $query  = "SELECT * FROM claims WHERE id={$id}";  
    $result = mysqli_query($connection, $query);
    if($result){ 
        $claim=mysqli_fetch_assoc($result); 
        $old_notes=$claim['notes'];
    }
 
    
    
 if($claim['status_id']==4){
     $newnotes=$old_notes."<br/>".$notes;
     //status is pending changes: can only append to notes
    $insert  = "UPDATE claims SET title='{$title}', notes='{$newnotes}', claim_type='{$claim_type}' WHERE id='{$id}'";
 }else{
    $insert  = "UPDATE claims SET title='{$title}', notes='{$notes}', claim_type='{$claim_type}' WHERE id='{$id}'";
 }
    $insert_result = mysqli_query($connection, $insert); 
//     if ($insert_result && mysqli_affected_rows($connection) == 1) {
     if ($insert_result) {
    
    
            foreach($items_array as $item){
        $insert_item  = "INSERT INTO claim_items ( item_id, claim_id) VALUES ( {$item}, {$id} ) ";
            $claimresult = mysqli_query($connection, $insert_item);
            }
         
         $_SESSION['message']="Changes Saved!";
         redirect_to('claim_details.php?id='.$id);
         }else{
         $_SESSION['message']="Could Not Save Changes!";
         redirect_to('claim_details.php?id='.$id);
            }
}elseif(isset($_GET['submit'])){
    $claim_id=$_GET['submit'];
    $title=$_GET['title'];
    //CHANGE FROM DRAFT TO PENDING 
//    //ADD TO HISTORY TABLE
  
    $date = date('d/m/Y H:i'); 
    
    $insert  = "UPDATE claims SET status_id=0 WHERE id={$claim_id} ";
    $insert_result = mysqli_query($connection, $insert);
    if($insert_result){ 
        //INSERT INTO HISTORY
            $content = "Filed Claim: <a href=\"claim_details.php?id=".$claim_id."\">".$title."</a>";
            $history  = "INSERT INTO history ( user_id, content, datetime ) VALUES ( {$_SESSION['user_id']}, '{$content}', '{$date}' ) ";
            $insert_history = mysqli_query($connection, $history); 
        
        //INSERT INTO EMPLOYEE NOTIFICATION TABLE???
        
            $_SESSION["message"] = "Claim Submitted";
            redirect_to("claim_details.php?id=".$claim_id."");        
        }else{
            $_SESSION["message"] = "Claim could not be submitted";
            redirect_to("file_new_claim.php");
        }//end insert uery    
}elseif(isset($_GET['delete'])){
        $claim_id=$_GET['delete']; 
    
    //REMOVE ITEMS FROM CLAIM_ITEMS
    
    $delete_items  = "DELETE FROM claim_items WHERE claim_id={$claim_id} ";
    $delete_items_result = mysqli_query($connection, $delete_items);
    if($delete_items_result){ 
        
            $delete_claims  = "DELETE FROM claims WHERE id={$claim_id} ";
            $delete_claims_result = mysqli_query($connection, $delete_claims);
            if($delete_claims_result){ 
                $_SESSION["message"] = "Claim Draft Removed!";
                redirect_to("claim_history.php"); 
            }else{
                $_SESSION["message"] = "Claim could not be removed"; 
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }//end delete_claims uery 
        }else{
            $_SESSION["message"] = "Claim items could not be removed"; 
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }//end delete_items uery 
    
    
}else{
    echo "This claim does not exist!";
}
 ?> 
         <script type="text/javascript">
        $(document).ready(function() {
            $(".fancybox").fancybox({
                //for alt text
              afterShow: function(){
                $('.fancybox-title').wrapInner('<div />').show();

                $('.fancybox-wrap').hover(function(){
                  $('.fancybox-title').show(); //when hover on show title
                }, function(){
                  $('.fancybox-title').hide(); //when hover off hide title
                }); //end hover
              }, //end after show
              helpers: {
                title: {
                  type: 'over'
                } //title
              } //helper
            });
        });
    </script>     

        
<?php include("inc/footer.php"); ?>