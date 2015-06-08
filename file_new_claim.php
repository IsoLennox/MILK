<?php  
$current_page="claims";
$sub_page='file_claim';
include("inc/header.php"); 

//PROCESS/INSERT CLAIM INTO TABLE
if(isset($_POST['submit'])){

    //INSERT INTO CLAIMS TABLE
    //DOW NOT ADD TO HISTORY TABLE BECAUSE ITS A DRAFT
    
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
          <label for="title">Title: </label> <input id='title' type="text" name="title">
       <?php
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
            echo "<p>Notes and Details:</p>";
            echo "<textarea name=\"notes\" id=\"notes\" cols=\"30\" rows=\"10\" maxlength=\"250\" placeholder=\"Describe the nature of the claim...\"></textarea>";
     

                $item_query  = "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0 ORDER BY name"; 
                $itemresult = mysqli_query($connection, $item_query);

                if($itemresult){
                          
                  
                    //item SELECT BOX
                    echo "<p>Add Items: </p><br/>"; 
                    ?> <ul class="form_id">
                        <li class='block'>
                         
                            <input id="select_input" type="checkbox" onClick="select_all('items');" class="custom"> <label for="select_input">Select all</label>
                            
                        </li> 
                         <div class='select_container'>
                         <?php
                          $next=0;
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
                                echo "<div class='thumb_container'><i class=\"fa fa-cube fa-4x text_right\"></i></div><br>";
                              }else{

                                foreach($item_img_result as $img){
                                  echo "<div class='thumb_container'><img class='thumb_avatar' src=\"" . $img['thumb_path'] . " \" onerror=\"this.src='http://lorempixel.com/100/100/abstract'\" alt=\"\"></div></br>";
                                }
                              }

                            echo "<input type=\"checkbox\" name=\"items[]\" id=\"" . $item['id'] . "\" value=\"".$item['id']."\" ><label for='". $item['id'] . "'>" .$item['name']."</label></li>"; 
                            $next=1;
                        }
                        
                        
                    }
                    echo "<div class=\"clearfix\"></div></ul>";
                  
                    if($next==1){ ?>
                    <input type="submit" name="submit" value="Next">
                    <a href="claim_history.php" onclick="return confirm('Leave the page? This will not save your claim!');"><i class="fa fa-times"> </i> Cancel</a> 
                 
                    <?php }else{
                            echo "You do not have any items to submit in this claim";
                         } ?>
                 </form> 
                 </div>
                <?php }//end get items  
         ?>
   


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