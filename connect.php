<?php 
    // start the session 
    session_start();

    // server information for the connect statement 
    $server	    = 'oniddb.cws.oregonstate.edu';
    $username	= 'domingan-db';
    $password	= 'cZ1rS4P8pMis9oYL';
    $database	= 'domingan-db';

    // connect to server and check to make sure that the connection was successful
    if(!mysql_connect($server, $username, $password)) {
     	exit('Error: could not establish database connection');
    }

    if(!mysql_select_db($database)) {
     	exit('Error: could not select the database');
    }
?>