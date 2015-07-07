<?php include("top.html");
include("common.php");

$db = connectDB();
try {
	$fn = $_GET["firstname"];
	$ln = $_GET["lastname"];
	
	$lastName = $db->quote($ln . '%');
	$firstName = $db->quote($fn . '%');	
	


	$rows = $db->query("SELECT m.name, m.year 
						FROM movies m 
							INNER JOIN roles r1 ON m.id = r1.movie_id
							INNER JOIN actors a1 ON r1.actor_id = a1.id
							INNER JOIN roles r2 ON m.id = r2.movie_id
							INNER JOIN actors a2 ON r2.actor_id = a2.id
							WHERE a1.first_name = $firstName AND a1.last_name =$lastName 
							AND a2.first_name = 'Kevin' AND a2.last_name ='Bacon'
							ORDER BY m.year DESC, m.name ASC;");
	$rCount = $rows->rowCount();
	if($rCount != NULL) {
?>
	<h1>Common movies for <?php echo $fn." ".$ln; ?> and Kevin Becon</h1>
		<table>
			<tr>
				<th>#</th>
				<th>Title</th>
				<th>Year</th>
			</tr>
		<?php
		$count = 1;
		foreach($rows as $row) { ?>
			<tr>
				<td><?php echo $count; $count++;  ?></td>
				<td><?= $row["name"]; ?></td>
				<td><?= $row["year"]; ?></td>	
			</tr>
	<?php } ?>
		</table>
		<?php
	}
	else {
		echo "There are no common movies in ".$fn." ".$ln." and Kevin Becon.";
		}
}
	
catch (PDOException $e) {
  	?>
  	<p>Sorry, a database error occurred. Please try again later.</p>
  	<p>(Error details: <?= $e->getMessage() ?>)</p>
  	<?php
}

?>
<?php include("bottom.html"); ?>
