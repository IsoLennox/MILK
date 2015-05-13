<?php
$file_name = basename($_FILES["image"]["name"]);

//$file_name = str_replace(' ', '', $file_name);
$file_name = str_replace(array(':', '_', ' ', '-', '!'), '', $file_name);


$target_file = $target_dir . $file_name;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);

}
// Check if file already exists
if (file_exists($target_file)) {
   // echo "Sorry, FILE NAME already exists.";
    $_SESSION["message"] = "Sorry, FILE NAME already exists.";
    $uploadOk = 0;
}
// Check file size
//if ($_FILES["image"]["size"] > 5000000) {
//    //echo "Sorry, your file is too large.";
//    $_SESSION["message"] = "Sorry, your file is too large. 5000kb is the max file size.";
//    $uploadOk = 0;
//}
// Allow certain file formats
if($imageFileType != "PDF" && $imageFileType != "pdf" && $imageFileType != "epub") {
    
    $_SESSION["message"] = "Sorry, only PDF and ePub files are accepted.";
    $uploadOk = 0;
}

 



// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $_SESSION["message"] .= "    Your file was not uploaded.";
    redirect_to("add_book.php");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        //FILE UPLOADED! 
        
        
        
        //WRITE FILE TO TABLE
 $uploaded_by = $_SESSION["user_id"];
    $dateTimeVariable = date("F j, Y \a\t g:ia");
    $query  = "INSERT INTO books ("; 
    $query .= " uploaded_by, date_uploaded, title, file,  description, ISBN, published, color, genre ";
    $query .= ") VALUES ("; 
    $query .= " {$uploaded_by}, '{$dateTimeVariable}', '{$title}', '{$target_file}', '{$description}', '{$isbn}', '{$published}', '{$color}', '{$genre}' ";
    $query .= ")";
    $result = mysqli_query($connection, $query);
         
         

    if ($result && mysqli_affected_rows($connection) == 1) {
        // Success: file uploaded&&path written.
        
                //get this book ID
    $bookquery  = "SELECT * FROM books WHERE ISBN={$isbn} ORDER BY id DESC LIMIT 1"; 
    $bookresult = mysqli_query($connection, $bookquery);
        
        if($bookresult){
            //book exists, insert author
            $book_array=mysqli_fetch_assoc($bookresult);
            $book_id=$book_array['id'];
            
            
            
            
            
                       //get authors from authors table
    $authorquery1  = "SELECT * FROM authors WHERE name='{$author}' "; 
    $authorresult1 = mysqli_query($connection, $authorquery1);
        
       $num_rows = mysqli_num_rows($authorresult1);


        if($num_rows>=1){
         
      
                        //author exists, write to authors_books
            $author_array=mysqli_fetch_assoc($authorresult1);
            $author_id=$author_array['id'];
               
            $update_book  = "UPDATE books SET ";
            $update_book .= "author_id = '{$author_id}' ";
            $update_book .= "WHERE id = {$book_id} ";
            $result = mysqli_query($connection, $update_book);

            if ($result && mysqli_affected_rows($connection) == 1) {
              // Success
               $_SESSION["message"] = "File Upload Successful!";          
              redirect_to("user_uploads.php");

            } else {
              // Failure
              $_SESSION["message"] = "Author not added to book";
                redirect_to("user_uploads.php");


            }//END UPDATE BOOK
            
            
            
            
        
        }else{
            //CREATE NEW AUTHOR
            
                            //WRITE FILE TO TABLE 
    $query  = "INSERT INTO authors ("; 
    $query .= " name ";
    $query .= ") VALUES ("; 
    $query .= " '{$author}' ";
    $query .= ")";
    $result2 = mysqli_query($connection, $query);
         
         

    if ($result2 && mysqli_affected_rows($connection) == 1) {
        
        //Created Author
//         $_SESSION["message"] ="Created author.";       
//              redirect_to("user_uploads.php");
        //find author
        //write to authors_books
        
        
                    
                       //get authors from authors table
    $authorquery2  = "SELECT * FROM authors WHERE name='{$author}' "; 
    $authorresult2 = mysqli_query($connection, $authorquery2);
        
       $num_rows2 = mysqli_num_rows($authorresult2);


        if($num_rows2>=1){
        
//            $_SESSION["message"] = "Author Exists!";     
//              redirect_to("user_uploads.php");
            
                        //author exists, write to authors_books
            $author_array=mysqli_fetch_assoc($authorresult2);
            $author_id=$author_array['id'];
            
                            //WRITE AUTHOR IN TO BOOK TABLE 
            $update_book  = "UPDATE books SET ";
            $update_book .= "author_id = '{$author_id}' ";
            $update_book .= "WHERE id = {$book_id} ";
            $result = mysqli_query($connection, $update_book);

            if ($result && mysqli_affected_rows($connection) == 1) {
              // Success
               $_SESSION["message"] = "File Upload Successful!";          
              redirect_to("user_uploads.php");

            } else {
              // Failure
              $_SESSION["message"] = "Could Not write author.";
                redirect_to("user_uploads.php");


            }//END UPDATE BOOK
            
            
        
        }else{
         $_SESSION["message"] ="Created Author. Could Not find new author.";       
              redirect_to("user_uploads.php");
        }
        
        
    }else{
        
        $_SESSION["message"] ="Could not create author.";       
              redirect_to("user_uploads.php");
    
    }
            
            
    
            
        }//end if author exists
            
        }else{
        
            
            $_SESSION["message"] = "Book Uploaded: Cannot Find BOOK!";     
              redirect_to("user_uploads.php");
        }//end get BOOK ID
        
        
        

 
    }else {
      // Failure
      $_SESSION["message"] = "File uploaded. Filepath NOT written.".$target_file." ".$user_id;
         unlink($target_file);
        redirect_to("add_book.php");
    }
        
    } else {
       $_SESSION["message"] = "Sorry, there was an error uploading your file.";
        redirect_to("add_book.php");
    }
}
    

?>