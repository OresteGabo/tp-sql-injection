<?php
// config.php
$host = '127.0.0.1';
$dbName = 'avirer';
$user = 'oreste';
$pass = 'Muhirehonore@1*';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $user, $pass);
    // Activation des erreurs pour debugger plus facilement
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}