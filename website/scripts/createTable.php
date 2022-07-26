<?php
$tableUser = "CREATE TABLE IF NOT EXISTS user
	(
		`user_id`	INT AUTO_INCREMENT PRIMARY KEY,
        `email`		VARCHAR(255) NOT NULL UNIQUE,
        `username`	VARCHAR(255) NOT NULL UNIQUE,
		`password`	VARCHAR(255) NOT NULL,
        `token`		VARCHAR(255) NOT NULL,
		`activate`	boolean DEFAULT false
	);";

require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$conn->exec($tableUser);
