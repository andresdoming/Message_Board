<!DOCTYPE html>
<html>
<!-- Simple html page to create the buttons for the top of the message board -->
	<head>
	 	<meta charset="UTF-8">
	 	<meta name="description" content="A short description." />
	 	<meta name="keywords" content="put, keywords, here" />
	 	<title>Final Project Message Board</title>
		<link rel="stylesheet" href="style.css" type="text/css">
	</head>

	<body>

	<h1><img src="images/banner.png" alt="Banner"></h1>
		<!-- menu buttons that allow you to return home, create a category, or create a topic -->
		<div id="wrapper">
		<div id="menu">
			<a class="item" href="index.php"><img src="images/HomeButton.jpeg" alt="icon"></a> 
			<a class="item" href="create_topic.php"><img src="images/CreateTopicButton.jpeg" alt="icon"></a> 
			<a class="item" href="create_cat.php"><img src="images/CreateCategoryButton.jpeg" alt="icon"></a> 
			
			<!-- menu option that changes if the user is signed in or out. If they are signed it then it displays their user name, and if they are not it allows them to sign in -->
			<div id="userbar">
			<?php
			// check to see if the user is signed in and either diaply their username or a sign in button
			if($_SESSION['signed_in']) {
				echo 'Hello <b>' . htmlentities($_SESSION['user_name']) . '</b>. <a class="item" href="signout.php"><img src="images/SignOutButton.jpeg" alt="icon"></a>';
			}
			else{
				echo '<a class="item" href="signin.php"><img src="images/SignInButton.jpeg" alt="icon"></a> <a class="item" href="signup.php"><img src="images/CreateAccountButton.jpeg" alt="icon"></a>';
			}
			?>
			</div>
		</div>
			<div id="content">