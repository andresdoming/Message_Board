<?php

// include statements for connection page and header file
	include 'connect.php';
	include 'header.php';

// select statement to retrieve category information 
	$sql = "SELECT
				cat_id,
				cat_name,
				cat_description
			FROM
				categories
			WHERE
				cat_id = " . mysql_real_escape_string($_GET['id']);

	$result = mysql_query($sql);

	if(!$result) {
		echo 'The category could not be displayed, please try again later.' . mysql_error();
	}
	else {
		if(mysql_num_rows($result) == 0) {
			echo 'This category does not exist.';
		}
		else {
			while($row = mysql_fetch_assoc($result)) {
				echo '<h2>Topics in &prime;' . $row['cat_name'] . '&prime; category</h2><br />';
			}
			// select statement to retrieve topic information from the category chosen
			$sql = "SELECT	
						topic_id,
						topic_subject,
						topic_date,
						topic_cat
					FROM
						topics
					WHERE
						topic_cat = " . mysql_real_escape_string($_GET['id']);
			
			$result = mysql_query($sql);
			// check to see if the topics actually exist and if they were properly retrieved 
			if(!$result) {
				echo 'The topics could not be displayed, please try again later.';
			}
			else {
				if(mysql_num_rows($result) == 0) {
					echo 'There are no topics in this category yet. Would you like to <a href="create_topic.php">create one</a>?';
				}
				else {
					echo '<table border="1">
						  <tr>
							<th>Topics</th>
							<th>Date Created</th>
						  </tr>';	
					
					while($row = mysql_fetch_assoc($result)) {				
						echo '<tr>';
							echo '<td class="leftpart">';
								echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><br /><h3>';
							echo '</td>';
							echo '<td class="rightpart">';
								echo date('d-m-Y', strtotime($row['topic_date']));
							echo '</td>';
						echo '</tr>';
					}
				}
			}
		}
	}
	include 'footer.php'; // include statement for footer
?>
