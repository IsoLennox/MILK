<?php include("inc/header.php"); 

//PROCESS/INSERT CLAIM INTO TABLE
if(isset($_POST['submit'])){

    //INSERT INTO CLAIMS TABLE
    //ADD TO HISTORY TABLE
    
    //items could be an array after "add item" feature 
    $items_array= $_POST['items'];  
    $title= $_POST['title']; 
    $notes= $_POST['notes']; 
    $claim_type= $_POST['claim_type'];  
    $date = date('d/m/Y H:i');
    
    
        //INSERT ALL DATA EXCEPT PERMISSIONS
$insert  = "INSERT INTO claims ( user_id, title, notes, claim_type, status_id, datetime ) VALUES ( {$_SESSION['user_id']}, '{$title}', '{$notes}','{$claim_type}', 0, '{$date}' ) ";
    $insert_result = mysqli_query($connection, $insert);
    if($insert_result){
        

            
        //INSERT INTO HISTORY
        
            //get item id for link in history content
            $get_claim = "SELECT * FROM claims WHERE title='{$title}' AND user_id={$_SESSION['user_id']} ORDER BY id DESC "; 
            $claimresult = mysqli_query($connection, $get_claim);
            if($claimresult){
                $claim_found=mysqli_fetch_assoc($claimresult);
                $claim_id=$claim_found['id'];
            }else{
                $claim_id="";
            }
        
        
                //INSERT ITEMS INTO claim_items TABLE
 
        foreach($items_array as $item){
        $insert_item  = "INSERT INTO claim_items ( item_id, claim_id) VALUES ( {$item}, {$claim_id} ) ";
            $claimresult = mysqli_query($connection, $insert_item);
        }
        
            $content = "Filed Claim: <a href=\"claim_details.php?id=".$claim_id."\">".$title."</a>";
            $history  = "INSERT INTO history ( user_id, content, datetime ) VALUES ( {$_SESSION['user_id']}, '{$content}', '{$date}' ) ";
            $insert_history = mysqli_query($connection, $history); 
        
        //INSERT INTO EMPLOYEE NOTIFICATION TABLE???
        
            $_SESSION["message"] = "Claim Submitted";
            redirect_to("claim_history.php");        
        }else{
            $_SESSION["message"] = "Claim could not be submitted";
            redirect_to("file_new_claim.php");
        }//end insert uery    
} 






?>

<!-- NEW CLAIM FORM   -->
<h1>File New Claim</h1> 

          
<!--
          // TO DO:
          // ADD OPTION TO CLAIM ALL ITEMS??
          // ADD OPTION TO CLAIM EVERYTHING IN ONE ROOM/GROUP?
          // CHECKBOXES FOR ITEMS??
-->
           
 <form method="POST"> 
      
          <p>Title: <input type="text" name="title"></p>
       <?php
        
            $item_query  = "SELECT * FROM items WHERE in_trash=0 ORDER BY name"; 
                $itemresult = mysqli_query($connection, $item_query);
                if($itemresult){ 
                    //item SELECT BOX
                    echo "<p>Items: "; 
                    foreach($itemresult as $item){
                        //OPTIONS
                        echo "<input type=\"checkbox\" name=\"items[]\" value=\"".$item['id']."\" >".$item['name']."</option>"; 
                    }
                    echo "</p>";
                }//end get items 
                    echo "<p>+ Add Item</p>";

                    $claim_type_query  = "SELECT * FROM claim_types ORDER BY name"; 
                        $claim_typeresult = mysqli_query($connection, $claim_type_query);
                        if($claim_typeresult){ 
                            //claim_type SELECT BOX
                            echo "<p>Claim Type: <select name=\"claim_type\">"; 
                            foreach($claim_typeresult as $claim_type){
                                //OPTIONS
                                echo "<option value=\"".$claim_type['id']."\" >".$claim_type['name']."</option>"; 
                            }
                            echo "</select></p>";
                        }//end get claim_types 
         ?>
   
    
    <p>Notes and Details:</p>
    <textarea name="notes" id="notes" cols="30" rows="10" maxlength="250" placeholder="Describe the nature of the claim..."></textarea>
    
    <p>Upload files (i.e. Images of damage, appraisals of repair costs, etc.)</p>
    <input type="submit" name="submit" value="File Claim">
 </form>
     
<a href="claim_history.php" onclick="return confirm('Leave the page? This will not save your claim!');">Cancel</a> 
        
<?php  

include("inc/footer.php"); ?>