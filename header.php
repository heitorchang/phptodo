<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
    <title>PHPTodo</title>
  </head>

  <body>	
	<?php
	   require("db.php");
	   date_default_timezone_set('America/Sao_Paulo');
	   ?>

	[<?= date("Y-m-d H:i", time()) ?>]

	<a href="new_list.php">New List</a> | 
	<a href="weekday.php">Weekday Todos</a> | 
	<a href="dayofmonth.php">Day of Month Todos</a> | 

	<?php
	   
$sql = "SELECT id, name FROM todolist ORDER BY name";

$stmt = $dbh->prepare($sql);
$stmt->execute();

foreach ($stmt as $row) {
echo "<a href='read_list.php?id=" . $row['id'] . "'>" . $row['name'] . "</a> | ";
}

	   ?>

	<a href="trash.php">Trash</a>

	<hr>
