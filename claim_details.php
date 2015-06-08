<?php
$current_page="claims";
include("inc/header.php"); 
$_SESSION['upload_type'] = 'claim';
?>

<!-- if employee, back to claims, else back to claims history -->


<?php
if(isset($_GET['remove_img'])){
    //IF USER CLICKED "DELETE" on a file upload
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
    
    
   
 //END IF USER CLICKED DELETE ON FILE UPLOAD   
}elseif(isset($_POST['save_title'])){ 
     //IF USER SUBMITTED NEW TITLE ON FILE UPLOAD
    
    $item_id=$_GET['id'];
    $image_id=$_POST['image_id'];
    $new_title=addslashes($_POST['new_title']);
    
    $item_img  = "UPDATE claims_img SET title = '{$new_title}' WHERE id={$image_id} ";
    $insert_item_img = mysqli_query($connection, $item_img); 
    if($insert_item_img){
        //success
        $_SESSION["message"] = "Document Renamed!";
        redirect_to('claim_details.php?id='.$item_id); 

    } else {
        // Failure
        $_SESSION["message"] = "Could not rename document";
       redirect_to('claim_details.php?id='.$item_id); 

    }//END REMOVE ITEM
    


  //IF USER SUBMITTED NEW TITLE ON FILE UPLOAD  
}elseif(isset($_GET['id'])){
    //VIEWING A CLAIM 
    
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
                  		echo "<h1>Claim Title: ".$show['title']."</h1>";
//              SHOW CLAIM DETAILS
			if($draft==1){     
	           	echo "<a class='large_link text_left' href=\"claim_details.php?edit={$show['id']}\"><i class=\"fa fa-pencil\"></i> Edit Details</a>";
	        	echo "<a class='large_link text_right' onclick=\"return confirm('Permanently DELETE this claim?');\" href=\"claim_details.php?delete=".$show['id']."&title=".$show['title']."\"><i class=\"fa fa-trash-o\"></i> Delete Claim </a>";
	        	echo "<hr>";
	        	
	        } 
            echo "<div class=\"item_display\">";
            echo "<p><strong>Claim Type:</strong> ".$claim_type."<br/>";
                  
            $user=find_user_by_id($show['user_id']);
            $username=$user['first_name']." ".$user['last_name'];     
            echo "<strong>Filed By:</strong> <a href=\"profile.php?user=".$user['id']."\">".$username."</a><br/>";
            echo "<strong>Date Filed:</strong> ".$show['datetime']."</p>";
            
        
            echo "<br><h3>Items Involved In This Claim:</h3> <ul class='form_id'>";
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
          	 // echo "<br/><br/>";
                  if(empty($show['notes'])){$show['notes']="<em>No Description</em>";}
            echo "<div class=\"item_display\"><br><p><strong>Notes/Description:</strong> </p><div class=\"notes_container\">".$show['notes']."</div></div><br/>"; 
            echo "<div class=\"clearfix\"></div><hr>";   
 
                  
                  
                  
                  
                  
                  
                  
        //SHOW GALLERY
                  
            $image_query  = "SELECT * FROM claims_img WHERE claim_id={$show['id']}";  
            $image_result = mysqli_query($connection, $image_query);
            $image_num_rows = mysqli_num_rows($image_result);
            if($image_result){

            	if($draft==1){
            		echo "<div class=\"item_display\">";
            	}

            	if($image_num_rows!=0){
            		echo "<div class=\"gallery\">";
	               	echo "<h3>Images Added To This Claim</h3>";
	               	// echo "<hr>";
	               }
                  	

            foreach($image_result as $image){
                $img_edit="<a class='img_edit' href=\"claim_details.php?id=".$show['id']."&edit_img=".$image['id']."\"><i class=\"fa fa-pencil\"></i> Edit </a>";
                $img_delete="<a class='img_edit' onclick=\"return confirm('DELETE this document? This cannot be undone.');\" href=\"claim_details.php?remove_img=".$image['id']."\"> <i class=\"fa fa-trash-o\"></i> Delete</a>";

                //IF ! ENDS IN PDF, SHOW IMAGE, ELSE SHOW ICON
                echo "<div>";
                if($image['is_img']==1){
                    $file= "<a href=\"" .$image['filepath'] . "\" title='" .$image['title']. "' class='fancybox' rel=\"group\"><div class=\"img_container\"><img class=\"thumbnail\" onerror=\"this.src='img/Tulips.jpg'\"  src=\"".$image['thumb_path']."\"></div></a>";

                }else{ 
                    $file= "<p><i class=\"fa fa-5x fa-file-pdf-o\"></i></p>";
                }

                //GET IMAGE TITLE
                if(empty($image['title'])){ $image['title']="Untitled";}
                echo $file ."<h5>".$image['title']."</h5>"; 

                if(isset($_GET['edit_img']) && $_GET['edit_img']==$image['id']){
                    //ONLY SHOW EDIT IMAGE FORM ON IMAGE CHOSEN
                    //Show edit title form
                    ?>
                    <div id="edit_img_title">
                    <form method="POST">
                        <input type="text" name="new_title" value="<?php echo $image['title']; ?>">
                        <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>"> 
                        <input type="submit" name="save_title" value="Save Title">
                    </form>
                    <a href="claim_details.php?id=<?php echo $show['id']; ?>"><i class="fa fa-times"></i> Cancel</a>
                    </div>
                    <hr/>
                    <?php

                }else{
                    if($_SESSION['user_id']==$show['user_id']){
                        if($draft==1){ 
                            echo $img_edit;
                            echo $img_delete;
                        }//end only show if this is a draft
                    }//end show edit/delete options if this is YOUR claim
                }//END ONLY SHOW EDIT IMAGE FORM ON IMAGE CHOSEN
                    
                    
                echo "</div>"; //end each container
            }//END FOR EACH IMAGE
            echo "</div>";//end gallery container
                
                
                
                if($draft==1){
                    //UPLOAD IMAGES FORM
                        echo "</div>"; //end item display	            	
                        echo "<div class=\"item_display\">";
                        $upload="<a href=\"claim_details.php?add_image&id=".$show['id']."\"><input type=\"submit\" value=\"Add Photos &amp; Files\"></a>";
                        $upload_form="<form action=\"image_handling1.php\" method=\"post\" enctype=\"multipart/form-data\">
                        Upload an Image or PDF:<br/>
                        <input type=\"file\" name=\"image\" id=\"fileToUpload\"><br/>
                        <input type=\"hidden\" value=\"".$_GET['id']."\" name=\"claim_id\">
                        <p> Title: <input type=\"text\" value=\"\" name=\"title\" placeholder=\"i.e. Image of item..\" ></p><br/>
                        <input type=\"submit\" value=\"Upload File\" name=\"submit\">
                        </form>"; 

                        echo "<h3>File Attachments</h3>";
                        echo "<p> Attach Images or PDFs of Reports, Damages, Reciepts, or any other details that may help our progress in Approving your claim.</p>"; 
                        echo "<br/><br/>";
                        if(isset($_GET['add_image'])){ 
                            $claim_id=$_GET['add_image'];
                            echo $upload_form;
                        } else {
                            echo $upload;
                        }
                        // echo "";
                        // echo "<br/><br/>";
                        echo "</div>"; //end item display
                    //END UPLOAD IMAGES FORM
              } //end if its a draft
                    echo "<div class=\"clearfix\"></div>";
            }//END IF THERE ARE IMAGES
                  
      //END GALLERY
                  
                  
                  
                  
                  
                  
            
                if($draft==1){
                    //ONLY SHOW SUBMIT BUTTON IF IS A DRAFT 
                   echo "<div class='content_wrapper'><a class=\"red_submit left\" onclick=\"return confirm('Submit this claim? You cannot edit this claim after submitting');\" href=\"claim_details.php?submit=".$show['id']."&title=".$show['title']."\">Submit Claim </a></div><br/>";
                }//END ONLY SHOW SUBMIT BUTTON IF IS A DRAFT                 

    
            }else{
                echo "<h3>Oops! It looks like you do not have permission to be here</h3>";
             }//end check permissions

            
        }//END FOREACH CLAIM FOUND
     }//END GET CLAIMS
    
    
    
    
   //END VIEWING A CLAIM 
}elseif(isset($_GET['edit'])){
    //IF USER CLICKED "EDIT CLAIM DETAILS"
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
         
         <?php }  
              
                  
                $item_query  = "SELECT * FROM claim_items WHERE claim_id={$claim['id']}";  
                $item_result = mysqli_query($connection, $item_query);
                $item_num_rows = mysqli_num_rows($item_result);
                if($item_num_rows!=0){
                    echo "<h3>Items In This Claim:<h3> ";
                // }
                echo "<ul>";
                echo "<div class='select_container'>";
                foreach($item_result as $item){ 

                      $itemname_query  = "SELECT * FROM items WHERE id={$item['item_id']}";  
                      $itemname_result = mysqli_query($connection, $itemname_query);
                      foreach($itemname_result as $itemname){
                            echo "<li> <a class='small_text' href=\"item_details.php?id=".$itemname['id']."\">";

                            $item_img = "SELECT * FROM item_img WHERE item_id={$itemname['id']} AND is_img=1 ORDER BY id DESC LIMIT 1 ";
                            $item_img_result = mysqli_query($connection, $item_img);
                            $total_img_array=mysqli_fetch_assoc($item_img_result);
                            $thumbnail=$total_img_array['thumb_path'];
                            $title=$total_img_array['title'];

                            echo "<div class='thumb_container'><img class=\"thumb_avatar\" src=\"{$thumbnail}\" onerror=\"this.src='http://lorempixel.com/100/100/abstract'\"  alt=\"{$title}\"></div><br> ".$itemname['name']." <br> $".$itemname['declared_value']." </a> <a class='small_text' href=\"claim_details.php?remove_item=".$itemname['id']."\"><i class=\"fa fa-trash-o\"></i></a></li>";
                        }//END GET ITEM DETAILS 
                }//END FOREACH ITEM IN THIS CLAIM
                 echo "<div class=\"clearfix\"></div>";
                echo "</ul>";  
                // if($item_num_rows!=0){
                    echo "<hr> ";
                }
            //OPTIONS TO ADD ITEMS
            $item_query  = "SELECT * FROM items WHERE in_trash=0 AND user_id={$_SESSION['user_id']} ORDER BY name"; 
            $itemresult = mysqli_query($connection, $item_query);
            if($itemresult){ 
                //item SELECT BOX
                echo "<h3>Add Items: </h3>"; 
                echo "<ul>";
                ?>        
                    <li class='block'>
                     
                        <input id="select_input" type="checkbox" onClick="select_all('items');" class="custom"> <label for="select_input">Select all</label>
                        
                    </li> 
                    <div class='select_container'>

                <?php
                foreach($itemresult as $item){ 

                              //Check to see that item is not already involved in claim
                    $item_claim_query  = "SELECT * FROM claim_items WHERE item_id={$item['id']}"; 
                    $item_claim_result = mysqli_query($connection, $item_claim_query);
                    $claim_item_rows=mysqli_num_rows($item_claim_result);
                    if($claim_item_rows < 1){ 
                        //OPTIONS
                        $item_img_query = "SELECT * FROM item_img WHERE item_id={$item['id']} AND is_img=1 ORDER BY id DESC LIMIT 1 ";
                        $item_img_result = mysqli_query($connection, $item_img_query);
                        $img_item_rows=mysqli_num_rows($item_img_result);

                        echo "<li>";

                        if($img_item_rows==0){
                            //SHOW DEFAULT IMAGE IF ITEM HAS NOT IMAGES
                            echo "<div class='thumb_container'><i class=\"fa fa-cube fa-4x text_right\"></i></div><br>";
                        }else{
                            foreach($item_img_result as $img){
                                echo "<div class='thumb_container'><img class='thumb_avatar' src=\"" . $img['thumb_path'] . "\" alt=\"\"></div></br>";
                            }
                        }//END GET ITEM IMAGE

                        echo "<input type=\"checkbox\" name=\"items[]\" id=\"" . $item['id'] . "\" value=\"".$item['id']."\" ><label for='". $item['id'] . "'>" .$item['name']."</label></li>"; 
                        $next=1;
                    }

                }
                
                echo "<div class=\"clearfix\"></div>";
                echo "</ul>";
            }//end get items  to add
    
    echo "<br/><br/>";
    
