<?php
$dbHost = 'db';
$dbName= 'blogdb';
$dbUser = 'root';
$dbPass = 'fortniteballs';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error = "Verbindung fehlgeschlagen: " . $e->getMessage();
    exit;
}
?>