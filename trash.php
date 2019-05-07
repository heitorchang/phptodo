<?php

require("header.php");

?>

<h3>Trash (newest 100)</h3>

<ul>

<?php

$trash_sql = "SELECT id, name, date_trashed FROM todo_trash ORDER BY date_trashed DESC LIMIT 100";

$stmt = $dbh->query($trash_sql);
$items = $stmt->fetchAll();

foreach ($items as $item) {
?>

<li><?= $item['date_trashed'] ?> (<?= $item['id'] ?>) <?= $item['name'] ?></li>

<?php
}
?>

</ul>