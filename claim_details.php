<?php
$current_page="claims";
include("inc/header.php"); ?>

<!-- if employee, back to claims, else back to claims history -->

 

<?php
 
if(isset($_GET['id'])){
    
    $query  = "SELECT * FROM claims WHERE id={$_GET['id']}";  
    $result = mysqli_query($connection, $query);
    if($result){ 
        //show each result value
        foreach($result as $show){
//              if($_SESSION['is_employee']==1 || $show['user_id']===$_SESSION['user_id'] ){
              if($_SESSION['is_employee']==1 || $show['user_id']===$_SESSION['user_id'] ){
            
                        //GET CLAIM TYPE NAME
    $type_query  = "SELECT * FROM claim_types WHERE id={$show['claim_type']}";  
    $type_result = mysqli_query($connection, $type_query);
    if($type_result){
        $type_array=mysqli_fetch_assoc($type_result);
        $claim_type=$type_array['name'];
    }
            
            
            echo "<h1>".$show['title']."</h1>";
                  
            if($_SESSION['is_employee']==1){ 

                    //GET PERMISSIONS FOR THIS PAGE
             foreach($_SESSION['permissions'] as $key => $val){ 
                if($val==4){  
                   $permission=1;

                    }//end show link if has claims permissions 
                }//end check permissions 
                if($permission==1){
                echo "<br/><a href=\"update_claim.php?id=".$_GET['id']."\">Update This Claim</a><br/>";
                }
            } //end check if employee
                  
                  
            echo "<h2> Pending</h2>";
             if($show['user_id']===$_SESSION['user_id'] ){
                 echo "<a href=\"#\">Revoke this claim</a><br/>";
             }//end revoke option
            
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
            }else{
        echo "Oops! It looks like you do not have permission to be here";
     }  
        }
     }
    
}else{

    echo "This claim does not exist!";
}
 ?>
     
        
      
        
<?php include("inc/footer.php"); ?>