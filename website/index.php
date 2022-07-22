<?php
try {
    $dbh = new PDO('mysql:host=mysql;dbname=Site', "root", "abcdePassword");
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>