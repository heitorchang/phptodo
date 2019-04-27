<?php

require("header.php");

$name_sql = "SELECT name FROM todolist WHERE id = :id";

$stmt = $dbh->prepare($name_sql);
$stmt->execute(["id" => $_GET['id']]);

$name_row = $stmt->fetch();

echo '<h3>' . $name_row['name'] . '</h3>';

// try creating weekday todo

$weekday_sql = "SELECT id, weekday, name FROM weekdaytodo WHERE todolist_id = :id";

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
if (date("w", time()) == $weekday['weekday']) {
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

}

echo "<pre>";

// try creating day of month todo

$today_day = (int) date("d",  time());

$dayofmonth_sql = "SELECT id, dayofmonth, name FROM dayofmonthtodo WHERE todolist_id = :id AND dayofmonth <= :day_of_month";

$stmt = $dbh->prepare($dayofmonth_sql);
$stmt->execute([":id" => $_GET['id'],
                ":day_of_month" => $today_day]);

$dayofmonths = $stmt->fetchAll();

foreach ($dayofmonths as $dayofmonth) {

    echo "CHECKING {$dayofmonth['dayofmonth']}\n";

    $first_of_month = date("Y-m", time()) . "-01";
    
// check if id is in autodayofmonthlog
$autodayofmonth_sql = "SELECT count(id) AS count_id FROM autodayofmonthlog
WHERE log_date >= :log_date_start AND log_date <= :log_date_end AND todo_id = :todo_id";

$autodayofmonth_stmt = $dbh->prepare($autodayofmonth_sql);
$autodayofmonth_stmt->execute([":log_date_start" => $first_of_month,
                               ":log_date_end" => date("Y-m-d", time()),
                               ":todo_id" => $dayofmonth['id']]);

if ($autodayofmonth_stmt->fetch()['count_id'] === 0) {

// create autodayofmonthtodo
if ($dayofmonth['dayofmonth'] <= date('d', time())) {
        
$autodayofmonthinsert_sql = "INSERT INTO todo (todolist_id, name, due_datetime)
VALUES (:todolist_id, :name, :due_datetime)";

$stmt = $dbh->prepare($autodayofmonthinsert_sql);
$stmt->execute([":todolist_id" => $_GET['id'],
":name" => "[auto] " . $dayofmonth['name'],
":due_datetime" => date("Y-m-d", time()) . " " . date("H:00", time())]);

// save into log
$autodayofmonthlog_sql = "INSERT INTO autodayofmonthlog (log_date, todo_id)
VALUES (:log_date, :todo_id)";

$stmt = $dbh->prepare($autodayofmonthlog_sql);
$stmt->execute([":log_date" => date("Y-m-d", time()),
":todo_id" => $dayofmonth['id']]);

}

}

}

?>

</pre>

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
