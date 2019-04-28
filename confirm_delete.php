<?php

require("header.php");

?>

<h3>Confirm delete</h3>

<?php

$sql = "SELECT name FROM todo WHERE id=:id";
$stmt = $dbh->prepare($sql);
$stmt->execute([":id" => $_GET['todo_id']]);

$name = $stmt->fetch()['name'];
?>

Really delete <b><?= $name ?></b>?

      <br><br>

      <a href="exec_delete_todo.php?todo_id=<?= $_GET['todo_id'] ?>&todolist_id=<?= $_GET['todolist_id'] ?>">Yes, delete</a>

      <br><br><br><br>

      <a href="javascript:window.history.back();">No, go back</a>
