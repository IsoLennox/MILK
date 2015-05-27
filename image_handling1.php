<?php include("inc/header.php"); 
	
	require_once 'inc/image_upload_class.php';
	// check for upload and process if upload
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		// takes uploaded file and creates a new  imageUpload object 
		$img = new ImageUpload($_FILES['image']);
	
		// $path = directory the optimized image will be stored to
		// $tpath = directory the thumbnail image will be stored to
		$path = 'images/';
		$tpath = 'thumbs/';
		// optimize image	
		$img->optimizeImage($path);
		echo "<br>";
		// create copy of image and resize for thumbnail
		$img->makeThumb($tpath, 75);
				
	} // end if     (form POST check)

	?>

	


	<?php
	// check for upload and display if upload
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		// check for successful upload of image
		if($img->upload_err === 0){
			// echo "Image: " . $img->image_path . '<br>';
			// echo "Thumbnail: " . $img->thumb_path;
			// echo '<p><img src="' . $img->thumb_path . '" alt=""></p>';
			// echo $img->item_id . "<br>";
			// echo $img->img_title . '<br>';

			$is_img=1;

			$insert = "INSERT INTO item_img (item_id, file_path, thumb_path, is_img, title ) VALUES ({$img->item_id}, '{$img->image_path}', '{$img->thumb_path}', 1, '{$img->img_title}')";

			// $insert = "INSERT INTO item_img (item_id, file_path, thumb_path, is_img, title ) VALUES (16, 'filepath', 'thumb_path', 1, 'hdfksjdhf')";


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
	} // end if
	?>
</body>
</html>