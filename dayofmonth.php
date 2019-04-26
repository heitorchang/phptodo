<?php

require("header.php");

$todolist_sql = "SELECT id, name FROM todolist ORDER BY name";

$stmt = $dbh->query($todolist_sql);
$todolists = $stmt->fetchAll();

?>

<h3>New Day of Month Todo</h3>

<form action="exec_new_dayofmonth.php" method="POST">
Name: <input name="name" autofocus><br>
Day of Month: <input name="dayofmonth">
<br>

Todo List:
<select name="todolist_id">

<?php
foreach ($todolists as $todolist) {
?>
  <option value="<?= $todolist['id'] ?>"><?= $todolist['name'] ?></option>
<?php
}
?>

</select>
<br><br>
<input type="submit">
</form>

<h3>Existing Day of Month Todos</h3>

<?php

$sql = "SELECT d.dayofmonth, d.name AS dname, t.name AS tname FROM dayofmonthtodo AS d
INNER JOIN todolist AS t ON d.todolist_id = t.id
ORDER BY dayofmonth";

$stmt = $dbh->prepare($sql);
$stmt->execute();

foreach ($stmt as $row) {
echo $row['dayofmonth'] . ' ' . $row['dname'] . ' ' . $row['tname'] . '<br><br>';
}

?>


