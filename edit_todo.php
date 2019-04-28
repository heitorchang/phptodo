<?php

require("header.php");

$sql = "SELECT name, due_datetime FROM todo WHERE id=:id";
$stmt = $dbh->prepare($sql);
$stmt->execute([":id" => $_GET['todo_id']]);

$row = $stmt->fetch();

$todo_date = date("Y-m-d", strtotime($row['due_datetime']));
$todo_time = date("H:i:00", strtotime($row['due_datetime']));

?>

<h3>Edit Todo</h3>

<form action="exec_edit_todo.php" method="POST">
<input name="todo_id" type="hidden" value="<?= $_GET['todo_id'] ?>">
<input name="todolist_id" type="hidden" value="<?= $_GET['id'] ?>">

Name: <input name="name" size="70" value="<?= $row['name'] ?>" autofocus><br>
Date: <input name="date" type="date" value="<?= $todo_date ?>"><br>
Time: <input name="time" type="time" value="<?= $todo_time ?>"><br>
<br>
<input type="submit">
</form>
