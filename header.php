<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
    <title>PHPTodo</title>
  </head>

  <body>
	<a href="new_list.php">New List</a> | 

	<?php
	   require("db.php");
	   date_default_timezone_set('America/Sao_Paulo');

$sql = "SELECT id, name FROM todolist ORDER BY name";

$stmt = $dbh->prepare($sql);
$stmt->execute();

foreach ($stmt as $row) {
echo "<a href='read_list.php?id=" . $row['id'] . "'>" . $row['name'] . "</a> | ";
}

	   ?>


	<hr>
