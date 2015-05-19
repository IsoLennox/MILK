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
                $string_array=explode("\"",$string);
                
                //check search type
                
                if($_SESSION['is_employee']==1){
                    $user_search=1;
                    $claim_search=1;
                    $item_search=1;
                }else{
                    $user_search=0;
                    $claim_search=1; //only if yours (defined in query)
                    $item_search=1; //only if yours
                }
                
                
            }else{ 
         $string_array= explode(" ",$string);
                
                if($_SESSION['is_employee']==1){
                    $user_search=1;
                    $claim_search=1;
                    $item_search=1;
                }else{
                    $user_search=0;
                    $claim_search=1; //only if yours (defined in query)
                    $item_search=1; //only if yours
                }
                    
            }
    
    
    
    
            
            
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
       if($user_search==1){ 
            $user_search="SELECT * FROM users WHERE first_name LIKE '%" . $query_string .  "%' OR last_name LIKE '%" . $query_string .  "%' OR email LIKE '%" . $query_string .  "%' OR policy_number LIKE '" . $query_string .  "'  ";
            //-run  the query against the mysql query function
            $user_result=mysqli_query($connection, $user_search);
           if($user_result){
            $user_result_array=mysqli_fetch_assoc($user_result);
 
            if(!empty($user_result_array)){
                echo "<h2>Users that contain \"". $query_string ."\":</h2>"; 
                   foreach($user_result as $contact_match){
                        $name  =$contact_match['first_name']." ".$contact_match['last_name'];
                        $email  =$contact_match['email']; 
                        $user_id  =$contact_match['id'];
                 //STYLE OUTPUT       
echo "<a href=\"profile.php?user=$user_id\"><h3>".$name."</h3></a> ";
                    }//end foreach user found with name match
                
                echo "<hr/>";
            } 
           }
       }//end get permissions

            
            
            
            
            
////            =======================================================
//            
//                        //ITEM SEARCH
//            
////            =======================================================
//            
            //if employee only: search poilicy numbers, names, and emails
//            
       if($item_search==1){ 
           
           if($_SESSION['is_employee']==0){
               //is client, only search YOUR items
               $yours="AND user_id={$_SESSION['user_id']}";
           }else{
                $yours="";
           }
           
           
            $item_search="SELECT * FROM items WHERE name LIKE '%" . $query_string .  "%' OR notes LIKE '%" . $query_string .  "%' ".$yours." ";
            //-run  the query against the mysql query function
            $item_result=mysqli_query($connection, $item_search);
           if($item_result){
            $item_result_array=mysqli_fetch_assoc($item_result);
 
            if(!empty($item_result_array)){
                echo "<h2>Items that contain \"". $query_string ."\":</h2>"; 
                   foreach($item_result as $item_match){
                        $name  =$item_match['name'];
                        $email  =$item_match['email']; 
                        $item_id  =$item_match['id'];
                 //STYLE OUTPUT       
echo "<a href=\"item_details.php?id=$item_id\"><h3>".$name."</h3></a> ";
                    }//end foreach item found with name match
                
                echo "<hr/>";
            } 
           }
       }//end get permissions
            
            
            
            
            
                        
            
////            =======================================================
//            
//                        //Claims SEARCH
//            
////            =======================================================
//            
//            
       if($claim_search==1){ 
           if($_SESSION['is_employee']==0){
               //is client, only search YOUR claims
               $yours="AND user_id={$_SESSION['user_id']}";
           }else{
                $yours="";
           }
           
           
            $claim_search="SELECT * FROM claims WHERE name LIKE '%" . $query_string .  "%' OR notes LIKE '%" . $query_string .  "%' ".$yours." ";
            //-run  the query against the mysql query function
            $claim_result=mysqli_query($connection, $claim_search);
           if($claim_result){
            $claim_result_array=mysqli_fetch_assoc($claim_result);
 
            if(!empty($claim_result_array)){
                echo "<h2>claims that contain \"". $query_string ."\":</h2>"; 
                   foreach($claim_result as $claim_match){
                        $name  =$claim_match['name'];
                        $email  =$claim_match['email']; 
                        $claim_id  =$claim_match['id'];
                 //STYLE OUTPUT       
echo "<a href=\"claim_details.php?id=$claim_id\"><h3>".$name."</h3></a> ";
                    }//end foreach claim found with name match
                
                echo "<hr/>";
            } 
           }
       }//end get permissions
            
            
       
            
}//end foreach string

  
 
    
    
    
  
}//END SUBMIT
 
include("inc/footer.php"); ?> 