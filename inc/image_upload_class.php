<?php

// EXAMPLE:

// check for upload and process if upload
// if($_SERVER['REQUEST_METHOD'] == "POST") {
	// 	// takes uploaded file and creates a new  imageUpload object 
	// 	$img = new ImageUpload($_FILES['file_upload']);
	
	// 	// $path = directory the optimized image will be stored to
	// 	$path = 'images/';
	// 	// $tpath = directory the thumbnail image will be stored to
	// 	$tpath = 'thumbs/';

	// 	// optimize image	
	// 	$img->optimizeImage($path[,quality]);

	// 	echo "<br>";

	// 	// create copy of image and resize for thumbnail
	// 	$img->makeThumb($tpath, 75);
	
	// display thimbnail to screen
	//echo '<p><img src="' . $img->thumb_path . '" alt=""></p>';
				
	// } // end if     (form POST check)


// $img= new ImageUpload($_FILES['your file_upload name']){
// $img->optiizeImage(path, );
// }

class ImageUpload {
	// create file upload properties
	// no properties created for name and type
	// they can be accessed via OBJ->file_upload['name'] or ['type'] if needed
	public $file_upload;
	public $tmp_file;
	public $upload_err;
	public $filename;

	// POST Values
	public $item_id;
	public $img_title;

	// image output properties
	public $image_dir;
	public $image_path;
	public $thumb_dir;
	public $thumb_path;
	public $img_type;

	public function __construct($upload){
		// runs when imgage objected is created
		// requires $_FILES to be supplied when object is created - i.e.(new ImageUpload($_FILES['file upload']))
		// validates file as an image based on exif image data
		// handles and reports errors from upload to user
		// assigns values to properties


		// TROUBLESHOOTING UPLOAD ARRAY
		// echo '<pre>';
		// print_r($upload);
		// echo '</pre>';

		// assign file upload info to properties			
		$this->file_upload = $upload;
		$this->upload_err = $upload['error'];
		$this->filename = $upload['name'];
		$this->tmp_file = $upload['tmp_name'];

		// build array for upload error reporting, based on built in error handling of file upload
		$upload_errors = array(
			UPLOAD_ERR_OK => 	"No Errors",
			UPLOAD_ERR_INI_SIZE => "File uploaded was  larger than allowed by server",
			UPLOAD_ERR_FORM_SIZE => "File uploaded was larger than allowed by form",
			UPLOAD_ERR_PARTIAL => "Partial file upload",
			UPLOAD_ERR_NO_FILE => "No file selected",
			UPLOAD_ERR_NO_TMP_DIR => "No temp directory found",
			UPLOAD_ERR_CANT_WRITE => "Can't write file to the server",
			UPLOAD_ERR_EXTENSION => "File upload of this type not allowed"
		);

		$this->item_id = $_POST['item_id'];
		$this->img_title = $_POST['title'];

		// makes sure a file was uploaded prior to checking exif_imagetype (which cannot be empty)		
		if(empty($this->tmp_file)) { 
			// if $tmp_file is empty, an error occured, print error to screen			
			if($this->upload_err != 0) {
				// $error = $_FILES['file_upload']['error'];
				$_SESSION['message'] .= $upload_errors[$this->upload_err] . " please try again.";
				header("Location: ".$_SERVER['HTTP_REFERER']);
			} // end if (errors)
		} else {
			// NOTE: exif_imagetype validates file as image, returns type of image
			$this->img_type = exif_imagetype($this->tmp_file);
			if(empty($this->img_type)) {
			$_SESSION['message'] .= "Please only JPG, PNG, GIF or PDF files!";
			header("Location: ".$_SERVER['HTTP_REFERER']);
			} // end if
		}// end if (empty check)	
	} // end __construct

