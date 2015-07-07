<?php include("top.html");
include("common.php");

$db = connectDB();
try {
	$fn = $_GET["firstname"];
	$ln = $_GET["lastname"];
	
	$lastName = $db->quote($ln);
	$firstName = $db->quote($fn . '%');	
	
	$rows = $db->query("SELECT m.name, m.year FROM
						movies m
						INNER JOIN roles r ON r.movie_id = m.id
						INNER JOIN actors a ON a.id=r.actor_id
						WHERE first_name like $firstName AND last_name=$lastName
							AND film_count =(SELECT max(film_count) from actors
							WHERE first_name like $firstName AND last_name=$lastName)
								AND a.id =(SELECT min(id) from actors WHERE first_name like $firstName
								AND last_name=$lastName);");
?>
<h1>Results for <?php echo $fn." ".$ln; ?></h1>
	<table>
		<tr>
			<th>#</th>
			<th>Title</th>
			<th>Year</th>
		</tr>
	<?php
	$count = 1;
	foreach($rows as $row):?>
		<tr>
			<td><?php echo $count; $count++;  ?></td>
			<td><?= $row["name"]; ?></td>
			<td><?= $row["year"]; ?></td>	
		</tr>
	<?php endforeach; ?>
	</table>
	<?php
}
catch (PDOException $ex) {
  ?>
  <p>Sorry, a database error occurred. Please try again later.</p>
  <p>(Error details: <?= $ex->getMessage() ?>)</p>
  <?php
}

?>
<?php include("bottom.html"); ?>
