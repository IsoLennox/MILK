<?php require_once("inc/db_connection.php"); 

if(isset($_GET['uname'])){
    
    //Gets username value from the URL
$uname = $_GET['uname'];

//Checks if the username is available or not
$query = "SELECT username FROM customers WHERE username = '$uname'";

$result = mysqli_query($connection, $query);

//Prints the result
if (mysqli_num_rows($result)<1) {
	echo "<span class='green'>Available!</span>";
}
else{
	echo "<span class='red'><strong>Username '".$uname."' Not available!<strong></span>";
}
}//end validate username



if(isset($_GET['isbn'])){
    
    //Gets username value from the URL
$ISBN = $_GET['isbn'];

//Checks if the username is available or not
$query = "SELECT * FROM books WHERE ISBN = '$ISBN'";

$result = mysqli_query($connection, $query);
    

//Prints the result
if (mysqli_num_rows($result)<1 ) {
    //ISBN NOT IN DATABASE
    //Show upload form
	echo '<input type="submit" value="Create" name="submit">';
}else{
    //BOOK EXISTS
//	echo "This book exists: Show books";
    
    $book=mysqli_fetch_assoc($result);
    
    if($book['ISBN']!=0){
    echo "<a href=\"view.php?book_id={$book['id']}\"><div class=\"hover-row book-list\">";
    echo "<span class=\"title\">".$book['title']."</span><br/>";
        
        
        //GET AUTHOR IS AND NAME
        $find_books  = "SELECT * ";
        $find_books .= "FROM authors_books ";
        $find_books .= "WHERE book_id = {$book['id']} ";
        $book_set = mysqli_query($connection, $find_books);
        if($book_set){
            $book_array=mysqli_fetch_assoc($book_set);
            $author_id=$book_array['author_id'];

            
            
            $find_author  = "SELECT * ";
            $find_author .= "FROM authors ";
            $find_author .= "WHERE id = {$author_id} ";
            $author_set = mysqli_query($connection, $find_author);
            if($author_set){
                $author_array=mysqli_fetch_assoc($author_set);
                $name=$author_array['name'];
            }
        }//END GET AUTHOR ID AND NAME
        
        echo $name."</br><hr/>";
        echo $book['description']."<br/>";
        echo "</div></a><br/><Br/><br/><Br/>";
    
    }else{
        echo '<input type="submit" value="Create" name="submit">';
    }//end check if ISB ==0
    
}
}//end validate username




if(isset($_GET['email'])){
    
    //Gets email value from the URL
$email = $_GET['email'];

//Checks if the email is available or not
$query = "SELECT email FROM customers WHERE email = '$email'";

$result = mysqli_query($connection, $query);

//Prints the result
if (mysqli_num_rows($result)<1) {
	echo "<span class='green'>Available!</span>";
}
else{
	echo "<span class='red'><strong>Email '".$email."' Already In Use!<strong></span>";
}
}//end validate email


if(isset($_GET['forgotemail'])){
    
    //Gets email value from the URL
$email = $_GET['forgotemail'];

//Checks if the email is available or not
$query = "SELECT email FROM customers WHERE email = '$email'";

$result = mysqli_query($connection, $query);

//Prints the result
if (mysqli_num_rows($result)<1) {

    
    	echo "<span class='red'><strong>Email '".$email."' Is Not Connected An Account!<strong></span>";
}
else{
    
    	echo "<span class='green'>There you are!</span>";

}
}//end validate email

?> 