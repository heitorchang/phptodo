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

       <?= date("d/M/y H:i", time()) ?>

	<?php

$count_sql = "SELECT count(todolist_id) as ct, todolist_id FROM todo WHERE 1 GROUP BY todolist_id";

$stmt = $dbh->prepare($count_sql);
$stmt->execute();

$count_array = array();
        
        foreach ($stmt as $row) {
        $count_array[$row['todolist_id']] = $row['ct'];
        }
        
$sql = "SELECT id, name FROM todolist ORDER BY name";

$stmt = $dbh->prepare($sql);
$stmt->execute();

        foreach ($stmt as $row) {
        if (array_key_exists($row['id'], $count_array)) {
        $ct = $count_array[$row['id']];
        } else {
        $ct = 0;
        }
        
echo " &bullet; <a href='read_list.php?id=" . $row['id'] . "'>" . $row['name'] . " (" . $ct . ")</a> ";
}

	?>
	<br><br>

	<a href="weekday.php">weekday</a> &bullet; 
	<a href="dayofmonth.php">dayofmonth</a> &bullet;
	<a href="new_list.php">new list</a> &bullet; 
	<a href="trash.php">trash</a>

<br>
