<?php

   require("db.php");

   // determine if todo table exists. If not, create all tables
   $stmt = $dbh->prepare("SHOW TABLES LIKE 'todo_trash'");

$stmt->execute();
if ($stmt->rowCount() === 0) {

// create tables

$dbh->exec("CREATE TABLE IF NOT EXISTS todo_trash
(id int not null auto_increment,
name varchar(300) not null,
date_trashed datetime not null,
constraint pk_todolist primary key (id)) engine=InnoDB");
echo "Table todo_trash created";

} else {
echo "Tables already exist.";
}
