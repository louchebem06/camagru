<?php
$tableUser = "CREATE TABLE IF NOT EXISTS user
	(
		`user_id`	INT AUTO_INCREMENT PRIMARY KEY,
        `email`		VARCHAR(255) NOT NULL UNIQUE,
        `username`	VARCHAR(255) NOT NULL UNIQUE,
		`password`	VARCHAR(255) NOT NULL,
        `token`		VARCHAR(255) NOT NULL,
		`img_id`	INT	NULL UNIQUE,
		`activate`	boolean DEFAULT false
	);";

$tableImg = "CREATE TABLE IF NOT EXISTS img
	(
		`img_id`	INT AUTO_INCREMENT PRIMARY KEY,
		`user_id`	INT NOT NULL,
		`file`		VARCHAR(255) NOT NULL UNIQUE
	);";

$tableComment = "CREATE TABLE IF NOT EXISTS comment
	(
		`comment_id`	INT AUTO_INCREMENT PRIMARY KEY,
		`img_id`		INT NOT NULL,
		`user_id`		INT NOT NULL,
		`comment`		VARCHAR(255) NOT NULL
	);";

require($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$conn->exec($tableUser);
$conn->exec($tableImg);
$conn->exec($tableComment);
