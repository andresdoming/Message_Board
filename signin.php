<?php 

// include statements for connection page and header file
	include 'connect.php';
	include 'header.php';

	echo '<h3>Sign in</h3><br />';

// check to see if someone is already signed in
	if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
		echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
	}
	else {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			echo '<form method="post" action="">
				Username: <input type="text" name="user_name" /><br />
				Password:  <input type="password" name="user_pass"><br />
				<input type="submit" value="Sign In"/>
			 	</form>';
		}
		else {
			// statements to check that the user has filled in all of the mandatory fields
			$errors = array(); 
			
			if(!isset($_POST['user_name'])) {
				$errors[] = 'You have to enter a username.';
			}
			
			if(!isset($_POST['user_pass'])) {
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

				// select statement to get the user information 
				$sql = "SELECT 
							user_id,
							user_name,
							user_level
						FROM
							users
						WHERE
							user_name = '" . mysql_real_escape_string($_POST['user_name']) . "'
						AND
							user_pass = '" . sha1($_POST['user_pass']) . "'";
							
				$result = mysql_query($sql);

				if(!$result) {
					echo 'Something went wrong while signing in. Please try again.';
				}
				else {
					if(mysql_num_rows($result) == 0) {
						echo 'You have entered a wrong Username/Password. Please try <a href="signin.php">again</a>.';
					}
					else {
						// set the session to signed in 
						$_SESSION['signed_in'] = true;
						
						// set the user information to what the user entered in the appropriate fields
						while($row = mysql_fetch_assoc($result)) {
							$_SESSION['user_id'] 	= $row['user_id'];
							$_SESSION['user_name'] 	= $row['user_name'];
							$_SESSION['user_level'] = $row['user_level'];
						}
						
						echo 'Welcome, ' . $_SESSION['user_name'] . '. <br /><a href="index.php">Back to home page.</a>';
					}
				}
			}
		}
	}
	include 'footer.php'; // include statement for the footer
?>