?>
    
    
     <input type="hidden" name="id" value="<?php echo $claim_id; ?>">
    <input type="submit" name="submit" value="Save Changes">
    <a href="claim_details.php?id=<?php echo $claim_id; ?>" onclick="return confirm('Leave the page? This will not save your changes!');"><i class='fa fa-times'></i> Cancel</a>
 
         
 </form>
     

<?php
    
    //END IF USER CLICKED "EDIT CLAIM DETAILS"
}elseif(isset($_GET['remove_item'])){
    //IF USER CLICKED TRASH CAN ICON TO REMOVE ITEM FROM A CLAIM WITHIN EDIT CLAIM DETAILS
    
    
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
     //END IF USER CLICKED TRASH CAN ICON TO REMOVE ITEM FROM A CLAIM WITHIN EDIT CLAIM DETAILS
}elseif(isset($_GET['save_changes'])){
    //IF USER HIT "SUBMIT" FROM WITHIN EDIT CLAIM DETAILS
    
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
         //status is pending changes: can only append to notes
         $newnotes=$old_notes."<br/>".$notes;
        $insert  = "UPDATE claims SET title='{$title}', notes='{$newnotes}', claim_type='{$claim_type}' WHERE id='{$id}'";
     }else{
        $insert  = "UPDATE claims SET title='{$title}', notes='{$notes}', claim_type='{$claim_type}' WHERE id='{$id}'";
     }
        $insert_result = mysqli_query($connection, $insert); 
    
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
    
    //IF USER HIT "SUBMIT" FROM WITHIN EDIT CLAIM DETAILS
}elseif(isset($_GET['submit'])){
    //IF USER SUBMITTED CLAIM TO BE SENT TO CLAIM ADJUSTER
    
    
    $claim_id=$_GET['submit'];
    $title=$_GET['title'];
    $date = date('d/m/Y H:i'); 
    
    //CHANGE FROM DRAFT TO PENDING
    $insert  = "UPDATE claims SET status_id=0 WHERE id={$claim_id} ";
    $insert_result = mysqli_query($connection, $insert);
    if($insert_result){ 
        //INSERT INTO HISTORY
            $content = "<span class=\"filed_claim_history\">Filed Claim: <a href=\"claim_details.php?id=".$claim_id."\">".$title."</a></span>";
            $history  = "INSERT INTO history ( user_id, content, datetime ) VALUES ( {$_SESSION['user_id']}, '{$content}', '{$date}' ) ";
            $insert_history = mysqli_query($connection, $history); 
        
        //INSERT INTO EMPLOYEE NOTIFICATION TABLE???
        
            $_SESSION["message"] = "Claim Submitted";
            redirect_to("claim_details.php?id=".$claim_id."");        
        }else{
            $_SESSION["message"] = "Claim could not be submitted";
            redirect_to("file_new_claim.php");
        }//end insert query  
    
     //END IF USER SUBMITTED CLAIM TO BE SENT TO CLAIM ADJUSTER
    
}elseif(isset($_GET['delete'])){
    //USER DELETED CLAIM DRAFT
    
    $claim_id=$_GET['delete']; 
    
    
    //REMOVE ITEMS FROM CLAIM_ITEMS SO THAT THE ITEMS ATTACHED DO NOT STILL APPEAR TO BE IN A non-existent claim
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

    //END USER DELETED CLAIM DRAFT
}else{
    //CANNOT FIND CLAIM
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