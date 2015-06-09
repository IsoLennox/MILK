<?php
	$fields = []; 
	if( isset($_POST) && isset($_FILES) ){

		print_r($_POST);
		var_dump($_FILES['image']);
		print_r($_FILES);
	} else {
		echo "failure";
	}



 ?>