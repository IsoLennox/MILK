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


 
function find_user_by_username($username) {
    global $connection;

    $safe_username = mysqli_real_escape_string($connection, $username);

    $query  = "SELECT * ";
    $query .= "FROM customers ";
    $query .= "WHERE username = '{$safe_username}' ";
    $query .= "LIMIT 1";
    $user_set = mysqli_query($connection, $query);
    confirm_query($user_set);
    if($user = mysqli_fetch_assoc($user_set)) {
        return $user;
    } else {
        return null;
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
    $query .= "FROM customers ";
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


function find_author_by_id($author_id) {
    global $connection;

    $safe_author_id = mysqli_real_escape_string($connection, $author_id);

    $query  = "SELECT * ";
    $query .= "FROM authors ";
    $query .= "WHERE id = {$safe_author_id} ";
    $query .= "LIMIT 1";
    $author_set = mysqli_query($connection, $query);
    confirm_query($author_set);
    if($author = mysqli_fetch_assoc($author_set)) {
        return $author;
    } else {
        return null;
    }
}

function find_genre_by_id($genre_id) {
    global $connection;

    $safe_genre_id = mysqli_real_escape_string($connection, $genre_id);

    $query  = "SELECT * ";
    $query .= "FROM genres ";
    $query .= "WHERE id = {$safe_genre_id} ";
    $query .= "LIMIT 1";
    $genre_set = mysqli_query($connection, $query);
    confirm_query($genre_set);
    if($genre = mysqli_fetch_assoc($genre_set)) {
        return $genre;
    } else {
        return null;
    }
}



function find_books_by_author($author_id) {
    global $connection;

    $safe_author_id = mysqli_real_escape_string($connection, $author_id);

    $query  = "SELECT * ";
    $query .= "FROM authors_books ";
    $query .= "WHERE author_id = {$safe_author_id} ";
    $author_set = mysqli_query($connection, $query);
    confirm_query($author_set);
    if($author = mysqli_fetch_assoc($author_set)) {
        return $author;
    } else {
        return null;
    }
}



function find_user_by_email($email) {
    global $connection;

    $safe_email = mysqli_real_escape_string($connection, $email);

    $query  = "SELECT * ";
    $query .= "FROM customers ";
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

 
 
	
?>