<?php require_once("inc/db_connection.php"); 
 
if(isset($_GET['email'])){
    
    //Gets email value from the URL
$email = $_GET['email'];

    
       if (!filter_var($_GET["email"], FILTER_VALIDATE_EMAIL)) {
           //email not properly formatted
           echo "<span class='red'><strong>Email INVALID!<strong></span>";
           $submit = "Please Enter Valid Email";
           return $submit;
    }else{
           //email format valid
        //Checks if the email is available or not
        $query = "SELECT email FROM users WHERE email = '$email'";

        $result = mysqli_query($connection, $query);

        //Prints the result
        if (mysqli_num_rows($result)<1) {
            echo "<span class='green'>Available!</span>";
            $submit = " <input type=\"submit\" name=\"submit\" value=\"Continue\" />";
            return $submit;
        }
        else{
            echo "<span class='red'><strong>Email '".$email."' Already In Use!<strong></span>";
            $submit = "Please Enter Valid Email";
           return $submit;
        }

       }

}//end validate email


if(isset($_GET['forgotemail'])){
    
        //Gets email value from the URL
        $email = $_GET['forgotemail'];

        //Checks if the email is available or not
        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $query);

        //Prints the result
        if (mysqli_num_rows($result)<1) { 
            echo "<span class='red'><strong>Email '".$email."' Is Not Connected An Account!<strong></span>";
        } else{
            echo "<span class='green'>There you are!</span>";
        }
}//end validate email

?> 