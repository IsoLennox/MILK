<?php include("inc/header.php"); ?>

<?php
    if(isset($_POST['submit'])){
        echo "Added room!";
    }else{

?>

<h1>New Room</h1> 

           
 <form method="POST">
    Name: <input type="text">
    <input name="submit" type="submit" value="Save Room">
 </form>
     
        
     <a href="rooms.php" onclick="return confirm('Leave the page? This will not save your room!');">Cancel</a> 
        
<?php }//end add room
include("inc/footer.php"); ?>