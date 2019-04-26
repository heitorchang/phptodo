<?php

require("header.php");

?>

<h3>Trash (newest 100)</h3>

<?php

$trash_sql = "SELECT name, date_trashed FROM todo_trash ORDER BY date_trashed DESC LIMIT 100";

$stmt = $dbh->query($trash_sql);
$items = $stmt->fetchAll();

foreach ($items as $item) {
?>

<?= $item['name'] ?> <?= $item['date_trashed'] ?><br>

<?php
}
?>
