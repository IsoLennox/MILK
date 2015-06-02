<?php ob_start();

function redirect_to($new_location) {
    header("Location: " . $new_location);
	  exit; }

function logged_in(){
    return isset($_SESSION['user_id']);
}


function attempt_login($email, $password) {
		$user = find_user_by_email($email);
		if ($user) {
			// found user, now check password
			//if (password_check($password, $user["hashed_password"])) {
            if (password_verify($password, $user["password"])){
				// password matches
				return $user;
			} else {
				// password does not match
				return false;
			}
		} else {
			// user not found
			return false;
		}
	}



function check_password($user_id, $password) {
		$user = find_user_by_id($user_id);
		if ($user) {
			// found user, now check password 
            
            //SHA1
//            if (password_verify($password, $user["password"])){
            
            
            //BLOWFISH
            $hashed_password=$user["password"];
            if (hash_equals($hashed_password, crypt($password, $hashed_password))) {
   
 
				// password matches
				return $user;
			} else {
				// password does not match
				return false;
			}
		} else {
			// user not found
			return false;
		}
	}


 
 

function confirm_logged_in(){
    if (!logged_in()){
        redirect_to("login.php");
    }
}	



function mysql_prep($string) {
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	
 

function find_user_by_id($user_id) {
    global $connection;

    $safe_user_id = mysqli_real_escape_string($connection, $user_id);

    $query  = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE id = {$safe_user_id} ";
    $query .= "LIMIT 1";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    if($user = mysqli_fetch_assoc($user_set)) {
        return $user;
    } else {
        return null;
    }
}

 

function find_user_by_email($email) {
    global $connection;

    $safe_email = mysqli_real_escape_string($connection, $email);

    $query  = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE email = '{$safe_email}' ";
    $query .= "LIMIT 1";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    if($user = mysqli_fetch_assoc($user_set)) {
        return $user;
    } else {
        return null;
    }
}


function get_room_name($id){
    global $connection;
    $room_query  = "SELECT * FROM rooms WHERE id={$id}"; 
    $roomresult = mysqli_query($connection, $room_query);
    confirm_query($roomresult);
    if($roomresult){ 
        $array=mysqli_fetch_assoc($roomresult);
        $name= $array['name'];
        return $name;
    }//end get rooms 
}

function get_category_name($id){
    global $connection;
    $cat_query  = "SELECT * FROM item_category WHERE id={$id}"; 
    $catresult = mysqli_query($connection, $cat_query);
    confirm_query($catresult);
    if($catresult){ 
        $array=mysqli_fetch_assoc($catresult);
        $name= $array['name'];
        return $name;
    }//end get categories 
}


function get_item_details($id){
    global $connection;
    $name_query  = "SELECT * FROM items WHERE id={$id}"; 
    $nameresult = mysqli_query($connection, $name_query);
    confirm_query($nameresult);
    if($nameresult){ 
        $array=mysqli_fetch_assoc($nameresult);
//        $name= $array['name'];
//        return $name;
        return $array;
    }//end get names
}
 
 
 
	
?>