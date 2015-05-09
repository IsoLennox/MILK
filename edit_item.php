<?php include("inc/header.php"); ?>

<?php if(isset($_GET['id'])){
     $id= $_GET['id'];                        
    $name= get_item_name($id);
?>


<h1>Editing <?php echo $name; ?></h1> 
<a href="item_details.php?id=<?php echo $id; ?>"  onclick="return confirm('Leave the page? This will not save your item!')" >Cancel</a>
           <?php } ?>
 
     
        
      
        
<?php include("inc/footer.php"); ?>