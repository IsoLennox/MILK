<?php include("inc/header.php");   
    
    if(isset($_GET['theme'])){
 
                if($_SESSION['theme']==1){
                       //change to 0
        $_SESSION["theme"] = 0; 
                    
    $update_theme  = "UPDATE users SET theme = 0 ";
    $update_theme .= "WHERE id = {$_SESSION['user_id']} ";
    $result = mysqli_query($connection, $update_theme);

    if ($result && mysqli_affected_rows($connection) == 1) {
    // Success 
        $_SESSION["message"] = "Theme Changed!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);

    } else {
    // Failure
    $_SESSION["message"] = "Could not change theme";
    header('Location: ' . $_SERVER['HTTP_REFERER']);

    }//END UPDATE profile
             }else{
                        //change to 1 
   $_SESSION["theme"] = 1; 
                    
    $update_theme  = "UPDATE users SET theme = 1 ";
    $update_theme .= "WHERE id = {$_SESSION['user_id']} ";
    $result = mysqli_query($connection, $update_theme);

    if ($result && mysqli_affected_rows($connection) == 1) {
    // Success 
         $_SESSION["message"] = "Theme Changed!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);

    } else {
    // Failure
    $_SESSION["message"] = "Could not change theme";
    header('Location: ' . $_SERVER['HTTP_REFERER']);

    }//END UPDATE profile
                    
                        }
                     
        }


 if(isset($_GET['company_details'])){
    echo "<h1>Change Company Details</h1>";
 }

 if(isset($_GET['role'])){
    echo "<h1>Edit Role ".$_GET['role']." </h1>";
 }

 if(isset($_GET['room'])){
    echo "<h1>Edit Room ".$_GET['room']." </h1>";
 }
    
 
 include("inc/footer.php"); ?> 