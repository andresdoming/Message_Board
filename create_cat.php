<?php

// include statements for connection page and header file
	include 'connect.php';
	include 'header.php';

	echo '<h2>Create a category</h2>';

	// check to see if someone is signed in and if they are at the moderator level or not
	if($_SESSION['signed_in'] == true && $_SESSION['user_level'] != 1 ) {
		echo 'Sorry, you do not have sufficient rights to access this page.';
	}
	else if($_SESSION['signed_in'] == false) {
		echo 'Sorry, you have to be <a href="signin.php">signed in</a> and be an admin to create a category.';
	}
	else {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			echo '<form method="post" action="">
				Category name: <input type="text" name="cat_name" /><br />
				Category description:<br /> <textarea name="cat_description" /></textarea><br /><br />
				<input type="submit" value="Add category" />
			 </form>';
		}
		else {
			// insert statement to create a category 
			$sql = "INSERT INTO categories(cat_name, cat_description)
			   VALUES('" . mysql_real_escape_string($_POST['cat_name']) . "',
					 '" . mysql_real_escape_string($_POST['cat_description']) . "')";
			$result = mysql_query($sql);
			
			if(!$result) {
				echo 'Error' . mysql_error();
			}
			else {
				echo 'New category succesfully added.';
			}
		}
	}

	include 'footer.php'; // include statement for the footer 
?>
