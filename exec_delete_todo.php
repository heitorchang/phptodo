<?php

require("header.php");

$sql = "DELETE FROM todo WHERE id=:id";

$stmt = $dbh->prepare($sql);
$stmt->execute([":id" => $_GET['todo_id']]);

header('Location: read_list.php?id=' . $_GET['todolist_id']);
?>

