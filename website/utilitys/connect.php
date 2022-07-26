<?php
$usernameSQL = getenv("MYSQL_USER");
$passwordSQL = getenv("MYSQL_PASSWORD");
$bdd = getenv("MYSQL_DATABASE");

$conn = new PDO("mysql:host=mysql;dbname=$bdd", $usernameSQL, $passwordSQL);
