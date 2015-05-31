<?php include("inc/header.php"); 
	
	require_once 'inc/image_upload_class.php';
	// check for upload and process if upload
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		// takes uploaded file and creates a new  imageUpload object 
		if($_FILES['image']) {
	
			// $path = directory the optimized image will be stored to
			// $tpath = directory the thumbnail image will be stored to
			$path = 'images/';
			$tpath = 'thumbs/';

			$img = new ImageUpload($_FILES['image']);
			// optimize image	
			$img->optimizeImage($path);
			echo "<br>";
			// create copy of image and resize for thumbnail
			$img->makeThumb($tpath, 150);
		

	
	
			// check for successful upload of image
			if($img->upload_err === 0){
				

				$is_img=1;

				$insert = "INSERT INTO item_img (item_id, file_path, thumb_path, is_img, title ) VALUES ({$img->item_id}, '{$img->image_path}', '{$img->thumb_path}', 1, '{$img->img_title}')";

			    $insert_result = mysqli_query($connection, $insert);

			    if ($insert_result && mysqli_affected_rows($connection) == 1) {
			 
			      $_SESSION["message"] = "Image Uploaded!";
			      redirect_to("item_details.php?id={$img->item_id}");
			    } else {
			      // Failure
			      // $_SESSION["message"] = "Image uploaded. Filepath NOT written. item id: ".$img->item_id." file:".$img->image_path;
			    	$_SESSION["message"] = $insert;
			        redirect_to("item_details.php?id={$img->item_id}");
			    }//end fail or success redirect
			} // end if
		} else {
			$_SESSION['message'] .= "Please only JPG, PNG, GIF or PDF files!";
			header("Location: ".$_SERVER['HTTP_REFERER']);
		} // end if
	} // end if POST
	?>
</body>
</html>