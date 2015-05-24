<?php include("inc/header.php"); ?> 

<?php 
//seader searchbar
if(isset($_POST['search'])){
 
        
        //    HEADER SEARCH : EMPLOYEES
//    - all users
//    - all claims and items
// contents of messages??
//    if time:
        //special searches such as: strings that start with '@' only search through users
        
        //CLIENTS
    //- search all items and claims (body and dates)
        // If time:
        //special search: strings that start with 'trash:' will only search items in trash
        //": strings that stert with 'Month'(i.e. 'Dec' or 'December') or 'Y' will search only claims/items' posted and updated dates that start with correlating month or year
    
         
           // get string entered
            $string=$_POST['query'];
                
            
//            if (substr( $string, 0, 1 ) === "\"" ){
//                //string is in quotes, search undilemited by spaces
//                $string_array=explode("\"",$string);
//                
//                //check search type
//                
//                if($_SESSION['is_employee']==1){
//                    $user_search=1;
//                    $claim_search=1;
//                    $item_search=1;
//                }else{
//                    $user_search=0;
//                    $claim_search=1; //only if yours (defined in query)
//                    $item_search=1; //only if yours
//                }
//                
//                
//            }elseif (substr( $string, 0, 1 ) === "@" ){
//                
//                //only search for users
//                
//                $string_array=ltrim ($str, '@'); 
//              
//                
//                if($_SESSION['is_employee']==1){
//                    $user_search=1;
//                    $claim_search=0;
//                    $item_search=0;
//                }else{
//                    $user_search=0;
//                    $claim_search=0;
//                    $item_search=0;
//                }
//            
//            }else{
//                //if space separated and not in quotes, explode string
//                $string_array= explode(" ",$string);
//                
//                if($_SESSION['is_employee']==1){
//                    $user_search=1;
//                    $claim_search=1;
//                    $item_search=1;
//                }else{
//                    $user_search=0;
//                    $claim_search=1; //only if yours (defined in query)
//                    $item_search=1; //only if yours
//                }
//            }
    
    
    
            
            if (substr( $string, 0, 1 ) === "\"" ){
                //string is in quotes, search undilemited by spaces
                $string=ltrim ($string, '"');
                $string=rtrim ($string, '"'); 
                $string_array=explode("\"",$string);

            }else{    $string_array= explode(" ",$string); }
    
    
    
    
            if ($string== "" ){
                echo "Please enter a search query";
            }else{
            
        foreach($string_array as $word){ 
            $query_string=$word; 
            
//           TO DO: prepopulate search bar with query
        echo "Searching for: ".$query_string."<br/><br/>";
 
            
            
            
            
////            =======================================================
//            
//                        //USER SEARCH
//            
////            =======================================================
//            
            //if employee only: search poilicy numbers, names, and emails
//            
      if($_SESSION['is_employee']==1){  
            $user_search="SELECT * FROM users WHERE first_name LIKE '%" . $query_string .  "%' OR last_name LIKE '%" . $query_string .  "%' OR email LIKE '%" . $query_string .  "%' OR policy_number LIKE '" . $query_string .  "'  ";
            //-run  the query against the mysql query function
            $user_result=mysqli_query($connection, $user_search);
           if($user_result){
            $user_result_array=mysqli_fetch_assoc($user_result);
 
            if(!empty($user_result_array)){
                echo "<h2>Users that contain \"". $query_string ."\":</h2><br/><br/>"; 
                   foreach($user_result as $contact_match){
                        $name  =$contact_match['first_name']." ".$contact_match['last_name'];
                        $email  =$contact_match['email']; 
                        $user_id  =$contact_match['id'];
                 //STYLE OUTPUT       
                        echo "<a href=\"profile.php?user=$user_id\"><h3>".$name."</h3></a> ";
                        //GET PERMISSIONS FOR THIS PAGE
                         foreach($_SESSION['permissions'] as $key => $val){  
                             //EDIT EMPLOYEES
                            if($val==2){ 
                                echo "<a href=\"employees.php?edit_role=".$user_id."\"><i class=\"fa fa-user-secret\"></i> Edit Role </a>";
                                echo "<a href=\"employees.php?edit_pass=".$user_id."\"><i class=\"fa fa-unlock-alt\"></i> Change Password </a>"; 

                                //See if user account is active
                                if($contact_match['account_disabled']=="0"){
                                    echo "<a class=\"right \" href=\"employees.php?disable=1&user=".$user_id."\"><i class=\"fa fa-times red\"></i>Disable Account</a>";
                                }else{
                                    //endable account
                                     echo "<a class=\"right \" href=\"employees.php?disable=0&user=".$user_id."\"><i class=\"fa fa-check green\"></i>Reactivate Account</a>";
                                        }  
                                    }//end check permission array 
                                }//end see if has permissions to edit employees 
                       
                    }//end foreach user found with name match
                
                echo "<hr/>";
            } 
          
       }//end user search
      }//end check that is employee

            
            
////            =======================================================
//            
//                        //ITEM SEARCH
//            
////            =======================================================
 
           
           if($_SESSION['is_employee']==0){
               //is client, only search YOUR items
               $yours="AND user_id={$_SESSION['user_id']}";
               $item_search="SELECT * FROM items WHERE ( name LIKE '%" . $query_string .  "%' OR notes LIKE '%" . $query_string .  "%') AND user_id={$_SESSION['user_id']} ";
           }else{
               $item_search="SELECT * FROM items WHERE name LIKE '%" . $query_string .  "%' OR notes LIKE '%" . $query_string .  "%' ";
           }
            
            $item_result=mysqli_query($connection, $item_search);
           if($item_result){
            $item_result_array=mysqli_fetch_assoc($item_result);
 
            if(!empty($item_result_array)){
                echo "<h2>Items that contain \"". $query_string ."\":</h2>"; 
                   foreach($item_result as $item_match){
                       echo "<div class=\"notes_container\">";
                         //Check to see if involved in claim
                        $item_claim_query  = "SELECT * FROM claim_items WHERE item_id={$item_match['id']}"; 
                        $item_claim_result = mysqli_query($connection, $item_claim_query);
                        $claim_item_rows=mysqli_num_rows($item_claim_result);
                        if($claim_item_rows >= 1){ 
                            $claim_class="<p style=\"color:red;\"> Involved in claim </p>"; 
                        }else{
                            $claim_class="";
                        }

                        $id=$item_match['id'];
                        $name=$item_match['name'];
                        echo "<p><a href=\"item_details.php?id=".$id."\">".$name."</a><br/>";
                            echo $claim_class;
                            $room_name=get_room_name($item_match['room_id']);
                            $cat_name=get_category_name($item_match['category']);
                            echo "Category: ".$cat_name."<br/>";
                            echo "Room: ".$room_name . "</p>";
                            echo "</div>";
                    }//end foreach item found with name match
                
                echo "<hr/>";
            } 
           } //end item search
            
            
            
            
            
                        
            
////            =======================================================
//            
//                        //Claims SEARCH
//            
////            =======================================================
           
      
           if($_SESSION['is_employee']==0){
               //is client, only search YOUR claims
                
               $claim_search="SELECT * FROM claims WHERE (title LIKE '%" . $query_string .  "%' OR notes LIKE '%" . $query_string .  "%') AND user_id={$_SESSION['user_id']} ";
           }else{
              $claim_search="SELECT * FROM claims WHERE title LIKE '%" . $query_string .  "%' OR notes LIKE '%" . $query_string .  "%' ".$yours." ";
           }
           
           
            
            //-run  the query against the mysql query function
            $claim_result=mysqli_query($connection, $claim_search);
           if($claim_result){
            $claim_result_array=mysqli_fetch_assoc($claim_result);
 
            if(!empty($claim_result_array)){
                echo "<h2>Claims that contain \"". $query_string ."\":</h2>"; 
                   foreach($claim_result as $claim_match){
                       
                       
            echo "<div class=\"notes_container\">";
                        //GET CLAIM TYPE NAME
            $type_query  = "SELECT * FROM claim_types WHERE id={$claim_match['claim_type']}";  
            $type_result = mysqli_query($connection, $type_query);
            if($type_result){
                $type_array=mysqli_fetch_assoc($type_result);
                $claim_type=$type_array['name'];
            }
            
            
            echo "<h2>".$claim_match['title']."</h2>"; 
            echo "Date Filed: ".$claim_match['datetime']."<br/>";
            echo "Status: Pending<br/>";
            echo "Claim Type: ".$claim_type."<br/>"; 
             echo "<a href=\"claim_details.php?id=".$claim_match['id']."\">View this Claim</a>"; 
            
            echo "</div>"; 
                 //STYLE OUTPUT       
echo "<a href=\"claim_details.php?id=$claim_id\"><h3>".$name."</h3></a> ";
                    }//end foreach claim found with name match
                
                echo "<hr/>";
            } 
           } //end claim search
            
            
       
            
}//end foreach string

  
 
    
    
            }
  
}//END SUBMIT
 
include("inc/footer.php"); ?> 