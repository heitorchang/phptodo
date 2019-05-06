<?php

require("header.php");

?>

<h3>New Todo</h3>

<form action="exec_new_todo.php" method="POST">
<input name="todolist_id" type="hidden" value="<?= $_GET['id'] ?>">

Name: <input name="name" size="70" autofocus><br>
Date: <input name="date" type="date" value="<?= date('Y-m-d', time() + 3600) ?>"><br>
Time: <input name="time" type="time" value="<?= date('H:i', time() + 3600) ?>"><br>
<br>
<input type="submit">
</form>
