<?php
$tableUser = "CREATE TABLE IF NOT EXISTS user
	(
		`user_id`	INT AUTO_INCREMENT,
        `email`		LONGBLOB NOT NULL UNIQUE,
        `username`	LONGBLOB NOT NULL UNIQUE,
		`password`	LONGBLOB NOT NULL,
        `token`		LONGBLOB NOT NULL,
		`activate`	boolean DEFAULT false,
        PRIMARY KEY(user_id)
	);";

include($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$conn->exec($tableUser);
