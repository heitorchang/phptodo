<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHPTodo</title>
	<link rel="stylesheet" href="style.css">
  </head>

  <body>	
	<?php
	   require("db.php");
	   date_default_timezone_set('America/Sao_Paulo');
	   ?>

       <?= date("d/M/y H:i", time()) ?> &bullet;

	<?php
	   
$sql = "SELECT id, name FROM todolist ORDER BY name";

$stmt = $dbh->prepare($sql);
$stmt->execute();

foreach ($stmt as $row) {
echo "<a href='read_list.php?id=" . $row['id'] . "'>" . $row['name'] . "</a> &bullet; ";
}

	   ?>

	<a href="weekday.php">weekday</a> &bullet; 
	<a href="dayofmonth.php">dayofmonth</a> &bullet;
	<a href="new_list.php">new list</a> &bullet; 
	<a href="trash.php">trash</a>

<br>
