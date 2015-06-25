<?php

// include statements for connection page and header file
	include 'connect.php';
	include 'header.php';

	echo '<h3>Sign up</h3><br />';

	if($_SERVER['REQUEST_METHOD'] != 'POST') {
	    echo '<form method="post" action="">
	    	<l> 
			<li>Username may only contain letters and numbers.</li>
			<li>Email is optional.</li>
			<br>
		 	</l>
	 	 	Username: <input type="text" name="user_name" /><br />
	 		Password: <input type="password" name="user_pass"><br />
			Confirm Password: <input type="password" name="user_pass_check"><br />
			E-mail: <input type="email" name="user_email"><br />
	 		<input type="submit" value="Sign Up" />
	 	 </form>';
	}
	else {
		$errors = array();
		
		// statements to check that all the information entered is valid, and if it is not warn the user
		if(isset($_POST['user_name'])) {
			if(!ctype_alnum($_POST['user_name'])) {
				$errors[] = 'The username can only contain letters and numbers.';
			}
			if(strlen($_POST['user_name']) > 30) {
				$errors[] = 'The username has to be under thirty characters.';
			}
		}
		else {
			$errors[] = 'The username field cannot be left empty.';
		}
		
		
		if(isset($_POST['user_pass'])) {
			if($_POST['user_pass'] != $_POST['user_pass_check']) {
				$errors[] = 'The passwords you entered did not match.';
			}
		}
		
		if(isset($_POST['user_pass']) == 0) {
			$errors[] = 'You have to enter a password.';
		}
		
		if(!empty($errors)) {
			echo 'Some of the fields are not filled in correctly.<br /><br />';
			echo '<ul>';
			foreach($errors as $key => $value) {
				echo '<li>' . $value . '</li>';
			}
			echo '</ul>';
		}
		else {

			// insert statement to put information in that the user has entered
			$sql = "INSERT INTO
						users(user_name, user_pass, user_email ,user_date, user_level)
					VALUES('" . mysql_real_escape_string($_POST['user_name']) . "',
						   '" . sha1($_POST['user_pass']) . "',
						   '" . mysql_real_escape_string($_POST['user_email']) . "',
							NOW(),
							0)";
							
			$result = mysql_query($sql);
			// check to see if a username has already been used because they have to be unique
			if(!$result) {
				echo 'That Username is already in use, please try again with a different one.';
			}
			else {
				echo 'Thanks for registering with us. You can now <a href="signin.php">sign in.</a>';
			}
		}
	}
	include 'footer.php'; // include statement for the footer
?>
