<?php

require("header.php");

$sql = "INSERT INTO todo (todolist_id, name, due_datetime)
VALUES (:todolist_id, :name, :due_datetime)";

$stmt = $dbh->prepare($sql);
$stmt->execute([":todolist_id" => $_POST['todolist_id'],
":name" => $_POST['name'],
":due_datetime" => $_POST['date'] . " " . $_POST['time']]);

header('Location: read_list.php?id=' . $_POST['todolist_id']);
?>

