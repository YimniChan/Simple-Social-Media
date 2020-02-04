<?php
session_start();
$page_title = 'Add Post';
include('includes/header.html');

function post($error){
	echo $error;
	echo '<br/><br/><div class="page-header"><h1>Add Post</h1></div>
	<form action="add.php" method="post">
	<p>Title: <input type="text" name="title" size =" 60" maxlength="255" > </p>
	<p>Body:</p> <textarea rows="10" cols="100" name="postbody" maxlength="5000"></textarea>
	<p><input type="submit" name="submit" value="Submit"></p>
	</form>';
	};

if(isset($_SESSION['user_id'])){
	$error="";
	if(isset($_POST['submit'])){	
		$title=htmlspecialchars($_POST['title']);
		$body=htmlspecialchars($_POST['postbody']);
		$user_id=$_SESSION['user_id'];
		if(!$title||!$body){
			$error="Cannot add blank post.";
			echo '<br/><br/><br/>';
			post($error);
		}
		else{
			require('includes/DBconnect.php');
			$query = "INSERT INTO posts (Title, Postbody, Userid_FK, date_time) VALUES(?,?,?,NOW() )";
			$stmt = $dbc -> prepare($query);
			$stmt->bind_param('sss',$title, $body, $user_id);
	 		$stmt->execute();
			$row=$stmt->affected_rows;
			if($row>0){
				echo "<br/><br/><br/>Add post successfully.";
				echo "<br/>Automatically back to home page.";
			}
			else {
				echo "Something went wrong.";}
			$dbc->close();
			header("refresh:2, url=index.php");
		}
	}
	post($error);
}
else{
	require("login_functions1.php");
	echo "<br/><br/><br/>Login before adding post.";
	echo "<br/>Automatically go to login page.";
	header("refresh:2, url=login1.php");
}

include('includes/footer.html');
?>