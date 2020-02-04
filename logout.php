<?php
session_start();
$page_title = 'Logged Out';
include('includes/header.html');

if (!isset($_SESSION['user_id'])){
	require('login_functions1.php');
	echo '<br/><br/><br/><br/>To logout, you have to logged in first.';
	echo '<br/>Automatically go to Login page.';
	header("refresh:2 url=login1.php");
}
else{
	$_SESSION=[];
	session_destroy(); // Destroy the session itself.
	setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.
	echo '<br/><br/><h1>Logged Out!</h1>
	You are successful logged out!';
}
include('includes/footer.html');
?>
