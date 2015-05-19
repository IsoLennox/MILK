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
            
//           
        echo $query_string."<br/>";
// 
////            =======================================================
//            
//                        //USER SEARCH
//            
////            =======================================================
//            
            //if employee only: search poilicy numbers, names, and emails
//            
       if($user_search==1){ 
           
            
           
           
           
           
            $user_search="SELECT * FROM users WHERE name LIKE '%" . $query_string .  "%' ";
            //-run  the query against the mysql query function
            $user_result=mysqli_query($connection, $user_search);
           if($user_result){
            $user_result_array=mysqli_fetch_assoc($user_result);
 
            if(!empty($user_result_array)){
                echo "<h2>users Names that contain \"". $query_string ."\":</h2>"; 
                   foreach($user_result as $contact_match){
                        $name  =$contact_match['name'];
                        $user_id  =$contact_match['id'];
                 //STYLE OUTPUT       
echo "<a href=\"profile.php?user=$user_id\"><h3>".$name."</h3></a> ";
                    }//end foreach user found with name match
            }else{
               // mark no results variable
                echo "No users found";
            }// END SEARCH user!
           }else{
               // mark no results variable
                echo "No users found";
            }// END SEARCH user!
       }//end get permissions

       
            
}//end foreach string

  
 
    
    
    
  
}//END SUBMIT
 
include("inc/footer.php"); ?> 