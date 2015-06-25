<?php

// include statements for connection page and header file
    include 'connect.php';
    include 'header.php';

    echo '<h2>Sign Out</h2>';

    // if a user is signed in then sign them out
    if($_SESSION['signed_in'] == true) {
    	$_SESSION['signed_in'] = NULL;
    	$_SESSION['user_name'] = NULL;
    	$_SESSION['user_id']   = NULL;

    	echo 'Succesfully signed out, thank you for visiting.';
    }
    else {
    	echo 'You are not signed in. Would you like to <a href="signin.php">sign in</a>?';
    }
    include 'footer.php';
?>