<?php

// include statements for connection page and header file
	include 'connect.php';
	include 'header.php';

// select statement to create the list of categories for the home page
	$sql = "SELECT
				categories.cat_id,
				categories.cat_name,
				categories.cat_description,
				COUNT(topics.topic_id) AS topics
			FROM
				categories
			LEFT JOIN
				topics
			ON
				topics.topic_id = categories.cat_id
			GROUP BY
				categories.cat_name, categories.cat_description, categories.cat_id";

	$result = mysql_query($sql);

	if(!$result) {
		echo 'Categories could not be retrieved.';
	}
	else {
		
		if(mysql_num_rows($result) == 0) {
			echo 'No categories have been created yet.';
		}
		else { // table to list out the available categories and topics to choose from
			echo '<table border="1">
				  <tr>
					<th>Categories</th>
					<th>Latest Topics</th>
				  </tr>';	
				
			while($row = mysql_fetch_assoc($result)) {				
				echo '<tr>';
					echo '<td class="leftpart">';
						echo '<h3><a href="category.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
					echo '</td>';
					echo '<td class="rightpart">';
						// select statement to create the list of latest topics within each category
						$topicsql = "SELECT
										topic_id,
										topic_subject,
										topic_date,
										topic_cat
									FROM
										topics
									WHERE
										topic_cat = " . $row['cat_id'] . "
									ORDER BY
										topic_date
									DESC
									LIMIT
										1";
									
						$topicsresult = mysql_query($topicsql);
					
						if(!$topicsresult) {
							echo 'Last topic could not be displayed.';
						}
						else {
							if(mysql_num_rows($topicsresult) == 0) {
								echo 'No Topics Yet.';
							}
							else {
								while($topicrow = mysql_fetch_assoc($topicsresult))
								echo '<a href="topic.php?id=' . $topicrow['topic_id'] . '">' . $topicrow['topic_subject'] . '</a> at ' . date('d-m-Y', strtotime($topicrow['topic_date']));
							}
						}
					echo '</td>';
				echo '</tr>';
			}
		}
	}
	include 'footer.php'; // include statement so the footer can be displayed 
?>
