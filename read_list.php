<?php

require("header.php");

$name_sql = "SELECT name FROM todolist WHERE id = :id";

$stmt = $dbh->prepare($name_sql);
$stmt->execute(["id" => $_GET['id']]);

$name_row = $stmt->fetch();

echo $name_row['name'];

// try creating weekday todo

$weekday_sql = "SELECT id, name FROM weekdaytodo WHERE todolist_id = :id";

$stmt = $dbh->prepare($weekday_sql);
$stmt->execute([":id" => $_GET['id']]);

$weekdays = $stmt->fetchAll();

foreach ($weekdays as $weekday) {

// check if id is in autoweekdaylog
$autoweekday_sql = "SELECT count(id) AS count_id FROM autoweekdaylog
WHERE log_date = :log_date AND todo_id = :todo_id";
$autoweekday_stmt = $dbh->prepare($autoweekday_sql);
$autoweekday_stmt->execute([":log_date" => date("Y-m-d", time()),
":todo_id" => $weekday['id']]);

if ($autoweekday_stmt->fetch()['count_id'] === 0) {

// create autoweekdaytodo
$autoweekdayinsert_sql = "INSERT INTO todo (todolist_id, name, due_datetime)
VALUES (:todolist_id, :name, :due_datetime)";

$stmt = $dbh->prepare($autoweekdayinsert_sql);
$stmt->execute([":todolist_id" => $_GET['id'],
":name" => "[auto] " . $weekday['name'],
":due_datetime" => date("Y-m-d", time()) . " " . date("H:00", time())]);

// save into log
$autoweekdaylog_sql = "INSERT INTO autoweekdaylog (log_date, todo_id)
VALUES (:log_date, :todo_id)";

$stmt = $dbh->prepare($autoweekdaylog_sql);
$stmt->execute([":log_date" => date("Y-m-d", time()),
":todo_id" => $weekday['id']]);

}

}


// try creating day of month todo

?>

<br><br>

<a href="new_todo.php?id=<?= $_GET['id'] ?>">New Todo</a>

<br><br>

<?php

$todo_sql = "SELECT id, name, due_datetime FROM todo WHERE todolist_id = :todolist_id ORDER BY due_datetime";

$stmt = $dbh->prepare($todo_sql);
$stmt->execute(["todolist_id" => $_GET['id']]);

foreach ($stmt as $row) {
echo $row['name'] . " " . $row['due_datetime'] . " <a href='exec_delete_todo.php?todo_id={$row['id']}&todolist_id={$_GET['id']}'>DELETE</a> <br><br>";
}

?>
