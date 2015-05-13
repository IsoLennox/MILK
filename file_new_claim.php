<?php include("inc/header.php"); ?>


<h1>File New Claim</h1> 

           
 <form action="#">
 
    
       <?php

            $item_query  = "SELECT * FROM items WHERE in_trash=0 ORDER BY name"; 
                $itemresult = mysqli_query($connection, $item_query);
                if($itemresult){ 
                    //item SELECT BOX
                    echo "<p>Item: <select name=\"item\">"; 
                    foreach($itemresult as $item){
                        //OPTIONS
                        echo "<option name=\"item\" value=\"".$item['id']."\" >".$item['name']."</option>"; 
                    }
                    echo "</select></p>";
                }//end get items 
            echo "<p>+ Add Item</p>";

            $claim_type_query  = "SELECT * FROM claim_types ORDER BY name"; 
                $claim_typeresult = mysqli_query($connection, $claim_type_query);
                if($claim_typeresult){ 
                    //claim_type SELECT BOX
                    echo "<p>Claim Type: <select name=\"claim_type\">"; 
                    foreach($claim_typeresult as $claim_type){
                        //OPTIONS
                        echo "<option name=\"claim_type\" value=\"".$claim_type['id']."\" >".$claim_type['name']."</option>"; 
                    }
                    echo "</select></p>";
                }//end get claim_types 
 ?>
   
    
    <p>Notes:</p>
    <textarea name="notes" id="notes" cols="30" rows="10" maxlength="250" placeholder="Describe the nature of the claim..."></textarea>
    
    <p>Upload files (i.e. Images of damage, appraisals of repair costs, etc.)</p>
    <input type="submit" value="File Claim">
 </form>
     
        
     <a href="claim_history.php" onclick="return confirm('Leave the page? This will not save your claim!');">Cancel</a> 
        
<?php include("inc/footer.php"); ?>