<?php

require("header.php");

$name_sql = "SELECT name FROM todolist WHERE id = :id";

$stmt = $dbh->prepare($name_sql);
$stmt->execute(["id" => $_GET['id']]);

$name_row = $stmt->fetch();

echo $name_row['name'];

?>

<br><br>

<a href="new_todo.php?id=<?= $_GET['id'] ?>">New Todo</a>

<br><br>

<?php

$todo_sql = "SELECT id, name, due_datetime FROM todo WHERE todolist_id = :todolist_id ORDER BY due_datetime DESC";

$stmt = $dbh->prepare($todo_sql);
$stmt->execute(["todolist_id" => $_GET['id']]);

foreach ($stmt as $row) {
echo $row['name'] . " " . $row['due_datetime'] . " EDIT / DELETE <br><br>";
}

?>
