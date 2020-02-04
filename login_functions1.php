<?php 
function redirect_user1($page = 'index.php') {
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	$url = rtrim($url, '/\\');
	$url .= '/' . $page;
	header("Location: $url");
	exit(); // Quit the script.
} // End of redirect_user() function.

function check_login1($dbc, $email = '', $pass = '') {
	$errors = []; // Initialize error array.

	// Validate the email address:
	if (empty($email)) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($email));
	}
	// Validate the password:
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($pass));
	}
	
	if (empty($errors)) { // If everything's OK.
	// Retrieve the user_id and first_name for that email/password combination:
	 $p = SHA1($p);
	 $query = "SELECT Userid, NickName FROM users WHERE EmailAddress=? AND password=?";//set to session
	 $stmt = $dbc -> prepare($query);
 	 $stmt->bind_param('ss',$e,$p);
 	 $stmt->execute();
 	 $stmt->store_result();
	 $stmt->bind_result($user_id, $name);
	if ($stmt->num_rows >0)
	{
		$stmt->fetch();
		$data['user_id'] =$user_id;
		$data['name']=$name;
		return [true,$data];
	}
	 else { // Not a match!
		$errors[] = 'The email address and password entered do not match those on file.';
		}
	}
	return [false,$errors];
} // End of check_login() function.