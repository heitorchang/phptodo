<?php

require("header.php");

$sql = "SELECT id, name FROM todolist ORDER BY name";

$stmt = $dbh->prepare($sql);
$stmt->execute();

foreach ($stmt as $row) {
echo "<a href='read_list.php?id=" . $row['id'] . "'>" . $row['name'] . "</a><br><br>";
}

?>

