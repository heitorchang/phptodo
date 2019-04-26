<?php

require("header.php");

$sql = "INSERT INTO todolist (name)
VALUES (:name)";

$stmt = $dbh->prepare($sql);
$stmt->execute([":name" => $_POST['name']]);

header('Location: list.php');
?>

