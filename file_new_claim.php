<?php  
$current_page="claims";
include("inc/header.php"); 

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
$insert  = "INSERT INTO claims ( user_id, title, notes, claim_type, status_id, datetime ) VALUES ( {$_SESSION['user_id']}, '{$title}', '{$notes}','{$claim_type}', 1, '{$date}' ) ";
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
        
        
//                INSERT ITEMS INTO claim_items TABLE  
 
        foreach($items_array as $item){
        $insert_item  = "INSERT INTO claim_items ( item_id, claim_id) VALUES ( {$item}, {$claim_id} ) ";
            $claimresult = mysqli_query($connection, $insert_item);
        }
//       INSERT INTO HISTORY TABLE (NOT FOR DRAFTS) 
//            $content = "Filed Claim: <a href=\"claim_details.php?id=".$claim_id."\">".$title."</a>";
//            $history  = "INSERT INTO history ( user_id, content, datetime ) VALUES ( {$_SESSION['user_id']}, '{$content}', '{$date}' ) ";
//            $insert_history = mysqli_query($connection, $history); 
        
        //INSERT INTO EMPLOYEE NOTIFICATION TABLE???
        
            $_SESSION["message"] = "Claim Saved As Draft";
            redirect_to("claim_details.php?id=".$claim_id."");        
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
           
 <form class="add_item" method="POST"> 
      <div class="fake_status"><span id="current_status">Add Details</span> > Add Images/Revise Draft > Submit Claim</div>
          <p>Title: <input type="text" name="title"></p>
       <?php
        
            $item_query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0 ORDER BY name"; 
                $itemresult = mysqli_query($connection, $item_query);
                if($itemresult){ 
                    
                    
                    //item SELECT BOX
                    echo "<p>Items: <br/>"; 
                    ?> <ul id="form_id" style="list-style: none;">
                        <li>
                          <label for="select_input">
                            <input id="select_input" type="checkbox" onClick="select_all('items');" class="custom"> Select all
                          </label>
                        </li> <?php
                          $next=0;
                    foreach($itemresult as $item){
                        
                        //Check to see that item is not already involved in claim
                        $item_claim_query  = "SELECT * FROM claim_items WHERE item_id={$item['id']}"; 
                        $item_claim_result = mysqli_query($connection, $item_claim_query);
                        $claim_item_rows=mysqli_num_rows($item_claim_result);
                        if($claim_item_rows < 1){ 
                            //OPTIONS
                            echo "<li><input type=\"checkbox\" name=\"items[]\" value=\"".$item['id']."\" >".$item['name']."</option></li>"; 
                            $next=1;
                        }
                        
                        
                    }
                    echo "</ul></p>";
                }//end get items  

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
     <?php if($next==1){ ?>
    <input type="submit" name="submit" value="Next"> 
    <?php }else{
            echo "You do not have any items to submit in this claim";
         } ?>
 </form> 
<a href="claim_history.php" onclick="return confirm('Leave the page? This will not save your claim!');">Cancel</a> 
       
        
        
 


<!--         JAVASCRIPT FOR SELECT ALL BUTTON      -->

<script>
    var formblock;
var forminputs;

function prepare() {
      formblock= document.getElementById('form_id');
      forminputs = formblock.getElementsByTagName('input');
      selectinput = document.getElementById('select_input');
    }
 
    function select_all(name) {

    for (i = 0; i < forminputs.length; i++) {
    var regex = new RegExp(name, "i");
      if (regex.test(forminputs[i].getAttribute('name'))) {
        if (selectinput.checked==true) {
          forminputs[i].checked = true;
        } else {
          forminputs[i].checked = false;
        }
      }
    }
    }
 
    if (window.addEventListener) {
      window.addEventListener("load", prepare, false);
    } else if (window.attachEvent) {
      window.attachEvent("onload", prepare)
    } else if (document.getElementById) {
      window.onload = prepare;
    }
</script>


<?php  

include("inc/footer.php"); ?>