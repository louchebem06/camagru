<?php
session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id']) || !isset($_POST['data'])) {
	$return = [
		"msg"=>"User not connected or data invalid",
	];
	echo json_encode($return);
	exit();
}

$filter = array();
$data = json_decode($_POST['data']);
foreach ($data as $d) {
	foreach ($d as $k => $v) {
		if ($k == "cadre") {
			$cadre = $_SERVER['DOCUMENT_ROOT'] . $v;
		}
		else if ($k == "picture") {
			$picture = $v;
		} else {
			array_push($filter, $d);
		}
		break ;
	}
}

function writeElement(Imagick $dest, string $src, Int $x, Int $y, Int $width, Int $height): void {
	$newImg = new Imagick();
	$newImg->readImage($src);
	$newImg->resizeImage( $width, $height, Imagick::FILTER_LANCZOS, 1);
	$dest->compositeImage($newImg, imagick::COMPOSITE_DEFAULT, $x, $y);
}

$image_parts = explode(";base64,", $picture);
$image_en_base64 = base64_decode($image_parts[1]);

$img = new Imagick();
$img->readimageblob($image_en_base64);

writeElement($img, $cadre, 0, 0, intval($img->getImageWidth()), intval($img->getImageHeight()));

foreach ($filter as $d) {
	$filter = $_SERVER['DOCUMENT_ROOT'] . $d->filter;
	$x = $d->x;
	$y = $d->y;
	$width = $d->width;
	$height = $d->height;
	writeElement($img, $filter, intval($x), intval($y), intval($width), intval($height));
}

$name = bin2hex(openssl_random_pseudo_bytes(16));

$dir = $_SERVER['DOCUMENT_ROOT'] . "/upload";
if (!file_exists($dir))
	mkdir($dir);

$img->writeImage($dir . '/' . $name . ".png");

require_once($_SERVER['DOCUMENT_ROOT'] . "/scripts/createTable.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/utilitys/connect.php");

$filenameWeb = "/upload/{$name}.png";

try {
	$data = [
		'user_id' => $_SESSION['id'],
		'file' => $filenameWeb
	];
	$sql = "INSERT INTO img (`user_id`, `file`) VALUES (:user_id, :file)";
	$stmt = $conn->prepare($sql);
	$exec = $stmt->execute($data);
	if ($exec)
		$id_picture = $conn->lastInsertId();
	$return = [
		"msg"=>"ok",
		"id_picture"=>$id_picture,
		"file"=>$filenameWeb
	];
		
	echo json_encode($return);
	exit();
} catch (Exception $e) {
	echo json_encode([
		"msg"=>"Error upload in BDD"
	]);
	exit();
}
