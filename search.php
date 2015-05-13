<?php include("inc/header.php"); ?> 

<?php 

if(isset($_POST['submit'])){
           
    

//    HEADER SEARCH
//    HEADER SEARCH
//    HEADER SEARCH
    
    if(isset($_GET['all'])){
        
        //    HEADER SEARCH
//    - titles
//    - authors
//    - ISBN
//    - usernames
    
        if(preg_match("/^[_a-zA-Z0-9- ]+$/", $_POST['query'])){
         
           // get string entered
                $string=$_POST['query'];
                
//            //if space separated, explode string
//            $string_array= explode(" ",$string);
            
                 //if comma separated, explode string
                $string_array= explode(",",$string);
         
            //prepare variable for no results message
            $no_results=4;
            
            
        foreach($string_array as $word){ 
            $query_string=$word; 
       
 
//            =======================================================
            
                        //AUTHOR SEARCH
            
//            =======================================================
            
            
            
            $author_search="SELECT * FROM authors WHERE name LIKE '%" . $query_string .  "%' ";
            //-run  the query against the mysql query function
            $author_result=mysqli_query($connection, $author_search);
            $author_result_array=mysqli_fetch_assoc($author_result);
 
            if(!empty($author_result_array)){
                echo "<h2>Authors Names that contain \"". $query_string ."\":</h2>"; 
                   foreach($author_result as $contact_match){
                        $name  =$contact_match['name'];
                        $author_id  =$contact_match['id'];
                 //STYLE OUTPUT       
echo "<a href=\"view_author.php?author=$author_id\"><h3>".$name."</h3></a> ";
                    }//end foreach author found with name match
            }else{
               // mark no results variable
                $no_results-=1;
            }// END SEARCH AUTHOR!
            

//            =======================================================
            
                        //TITLE SEARCH
            
//            =======================================================
            
                  
     
            $title_search="SELECT * FROM books WHERE title LIKE '%" . $query_string ."%' ";
            //-run  the query against the mysql query function
            $title_result=mysqli_query($connection, $title_search);
            $title_result_array=mysqli_fetch_assoc($title_result);
            if(!empty($title_result_array)){
                echo "<h2>Titles that contain \"". $query_string ."\":</h2>";
                   foreach($title_result as $book_match){
                        $title  =$book_match['title'];
                        $book_id  =$book_match['id'];
                        $author_id  =$book_match['author_id'];
  
                 //STYLE OUTPUT      
//                       echo "<a href=\"view.php?book_id=$book_id\"><h3>".$name."</h3></a>";
                       
                                       $find_author = find_author_by_id($author_id);
                $name= $find_author['name'];
                
        echo "<a href=\"view.php?book_id={$book_id}\">";
        echo "<div class=\"book {$book_match['color']}\"><div class=\"book-cover\">";
        echo "<h1 class=\"title\">".$title."</h1>";
        echo "<h5 class=\"author\"><span>written by</span> ".$name."</h5></div>";
        echo "<div class=\"book-top\"></div><div class=\"book-right\"></div></div></a>";
                       
                       
                    }//end foreach title found with name match
                
                 
            }else{
                echo "No books contain '". $query_string."'<br/>";
               // mark no results variable
                $no_results-=1;
            }// END SEARCH TITLE!
            
            
                        
////            =======================================================
//            
//                        //ISBN SEARCH
//            
////            =======================================================
//            
//                  
//     
            $ISBN_search="SELECT * FROM books WHERE isbn LIKE '%" . $query_string ."%' ";
            //-run  the query against the mysql query function
            $ISBN_result=mysqli_query($connection, $ISBN_search);
            if($ISBN_result){
            $ISBN_result_array=mysqli_fetch_assoc($ISBN_result);
                
                if(!empty($ISBN_result_array)){
            
                echo "<h2>ISBNs that start with \"". $query_string ."\":</h2>";
                   foreach($ISBN_result as $book_match){
                        $name  =$book_match['title'];
                        $book_id  =$book_match['id'];
  
                 //STYLE OUTPUT      
                       echo "<a href=\"view.php?book_id=$book_id\"><h3>".$name."</h3></a>";
                    }//end foreach ISBN found with name match
                
            }else{
//                echo "<br/>No ISBNs start with '". $query_string."'<br/>";
                }
            }else{
                echo "No ISBNs match this query";
               // mark no results variable
                $no_results-=1;
            }// END SEARCH ISBN!
            
            
            
 //            =======================================================
            
                        //USERNAME SEARCH
            
//            =======================================================
            
                  
     
            $username_search="SELECT * FROM users WHERE username LIKE '%" . $query_string ."%' ";
            //-run  the query against the mysql query function
            $username_result=mysqli_query($connection, $username_search);
            if($username_result){
                $username_result_array=mysqli_fetch_assoc($username_result);
                if(!empty($username_result_array)){
            
            
                echo "<h2 class=\"clear\">Usernames that contain \"". $query_string ."\":</h2>";
                   foreach($username_result as $user_match){
                        $username  =$user_match['username']; 
                        $user_id  =$user_match['id'];
  
                 //STYLE OUTPUT      
                       echo "<a href=\"profile.php?user=$user_id\"><h3>".$username."</h3></a>";
                    }//end foreach username found with name match
                }else{
//                echo "<br/>No usernames contain '". $query_string."'<br/>";
                }
            }else{
                echo "No usernames match this query";
               // mark no results variable
                $no_results-=1;
            }// END SEARCH USERNAME!
            
 
            
            
            }//end foreach string
        }//end PREG MATCH
  
    }//END SEARCH ALL (HEADER)
    
    
/*================================================================================*/   
    
//    AUTHOR BOOK SEARCH
//    AUTHOR BOOK SEARCH
//    AUTHOR BOOK SEARCH //SEARCH TITLES BY AUTHOR ID
     
/*================================================================================*/ 
    
    
    if(isset($_GET['books_by_author'])){
        $author_id=$_GET['books_by_author'];
        
        //   AUTHOR BOOK SEARCH
//    - titles

        if(preg_match("/^[_a-zA-Z0-9- ]+$/", $_POST['query'])){
                $string=$_POST['query'];
                $string_array= explode(",",$string);

            
        foreach($string_array as $word){ 
            $query_string=$word; 
     
            $title_search="SELECT * FROM books WHERE title LIKE '%" . $query_string ."%' AND author_id={$author_id}";
            //-run  the query against the mysql query function
            $title_result=mysqli_query($connection, $title_search);
            if($title_result){
                
                                //GET name
                $find_author = find_author_by_id($author_id);
                $name= $find_author['name'];
            $title_result_array=mysqli_fetch_assoc($title_result);
                
                if(!empty($title_result_array)){
                    
                     ?>
     
                     <h4>Books By <?php echo $name; ?> </h4>   
                    <form class="center search h4_search"  action="search.php?books_by_author=<?php echo $author_id; ?>" method="post">
                        <input class="" type="text" name="query" value="" placeholder="Search for titles by this author..." />    
                        <input type="submit" name="submit" value="&#xf002;" />
                    </form> 
                     <br/>
                    <?php

                    echo "<h2>Titles by ".$name." that contain \"". $query_string ."\":</h2>";
                    foreach($title_result as $book_match){
                        $title  =$book_match['title'];
                        $book_id  =$book_match['id'];
                        $description =$book_match['description'];

                                     //STYLE OUTPUT      

                        echo "<a href=\"view.php?book_id={$book_id}\">";
                        echo "<div class=\"book {$book_match['color']}\"><div class=\"book-cover\">";
                        echo "<h1 class=\"title\">".$title."</h1>";
                        echo "<h5 class=\"author\"><span>written by</span> ".$name."</h5></div>";
                        echo "<div class=\"book-top\"></div><div class=\"book-right\"></div></div></a>";
                       
                       
                       
                    }//end foreach title found with name match
                
            }else{
                    
                       ?>
     
                     <h4>Books By <?php echo $name; ?> </h4>   
                    <form class="center search h4_search"  action="search.php?books_by_author=<?php echo $author_id; ?>" method="post">
                        <input class="" type="text" name="query" value="" placeholder="Search for titles by this author..." />    
                        <input type="submit" name="submit" value="&#xf002;" />
                    </form> 
                     <br/>
                    <?php
//                echo "<br/>No titles contain '". $query_string."'<br/>";
                }
            }else{
                echo "No titles match this query";
               // mark no results variable
                $no_results-=1;
            }// END SEARCH BOOKS TABLE
        
        
            }
        }
    }// END SEARCH BOOKS BY AUTHOR ID
    
    
    
    
//=======================================================
//            
//      //SEARCH TITLES BY IN USER_ID UPLOADS
//            
//=======================================================
    
        if(isset($_GET['books_by_uploaded_by'])){
        $user_id=$_GET['books_by_uploaded_by'];


        if(preg_match("/^[_a-zA-Z0-9- ]+$/", $_POST['query'])){
                $string=$_POST['query'];
                $string_array= explode(",",$string);
            
                $find_user = find_user_by_id($user_id);
                $username= $find_user['username'];
                
                
                                ?>
                <h4>Uploads By <a href="profile.php?user=<?php echo $user_id; ?>"> <?php echo $username; ?></a> </h4>    
                    <form class="center search h4_search"  action="search.php?books_by_uploaded_by=<?php echo $user_id; ?>" method="post">
                        <input class="" type="text" name="query" value="" placeholder="Search for titles uploaded by this reader..." />    
                        <input type="submit" name="submit" value="&#xf002;" />
                    </form> <br/>
                    <a href="user_uploads.php?user=<?php echo $user_id; ?>">&laquo; View All</a><br/>
                
                <?php

            
        foreach($string_array as $word){ 
            $query_string=$word; 
            echo "<br/>Searched for: <strong>".$query_string."</strong><br/><br/>";
            
            //FIND BOOKS FROM BOOKS TABLE
 
            $title_search="SELECT * FROM books WHERE title LIKE '%" . $query_string ."%' AND uploaded_by={$user_id}";
            $title_result=mysqli_query($connection, $title_search);
            if($title_result){
                $title_result_array=mysqli_fetch_assoc($title_result);
                $author_id=$title_result_array['author_id'];
  
                if(!empty($title_result_array)){
                    
                                         //GET name
                $find_author = find_author_by_id($author_id);
                $name= $find_author['name'];
                     
//                    echo "<h2>Titles Uploaded by ".$username." that contain \"". $query_string ."\":</h2>";
                    foreach($title_result as $book_match){
                        $title  =$book_match['title'];
                        $book_id  =$book_match['id'];
                        $description =$book_match['description'];
  
                 //STYLE OUTPUT      
             
                            echo "<a href=\"view.php?book_id={$book_id}\">";
                            echo "<div class=\"book {$book_match['color']}\"><div class=\"book-cover\">";
                            echo "<h1 class=\"title\">".$title."</h1>";
                            echo "<h5 class=\"author\"><span>written by</span> ".$name."</h5></div>";
                            echo "<div class=\"book-top\"></div><div class=\"book-right\"></div></div></a>";
                        
                    }//end foreach title found with name match
                
            }else{
//                echo "No titles contain '". $query_string."'<br/>";
                }
            }else{                     ?>
                <h4>Uploads By <a href="profile.php?user=<?php echo $user_id; ?>"> <?php echo $username; ?></a> </h4>    
                    <form class="center search h4_search"  action="search.php?books_by_uploaded_by=<?php echo $user_id; ?>" method="post">
                        <input class="" type="text" name="query" value="" placeholder="Search for titles uplaoded by this reader..." />    
                        <input type="submit" name="submit" value="&#xf002;" />
                    </form> <br/>
                    <a href="user_uploads.php?user=<?php echo $user_id; ?>">&laquo; View All</a><br/>
                
                <?php
                echo "No titles match this query";
               // mark no results variable
                $no_results-=1;
            }// END SEARCH BOOKS TABLE
            
            
            
            
            
            
            
            
        //FIND AUTHORS THAT MATCH QUERY
 
            $author_search="SELECT * FROM authors WHERE name LIKE '%" . $query_string ."%'";
            $author_result=mysqli_query($connection, $author_search);
            if($author_result){
                    foreach($author_result as $author){
                        $name=$author['name'];
                        
              //GET BOOKS With this author
                   $book_by_author_search="SELECT * FROM books WHERE author_id={$author['id']} AND uploaded_by={$user_id}";
                        $book_by_author_result=mysqli_query($connection, $book_by_author_search);
                        if($book_by_author_result){
                            //foreach book_by_author by that author, GET books in user_id bookshelf by that user AND user_id
                            foreach($book_by_author_result as $book){                                
                                        echo "<a href=\"view.php?book_id={$book['id']}\">";
                                        echo "<div class=\"book {$book['color']}\"><div class=\"book-cover\">";
                                            echo "<h1 class=\"title\">".$book['title']."</h1>";
                                        echo "<h5 class=\"author\"><span>written by</span> ".$name."</h5></div>";
                                        echo "<div class=\"book-top\"></div><div class=\"book-right\"></div></div></a>";
                                }
 
                        }
                    
                }
                    
            
  
            }else{
                echo "No Authors uploaded by ".$username." that contain '". $query_string."'<br/>";
                }//end if author query match/result
            
            
        }//end foreach word queried
    }// END PREG MATCH    
 }//END IF ISSET USER UPLOADS
    
    
    
    
    
    
    
    
    
    
    
    
//=======================================================
//            
//      //SEARCH TITLES BY IN USER_ID BOOKSHELF
//            
//=======================================================
    
        if(isset($_GET['bookshelf'])){
        $user_id=$_GET['bookshelf'];


        if(preg_match("/^[_a-zA-Z0-9- ]+$/", $_POST['query'])){
                $string=$_POST['query'];
                $string_array= explode(",",$string);
            
                $find_user = find_user_by_id($user_id);
                $username= $find_user['username'];
                
                
                                ?>
                <h4><a href="profile.php?user=<?php echo $user_id; ?>"> <?php echo $username; ?></a>'s Bookshelf </h4>    
                    <form class="center search h4_search"  action="search.php?bookshelf=<?php echo $user_id; ?>" method="post">
                        <input class="" type="text" name="query" value="" placeholder="Search this bookshelf..." />    
                        <input type="submit" name="submit" value="&#xf002;" />
                    </form> <br/>
                    <a href="bookshelf.php?user=<?php echo $user_id; ?>">&laquo; View All</a><br/>
                
                <?php
            
        foreach($string_array as $word){ 
            $query_string=$word; 
            echo "<br/>Searched for: <strong>".$query_string."</strong><br/><br/>";
            
            $bookshelf_search="SELECT * FROM bookshelves WHERE user_id={$user_id}";
            $bookshelf_result=mysqli_query($connection, $bookshelf_search);
            if($bookshelf_result){
                foreach($bookshelf_result as $bookshelf_book){
                    
                    
                    //SEARCH BOOK DATA FOR EACH BOOK IN BOOKSHELF
                    $book_search="SELECT * FROM books WHERE id={$bookshelf_book['book_id']} AND title LIKE '%" . $query_string ."%'";
                    $book_result=mysqli_query($connection, $book_search);
                    if($book_result){ 
                        foreach($book_result as $book){
                                        $author_id=$book['author_id'];
                                        $find_author = find_author_by_id($author_id);
                                        $name= $find_author['name'];
                                        echo "<a href=\"view.php?book_id={$book['id']}\">";
                                        echo "<div class=\"book {$book['color']}\"><div class=\"book-cover\">";
                                        echo "<h1 class=\"title\">".$book['title']."</h1>";
                                        echo "<h5 class=\"author\"><span>written by</span> ".$name."</h5></div>";
                                        echo "<div class=\"book-top\"></div><div class=\"book-right\"></div></div></a>";
                        }

                        }else{
                            echo "No titles found <br/>";
                        }

                    
                  //search authors who's BOOK IDs are in bookshelf BY NAME LIKE QUERY 
                    
                    $author_search="SELECT * FROM books WHERE id={$bookshelf_book['book_id']}";
                    $author_result=mysqli_query($connection, $author_search);
                    if($author_result){ 
                        foreach($author_result as $author){
                            $author_search2="SELECT * FROM authors WHERE id={$author['author_id']} AND name LIKE '%" . $query_string ."%'";
                            $author_result2=mysqli_query($connection, $author_search2);
                            if($author_result2){ 
                                foreach($author_result2 as $author2){
//                                    echo "Author found.<br/>";
 
                                                echo "<a href=\"view.php?book_id={$author['id']}\">";
                                                echo "<div class=\"book {$author['color']}\"><div class=\"book-cover\">";
                                                echo "<h1 class=\"title\">".$author['title']."</h1>";
                                                echo "<h5 class=\"author\"><span>written by</span> ".$author2['name']."</h5></div>";
                                                echo "<div class=\"book-top\"></div><div class=\"book-right\"></div></div></a>";
                                }//end foerach author with name matching query

                                }else{
                                    echo "No titles found <br/>";
                                } 

                        }//foreach book in bookshelf
                    }//if books found in bookshelf
                    
            }//end foreach book in bookshelf
                    
                }//end limit books to bookshelf
                
 
 
        }//end foreach word queried
    }// END PREG MATCH    
 }//END IF ISSET USER BOOKSHELF
    
       
 
    
    
 
    
    
}//END SUBMIT
 
include("inc/footer.php"); ?> 