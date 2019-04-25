<?php

   require("db.php");

   // determine if todo table exists. If not, create all tables
   $stmt = $dbh->prepare("SHOW TABLES LIKE 'todo'");

$stmt->execute();
if ($stmt->rowCount() === 0) {

// create tables

$dbh->exec("CREATE TABLE IF NOT EXISTS todolist
(id int not null auto_increment,
name varchar(80) not null,
constraint pk_todolist primary key (id)) engine=InnoDB");
echo "Table todolist created";

$dbh->exec("CREATE TABLE IF NOT EXISTS todo
(id int not null auto_increment,
name varchar(80) not null,
todolist_id int not null,
due_datetime datetime not null,
constraint pk_todo primary key (id),
constraint fk_todo_todolist foreign key (todolist_id)
references todolist (id)) engine=InnoDB");
echo "Table todo created";

$dbh->exec("CREATE TABLE IF NOT EXISTS weekdaytodo
(id int not null auto_increment,
weekday int not null,
name varchar(80) not null,
constraint pk_weekdaytodo primary key (id)) engine=InnoDB");
echo "Table weekdaytodo created";

$dbh->exec("CREATE TABLE IF NOT EXISTS dayofmonthtodo
(id int not null auto_increment,
dayofmonth int not null,
name varchar(80) not null,
constraint pk_dayofmonthtodo primary key (id)) engine=InnoDB");
echo "Table dayofmonthtodo created";

$dbh->exec("CREATE TABLE IF NOT EXISTS autoweekdaylog
(id int not null auto_increment,
log_date date not null,
todo_id int not null,
constraint pk_autoweekdaylog primary key (id),
constraint fk_autoweekday_weekdaytodo foreign key (todo_id)
references weekdaytodo (id)) engine=InnoDB");
echo "Table autoweekdaylog created";

$dbh->exec("CREATE TABLE IF NOT EXISTS autodayofmonthlog
(id int not null auto_increment,
log_date date not null,
todo_id int not null,
constraint pk_autodayofmonthlog primary key (id),
constraint fk_autodayofmonth_dayofmonthtodo foreign key (todo_id)
references dayofmonthtodo (id)) engine=InnoDB");
echo "Table autodayofmonthlog created";

} else {
echo "Tables already exist.";
}