	public function optimizeImage($path, $quality=40) {
		// Allows jpeg, gif, or png  image types as an upload from user 
		// Converts gif to png, compresseses png files to max compression(9) unless $quality < 9
		// Takes as arguements the 'save to' file path as $path (ex. images/) 
		// and an optional quality setting for jpeg optimization (1-100), as $quality.  default jpeg quality setting is 40. 100 is no compression

		// assign image_dir property a value
		$this->image_dir = $path;
		//  file uplaoded, no error occured during upload
		if(!empty($this->tmp_file)) {	
			if($this->img_type ==  IMAGETYPE_GIF || $this->img_type == IMAGETYPE_PNG || $this->img_type == IMAGETYPE_JPEG && !empty($this->tmp_file)) {	
			
				// process image based on file type (gif, png, jpeg), assign file extension to output path ($savePath)
				if ($this->img_type == IMAGETYPE_GIF) {
					$date = date_create();
					// set compression level to 9
					// quality is the same on PNG regardless of compression setting 
					// 1 is quick with larger file size, 9 is slowest but smallest file size
					if($quality > 9){
						$quality = 9;  // sets 9 as default compression for png handling
					} // end if (set $quality)
					// establish output file path by appending file extension
					$savePath = $path . "img_" . date_timestamp_get($date) . ".png";
					// create image resource
					$imgUpload = imagecreatefromgif($this->tmp_file);			
					// convert to png and compress, then save to specified file location 
					imagepng($imgUpload, $savePath, $quality);
					// clear tmp image from memory
					imagedestroy($imgUpload);
					

				} elseif ($this->img_type == IMAGETYPE_PNG) {
					$date = date_create();
					// set compression level to 9
					// quality is the same on PNG regardless of compression setting 
					// 1 is quick with larger file size, 9 is slowest but smallest file size
					if($quality > 9){
						$quality = 9; // sets 9 as default compression for png handling
					} // end if (set $quality)
					// establish output file path by appending file extension
					$savePath = $path . "img_" . date_timestamp_get($date) . ".png";
					// create image resource
					$imgUpload = imagecreatefrompng($this->tmp_file);			
					// compress file and save to specified file location
					imagepng($imgUpload, $savePath, $quality);
					// clear tmp image from memory
					imagedestroy($imgUpload);
					


				} elseif ($this->img_type == IMAGETYPE_JPEG) {
					$date = date_create();
					// establish output file path by appending file extension
					$savePath = $path . "img_" . date_timestamp_get($date) . ".jpg";				
					// create image resource
					$imgUpload = imagecreatefromjpeg($this->tmp_file);			
					// optimize using quality setting, 40 is default for $quality
					imagejpeg($imgUpload, $savePath, $quality);
					// clear tmp image from memory
					imagedestroy($imgUpload);
				} // end if      (image type check)

				// image upload sucessful, display size of image after compression
				// assing $savePath to $this->image_path (makeThumb requires this information)
				if($this->upload_err == 0) {
					$newSize = round(filesize($savePath) / 1024) . ' kbs';
					echo "Image successfully uploaded: " . $newSize;
					$this->image_path = $savePath;
				} // end if
			} // end if
		} // end if
	} // end of optimizeImage
	
	public function makeThumb($pathToThumbs, $thumbHeight ){

		// optimizeImage() method must be called first, requires values set by this method
		// requires path to save thumbnail to and height of thumbnail as arguements when called
		// makes copy of optimized image and resize copy to specified the height with width calulated on ratio of original
		// assigns values to thumb_dir and thumb_path properties


		$this->thumb_dir = $pathToThumbs;
		//check to make sure optimizeImage has been run
	  	if(!empty($this->image_path)) {
	  		// disect path to optimized image so parts can be used to check file type, load image, and buid thumbnail filename
		    $info = pathinfo($this->image_path);
		    $dir = $info['dirname'] . '/';
		    $fname = $info['basename'];
		    $tn_fname = "tn_" . $info['basename'];
		    // check if this is a JPEG image
		    if (strtolower($info['extension']) == 'jpg' ) {

		      // load image and get image width and height
		      $img = imagecreatefromjpeg( "{$dir}{$fname}" );
		      $width = imagesx($img);
		      $height = imagesy($img);

		      // calculate thumbnail size using height value passed in      
		      $new_height = $thumbHeight;
		      // calculate width using original ratio, round down to whole pixels
		      $new_width = floor($width * ($thumbHeight / $height));

		      // create a new temporary image
		      $tmp_img = imagecreatetruecolor($new_width, $new_height);

		      // copy and resize old image into new image
		      imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

		      // save thumbnail into a file
		      imagejpeg($tmp_img, "{$pathToThumbs}{$tn_fname}");
			  $this->thumb_path = "{$pathToThumbs}{$tn_fname}";

			// check if this is a PNG image
		    } elseif (strtolower($info['extension']) == 'png' ) {
		    	echo "Creating thumbnail for {$fname} <br>";

		      // load image and get image width and height
		      $img = imagecreatefrompng( "{$dir}{$fname}" );
		      $width = imagesx($img);
		      $height = imagesy($img);

		      // calculate thumbnail size using height value passed in	      
		      $new_height = $thumbHeight;
		      // calculate width using original ratio, round down to whole pixels
		      $new_width = floor($width * ($thumbHeight / $height));

		      // create a new temporary image
		      $tmp_img = imagecreatetruecolor($new_width, $new_height);

		      // copy and resize old image into new image
		      imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		      // save thumbnail into a file
		      imagepng($tmp_img, "{$pathToThumbs}{$tn_fname}");
		      $this->thumb_path = "{$pathToThumbs}{$tn_fname}";
		    }// end if
		} // end if
	} // end makeThumb
} // end ImageUpload

?>