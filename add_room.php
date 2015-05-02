<?php include("inc/header.php"); ?>


<h1>New Room</h1> 

           
 <form action="#">
    Name: <input type="text">
    <input type="submit" value="Save Room">
 </form>
     
        
     <a href="rooms.php" onclick="return confirm('Leave the page? This will not save your room!');">Cancel</a> 
        
<?php include("inc/footer.php"); ?>