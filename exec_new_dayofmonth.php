<?php

require("header.php");

$sql = "INSERT INTO dayofmonthtodo (todolist_id, dayofmonth, name)
VALUES (:todolist_id, :dayofmonth, :name)";

$stmt = $dbh->prepare($sql);
$stmt->execute([":todolist_id" => $_POST['todolist_id'],
":dayofmonth" => $_POST['dayofmonth'],
":name" => $_POST['name'],]);

header('Location: dayofmonth.php');
?>

