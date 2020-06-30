<?php

require("db.php");
date_default_timezone_set('America/Sao_Paulo');

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
":due_datetime" => date("Y-m-d", time()) . " " . date("H:00", time() + 4500)]);

// save into log
$autoweekdaylog_sql = "INSERT INTO autoweekdaylog (log_date, todo_id)
VALUES (:log_date, :todo_id)";

$stmt = $dbh->prepare($autoweekdaylog_sql);
$stmt->execute([":log_date" => date("Y-m-d", time()),
":todo_id" => $weekday['id']]);

}

}

}

// try creating day of month todo

$today_day = (int) date("j",  time());

$dayofmonth_sql = "SELECT id, dayofmonth, name FROM dayofmonthtodo WHERE todolist_id = :id AND dayofmonth <= :day_of_month";

$stmt = $dbh->prepare($dayofmonth_sql);
$stmt->execute([":id" => $_GET['id'],
                ":day_of_month" => $today_day]);

$dayofmonths = $stmt->fetchAll();

foreach ($dayofmonths as $dayofmonth) {

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
":due_datetime" => date("Y-m-d", time()) . " " . date("H:00", time() + 4500)]);

// save into log
$autodayofmonthlog_sql = "INSERT INTO autodayofmonthlog (log_date, todo_id)
VALUES (:log_date, :todo_id)";

$stmt = $dbh->prepare($autodayofmonthlog_sql);
$stmt->execute([":log_date" => date("Y-m-d", time()),
":todo_id" => $dayofmonth['id']]);

}

}

}


// proceed with page creation

require("header.php");

$name_sql = "SELECT name FROM todolist WHERE id = :id";

$stmt = $dbh->prepare($name_sql);
$stmt->execute(["id" => $_GET['id']]);

$name_row = $stmt->fetch();

echo '<h3>' . $name_row['name'] . '</h3>';

?>

<a href="new_todo.php?id=<?= $_GET['id'] ?>">New todo</a>

<br><br>

    <table>
    
<?php

    $todo_sql = "SELECT id, name, due_datetime FROM todo WHERE todolist_id = :todolist_id ORDER BY due_datetime, id";

$stmt = $dbh->prepare($todo_sql);
$stmt->execute(["todolist_id" => $_GET['id']]);

$link_pat = '~(http[s]?:\/\/\S*)~';

foreach ($stmt as $row) {
    echo "<tr>";

    $now_date_created = date_create(date('Y-m-d', time()));
    $todo_date_created = date_create(date('Y-m-d', strtotime($row['due_datetime'])));

    if ($todo_date_created == $now_date_created) {
        $due_label = "<span class='today'>today</span>";
        if (date_create(date('Y-m-d H:i', strtotime($row['due_datetime']))) < date_create(date('Y-m-d H:i', time()))) {
            $due_label = "<span class='overdue'>overdue</span>";
        }
    } else if ($todo_date_created < $now_date_created) {
        $due_label = "<span class='overdue'>overdue</span>";
    } else {
        $days_due = (int) date_diff($now_date_created, $todo_date_created)->days;
        if ($days_due === 1) {
            $due_label = "<span class='tomorrow'>tomorrow</span>";
        } else {
            $due_label = "in $days_due days";
        }
    }
    
    echo "<td nowrap>" . $due_label . "<br><span class='dmh'>" . date("d M H:i", strtotime($row['due_datetime'])) . "</span><br>";

    echo "<a href='edit_todo.php?todo_id={$row['id']}&id={$_GET['id']}' id='edit_{$row['id']}'>edit</a>";

    echo "<a href='confirm_delete.php?todo_id={$row['id']}&todolist_id={$_GET['id']}' id='delete_{$row['id']}' style='display: none;'>delete</a>";

    echo "</td>";
    
    echo "<td nowrap><input type='checkbox' id='checkbox_{$row['id']}' onchange='togglelink({$row['id']});'> " . preg_replace($link_pat, "<a href='$1' target='_blank'>$1</a>", $row['name']) . "</td>";
    
    echo "</tr>";
}

?>

</table>
<br><br><br><br><br>
<script src="editdel.js"></script>
