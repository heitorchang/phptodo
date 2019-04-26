<?php

require("header.php");

// add to trash first

$sql = "SELECT name FROM todo WHERE id=:id";
$stmt = $dbh->prepare($sql);
$stmt->execute([":id" => $_GET['todo_id']]);

$name_row = $stmt->fetch();
$todo_name = $name_row['name'];


$sql = "INSERT INTO todo_trash (name, date_trashed)
VALUES (:name, :date_trashed)";

$stmt = $dbh->prepare($sql);
$stmt->execute([":name" => $todo_name,
":date_trashed" => date("Y-m-d H:i:s", time())]);


$sql = "DELETE FROM todo WHERE id=:id";

$stmt = $dbh->prepare($sql);
$stmt->execute([":id" => $_GET['todo_id']]);

header('Location: read_list.php?id=' . $_GET['todolist_id']);
?>

