<?php include("inc/header.php"); ?>


<h1>New Item</h1> 

           
 <form action="#">
    Name: <input type="text">
    <input type="submit" value="Save Item">
 </form>
     
        
     <a href="inventory.php" onclick="return confirm('Leave the page? This will not save your item!');">Cancel</a> 
        
<?php include("inc/footer.php"); ?>