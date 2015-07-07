<?php

function connectLocalDB() {

    ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);
    
    /*
    $db = new PDO("mysql:dbname=imdb_small;host=localhost","root","root");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); */
	
    $dbunix_socket = '/ubc/icics/mss/hkaur87/mysql/mysql.sock';
    $dbuser = 'hkaur87';
    $dbpass = 'a86987147';
    $dbname = 'hkaur87'; 
    try {
		$db = new PDO("mysql:localhost=host;dbname=$dbname", $dbuser, $dbpass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        header("HTTP/1.1 500 Server Error");
        die("HTTP/1.1 500 Server Error: Database Unavailable ({$e->getMessage()})");
    }
    return $db;
}

function connectDB() {

    ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);
	try {
   		$dbunixSocket = '/ubc/icics/mss/cics516/db/cur/mysql/mysql.sock';
   		$dbname = 'cics516';
 		$dbuser = 'cics516';
  		$dbpass = 'cics516password';
   		
    
   		$db = new PDO("mysql:unix_socket=$dbunixSocket;dbname=$dbname", $dbuser, $dbpass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        header("HTTP/1.1 500 Server Error");
        die("HTTP/1.1 500 Server Error: Database Unavailable ({$e->getMessage()})");
    }
    return $db;
}

function inputValues($mName, $mYear, $actFirstName, $actLastName, $dirFirstName, $dirLastName, $db) {

    if ($mName == null || $mYear == null) {
        print "Please complete mandotory fields: movie name, year and genre.";
        return FALSE;
    } else {

# use inputs actFirstName or actLastName or both
        if ($actFirstName != "" || $actLastName != "") {
            $actorID = fetchActorsID($actFirstName, $actLastName, $db);
#actor isn't in database
            if ($actorID == -1) {
                exit(0);
            }
        }

        // use inputs dirFirstName or dirFirstName or both
        if ($dirFirstName != "" || $dirLastName != "") {
            $director_id = fetchDirectorsID($dirFirstName, $dirLastName, $db);
            // director not in the db
            if ($director_id == -1) {
                exit(0);
            }
        }
        return TRUE;
    }  //end of movie inputs
}	

#######
function fetchActorsID($firstname, $lastname, $db) {

    $rows = $db->prepare("SELECT id, first_name FROM actors 
    						WHERE last_name='$lastname'
    						AND first_name LIKE '$firstname%' 
    						ORDER BY film_count DESC, id ASC;");
    try {
        $rows->execute();
    } catch (PDOException $e) {
        print ("Error details: <?= $e->getMessage()?>)");
    }
    $firstRow = $rows->fetch();
    if ($rows->rowCount() != 0) {
        $id = $firstRow["id"];
        return $id;
    } else {
        print "Actor " . $firstname . " " . $lastname . " not found.";
        return -1;
    }
}


function fetchNewMovieID($db) {
    $rows = $db->prepare("SELECT MAX(id) AS maxID FROM movies;");
    try {
        $rows->execute();
    } catch (PDOException $ex) {
        print ("Error details: <?= $ex->getMessage()?>)");
    }
    $firstRow = $rows->fetch();
    $id = $firstRow["maxID"] + 100;
    return $id;
}


function fetchDirectorsID($firstname, $lastname, $db) {

    $lastname = $db->quote($lastname);
    $firstname = $db->quote($firstname . '%');
   	$rows = $db->prepare("SELECT id FROM directors 
   							WHERE last_name=$lastname 
   							AND first_name LIKE $firstname;");
    try {
        $rows->execute();
    } catch (PDOException $e) {
        print ("Error details: <?= $e->getMessage()?>)");
    }
    $firstRow = $rows->fetch();
    $rowCount = $rows->rowCount();
    if ($rowCount == 1) {
        $id = $firstRow["id"];
        return $id;
    }
}


?>
