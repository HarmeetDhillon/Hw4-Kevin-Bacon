<?php
#Add_film.php adds a new film into imdb_small

include("top.html");
include("common.php");

//get database
$db = connectLocalDB();


if (isset($_REQUEST['addMovie'])) {

    #get inputs from the form
    $mName = htmlspecialchars($_REQUEST['mName']);
    $mYear = htmlspecialchars($_REQUEST['mYear']);
    $actFirstName = htmlspecialchars($_REQUEST['actFirstName']);
    $actLastName = htmlspecialchars($_REQUEST['actLastName']);
    $dirFirstName = htmlspecialchars($_REQUEST['dirFirstName']);
    $dirLastName = htmlspecialchars($_REQUEST['dirLastName']);
    $movieGenre = htmlspecialchars($_REQUEST['movie_Genre']);


#checking inputs   
    if (inputValues($mName, $mYear, $actFirstName, $actLastName, $dirFirstName, $dirLastName, $db)) {
        try {
            // get largest movie id number to prepare insertion
            $newMovieID = fetchNewMovieID($db);
	
            $stmt = $db->prepare("INSERT INTO movies (id, name, year) VALUES (:id, :mName, :mYear)");
            $stmt->bindParam(":id", $newMovieID);
            $stmt->bindParam(":mName", $mName);
            $stmt->bindParam(":mYear", $mYear);
            $stmt->execute();

			    # updating table movies_directors
            if ($dirFirstName != "" && $dirFirstName != "") {
                $director_id = fetchDirectorsID($dirFirstName, $dirLastName, $db);
                $stmt = $db->prepare("INSERT INTO movies_directors (director_id, movie_id) VALUES (:director_id, :movieID)");
                $stmt->bindParam(":director_id", $director_id);
                $stmt->bindParam(":movieID", $newMovieID);
                $stmt->execute();
			}
			
            # updating table role
            if ($actFirstName != "" && $actLastName != "") {
                // $actorID is not -1
                $actorID = fetchActorsID($actFirstName, $actLastName, $db);

                $stmt = $db->prepare("INSERT INTO roles (actor_id, movie_id) VALUES (:actorID, :movieID)");
                $stmt->bindParam(":actorID", $actorID);
                $stmt->bindParam(":movieID", $newMovieID);
                $stmt->execute();

                # updating actor role's film_count column
                $stmt = $db->prepare("UPDATE actors SET film_count=film_count +1 WHERE id = :actorID");
                $stmt->bindParam(":actorID", $actorID);
                $stmt->execute();
            }

        
            
            
        } catch (PDOException $e) {
            die("Error: {$e->getMessage()}");
        }
        print $mName . ", " . $mYear . " added successfully into imdb_small database.";
    }
}
?>
<?php include("bottom.html"); ?>
