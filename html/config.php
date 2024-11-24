<?php //Diese Datei bitte überall importieren das es einheitlich ist
$dbHost = 'db';
$dbName= 'blogdb';
$dbUser = 'root';
$dbPass = 'fortniteballs'; //Hehe
//Versuchen wir das ganze mal
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error = "Verbindung fehlgeschlagen: " . $e->getMessage();
}
?>