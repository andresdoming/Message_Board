<?php

// include statements for connection page and header file
	include 'connect.php';
	include 'header.php';

	echo '<h2>Create a topic</h2>';
	// check to see if the user is signed in to create a topic
	if($_SESSION['signed_in'] == false) {
		echo 'Sorry, you have to be <a href="signin.php">signed in</a> to create a topic.';
	}
	else {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {	

			// select statement to retrieve category information 
			$sql = "SELECT
						cat_id,
						cat_name,
						cat_description
					FROM
						categories";
			
			$result = mysql_query($sql);
			
			if(!$result) {
				echo 'Error while selecting from database. Please try again later.';
			}
			else {
				if(mysql_num_rows($result) == 0) {

					// check to see if the user has the appropriate user level 
					if($_SESSION['user_level'] == 1) {
						echo 'You have not created categories yet.';
					}
					else {
						echo 'Before you can post a topic, you must wait for an admin to create some categories.';
					}
				}
				else {
			
					echo '<form method="post" action="">
						Subject: <input type="text" name="topic_subject" /><br />
						Category:'; 
					
					echo '<select name="topic_cat">';
						while($row = mysql_fetch_assoc($result))
						{
							echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
						}
					echo '</select><br />';	
						
					echo 'Message: <br /><textarea name="post_content" /></textarea><br /><br />
						<input type="submit" value="Create Topic" />
					 </form>';
				}
			}
		}
		else {
			$query  = "BEGIN WORK;";
			$result = mysql_query($query);
			
			if(!$result) {
				echo 'An error occured while creating your topic. Please try again later.';
			}
			else {

				// insert statement to create a topic within the cateogry that was selected
				$sql = "INSERT INTO 
							topics(topic_subject,
								   topic_date,
								   topic_cat,
								   topic_by)
					   VALUES('" . mysql_real_escape_string($_POST['topic_subject']) . "',
								   NOW(),
								   " . mysql_real_escape_string($_POST['topic_cat']) . ",
								   " . $_SESSION['user_id'] . "
								   )";
						 
				$result = mysql_query($sql);
				if(!$result) {
					echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysql_error();
					$sql = "ROLLBACK;";
					$result = mysql_query($sql);
				}
				else {
					$topicid = mysql_insert_id();
					
					// insert statement to create a post by the user in the selected topic
					$sql = "INSERT INTO
								posts(post_content,
									  post_date,
									  post_topic,
									  post_by)
							VALUES
								('" . mysql_real_escape_string($_POST['post_content']) . "',
									  NOW(),
									  " . $topicid . ",
									  " . $_SESSION['user_id'] . "
								)";
					$result = mysql_query($sql);
					
					if(!$result) {
						echo 'Something happened when inserting your post. Please try again.<br /><br />' . mysql_error();
						$sql = "ROLLBACK;";
						$result = mysql_query($sql);
					}
					else {
						$sql = "COMMIT;";
						$result = mysql_query($sql);
						
						echo 'Your <a href="topic.php?id='. $topicid . '">topic</a> has been created.';
					}
				}
			}
		}
	}
	include 'footer.php';
?>
