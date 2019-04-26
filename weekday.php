<?php

require("header.php");

$todolist_sql = "SELECT id, name FROM todolist ORDER BY name";

$stmt = $dbh->query($todolist_sql);
$todolists = $stmt->fetchAll();

?>

<h3>New Weekday Todo</h3>

<form action="exec_new_weekday.php" method="POST">
Name: <input name="name" autofocus><br>

Weekday: <select name="weekday">
<option value="0">Sun</option>
<option value="1">Mon</option>
<option value="2">Tue</option>
<option value="3">Wed</option>
<option value="4">Thu</option>
<option value="5">Fri</option>
<option value="6">Sat</option>
</select>
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

<h3>Existing Weekday Todos</h3>

(0 = Sun, 1 = Mon, 2 = Tue, 3 = Wed, 4 = Thu, 5 = Fri, 6 = Sat)
<br><br>
<?php

$sql = "SELECT w.weekday, w.name AS wname, t.name AS tname FROM weekdaytodo AS w
INNER JOIN todolist AS t ON w.todolist_id = t.id
ORDER BY weekday";

$stmt = $dbh->prepare($sql);
$stmt->execute();

foreach ($stmt as $row) {
echo $row['weekday'] . ' ' . $row['wname'] . ' ' . $row['tname'] . '<br><br>';
}

?>


