<?php
session_start();// Set the session data:
$page_title = 'Login Page';
include('includes/header.html');

if(isset($_SESSION['user_id'])){
 echo "<br/><br/><br/>You've already logged in.";
echo "<br/>Automatically back to home page.";
header("refresh:2, url=index.php");
}

else{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['submit'])){

		require('login_functions1.php');
		require('includes/DBconnect.php');
	
		list($check,$data) = check_login1($dbc, ($_POST['email']),($_POST['pass']));
		if ($check){
			$_SESSION['user_id'] = $data['user_id'];
			$_SESSION['name'] = $data['name'];//level
			// Redirect:
			redirect_user1();
		} else { // Unsuccessful
			$errors = $data;
			echo '<br/><br/><br/><br/>Login falled. Please try again.';
		}
		mysqli_close($dbc); // Close the database connection.
		} // End of the main submit conditional.
	}
include('loginForm.php');
}

?>

