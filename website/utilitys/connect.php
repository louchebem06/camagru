<?php
$username = getenv("MYSQL_USER");
$password = getenv("MYSQL_PASSWORD");
$bdd = getenv("MYSQL_DATABASE");

$conn = new PDO("mysql:host=mysql;dbname=$bdd", $username, $password);
