<?php

require("header.php");

$sql = "UPDATE todo SET name=:name, due_datetime=:due_datetime
WHERE id=:id";

$stmt = $dbh->prepare($sql);

$datetime = $_POST['date'] . " " . $_POST['time'];

$stmt->execute([":name" => $_POST['name'],
                ":due_datetime" => $datetime,
                ":id" => $_POST['todo_id']]);

header('Location: read_list.php?id=' . $_POST['todolist_id']);
?>

