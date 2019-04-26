<?php

require("header.php");

?>

<h3>New Todo List</h3>

<form action="exec_new_list.php" method="POST">
  Name: <input name="name" autofocus>
  <br><br>
  <input type="submit">
</form>
