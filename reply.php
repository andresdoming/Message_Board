<?php

// include statements for connection page and header file
	include 'connect.php';
	include 'header.php';

	if($_SERVER['REQUEST_METHOD'] != 'POST') {
		echo 'You cannot access this directly.';
	}
	else {
		// check to see if the user is signed in
		if(!$_SESSION['signed_in']) {
			echo 'You must be <a href="/forum/signin.php">signed in</a> to post a reply.';
		}
		else {
			// insert statement to enter a users post into the topic that is selected
			$sql = "INSERT INTO 
						posts(post_content,
							  post_date,
							  post_topic,
							  post_by) 
					VALUES ('" . $_POST['reply-content'] . "',
							NOW(),
							" . mysql_real_escape_string($_GET['id']) . ",
							" . $_SESSION['user_id'] . ")";
							
			$result = mysql_query($sql);
							
			if(!$result) {
				echo 'Your reply could not be saved, try again.';
			}
			else {
				echo 'Your reply has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
			}
		}
	}
	include 'footer.php'; // include statement for footer 
?>