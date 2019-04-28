<!DOCTYPE html>
<html lang="en">
  <head>
	 <meta charset="utf-8">
     <title>PHPTodo</title>
     <style>
     a {
     text-decoration: none;
     font-weight: bold;
     }
     
     td {
     padding-right: 7px;
     padding-bottom: 18px;
     }

.overdue {
    font-weight: bold;
     color: #a11;
 }
.today {
    font-weight: bold;
    font-style: italic;
     color: #162;
 }
.tomorrow {
    font-style: italic;
     color: #138;
 }
     </style>
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
