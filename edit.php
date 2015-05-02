<?php include("inc/header.php");  

$no_author=0;
$book_id =$_GET['book_id'];

$query = "SELECT * FROM books WHERE id = {$book_id}";
$current_book = mysqli_query($connection, $query);


//for each book_id, get data

$book = mysqli_fetch_assoc($current_book);
$old_title =$book["title"];  
$old_description =$book["description"]; 
$old_published =$book["published"]; 
$old_ISBN =$book["ISBN"]; 
$author_id=$book['author_id'];
$color=$book['color'];
$genre=$book['genre'];
    
        $author_q2 = "SELECT * FROM authors WHERE id = {$author_id}";
        $author_result2 = mysqli_query($connection, $author_q2);
    
        if($author_result2){
            //author found
            $author_array2 = mysqli_fetch_assoc($author_result2);
            $author_name=$author_array2['name'];
        }else{
            //author not found
            $author_name="No Author Assigned";
        }


        $genre_q2 = "SELECT * FROM genres WHERE id = {$genre}";
        $genre_result2 = mysqli_query($connection, $genre_q2);
    
        if($genre_result2){
            //genre found
            $genre_array2 = mysqli_fetch_assoc($genre_result2);
            $genre_name=$genre_array2['name'];
        }else{
            //genre not found
            $genre_name="No Genre Assigned";
        }
 


 

if (isset($_POST['submit'])) {
    
    
  // Process the form
  
   
  $title = mysql_prep($_POST["title"]); 
  $author = mysql_prep($_POST["author"]); 
  $description = mysql_prep($_POST["description"]); 
  $published = mysql_prep($_POST["published"]); 
  $ISBN = mysql_prep($_POST["ISBN"]); 
  $color = mysql_prep($_POST["color"]); 
  $genre = mysql_prep($_POST["genre"]); 
 

  // validations
  $required_fields = array("title");
  validate_presences($required_fields);
   
  
  if (empty($errors)) {
      
    
   // Perform Update BOOK
      
    $update_book  = "UPDATE books SET ";
    $update_book .= "title = '{$title}', ";
    $update_book .= "description = '{$description}', ";
    $update_book .= "ISBN = '{$ISBN}', ";
    $update_book .= "color = '{$color}', ";
    $update_book .= "genre = '{$genre}', ";
    $update_book .= "published = '{$published}' ";
    $update_book .= "WHERE id = {$book_id} ";
    $result = mysqli_query($connection, $update_book);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
        $_SESSION["message"] = "book updated.";
        redirect_to("view.php?book_id={$book_id}");

    } else {
      // Failure
      $_SESSION["message"] = "book update failed.";
        redirect_to("edit.php?book_id={$book_id}");
        
    }//END UPDATE BOOK
      

  }else{
      $_SESSION["message"] = "book update failed!!";
     redirect_to("edit.php?book_id={$book_id}");
  }
} else {
  // This is probably a GET request
     
} // end: if (isset($_POST['submit']))

?>
<script>
//SHOW COLOR PREVIEW
    function myfunction(val) {
         var $color=(val);
         var element = document.getElementById('viewColor');
//        element.innerHTML = $color; 
        element.setAttribute("class", $color);

    }
 
</script>
 
    <h2>Edit book: <?php echo htmlentities($title); ?></h2>
    <form action="edit.php?book_id=<?php echo $book_id; ?>" method="post">
      <p>Title:
        <input type="text" name="title" value="<?php echo htmlentities($old_title); ?>" />
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>" />
      </p>
      
          
          
           <p>Genre:  
          <?php 
                $query  = "SELECT * FROM genres ORDER BY name";  
    $result = mysqli_query($connection, $query);
    $num_rows=mysqli_num_rows($result);
    if($num_rows >= 1){
       echo " <select name=\"genre\" id=\"genre\">";
        echo "<option name=\"genre\" value=\"".$genre."\">".$genre_name."</option>";
        foreach($result as $genre){
            echo "<option name=\"genre\" value=".$genre['id'].">".$genre['name']."</option>";
        }
         echo "</select>";
    } ?></p>
      
      
      
        <p>Author: <?php echo htmlentities($author_name); ?>
<!--        <input type="text" name="author" value="<?php echo htmlentities($author_name); ?>" /> -->
<!--       <a href="edit_author.php?book_id=<?php echo htmlentities($book_id); ?>">Edit Author</a>-->
        </p>
      
      <p>Published:<br/>
        <input type="text" name="published" value="<?php echo htmlentities($old_published); ?>" />
      </p>
      
       <p>ISBN:<br/>
        <input type="text" name="ISBN" value="<?php echo htmlentities($old_ISBN); ?>" />
      </p>
      
        <p>Description:<br/>
        <textarea cols="100" rows="20" name="description" value="<?php echo htmlentities($description); ?>" ><?php echo htmlentities($old_description); ?></textarea>
      </p>
      
                  Cover Color: <select onchange="myfunction(this.value);" name="color" id="color">
<!--            selected="selected" -->
            <option name="color" value="<?php echo htmlentities($color); ?>"><?php echo htmlentities($color); ?></option>
            <option name="color" value="beige">Beige</option>
            <option name="color" value="red">Red</option>
            <option name="color" value="purple">Purple</option>
            <option name="color" value="seagreen">SeaGreen</option>
            <option name="color" value="gold">Gold</option>
        </select>
        <div id="viewColor"></div>
       

      <input type="submit" name="submit" value="Save" />
    </form>
    <br />
    <a href="view.php?book_id=<?php echo $book_id ?>">Cancel</a>
    &nbsp;
    &nbsp;
    <a href="delete.php?book_id=<?php echo urlencode($book_id); ?>" onclick="return confirm('Are you sure?');">Delete book</a>
    <hr/><br/>
 
<?php include("inc/footer.php"); ?> 