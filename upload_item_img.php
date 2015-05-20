<?php include("inc/header.php"); ?>
<?php
 

        //GET CURRENT IMG AND DELETE IT So that img name doesnt exist if user should try to upload it again in future
        //No Gallery in this website, just one user image.
 
 $item_id=$_POST['item_id'];
 $title=$_POST['title'];
 
          //CHECK IMAGE
        $target_dir = "item_images/".$_SESSION["user_id"]."/";
        if (!file_exists($target_dir)) {

            //CREATE DIR and FILE 
            mkdir($target_dir, 0777, true);
            require_once("inc/upload_item_img.php"); 
        }else{

            //DIRECTORY EXISTS. UPLOAD IMAGE
            require_once("inc/upload_item_img.php"); 
        }//end check for directory

   
 
?>
 