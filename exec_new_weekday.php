<?php

require("header.php");

$sql = "INSERT INTO weekdaytodo (todolist_id, weekday, name)
VALUES (:todolist_id, :weekday, :name)";

$stmt = $dbh->prepare($sql);
$stmt->execute([":todolist_id" => $_POST['todolist_id'],
":weekday" => $_POST['weekday'],
":name" => $_POST['name'],]);

header('Location: weekday.php');
?>

