<?php
// Paramètres de connexion
$host = '127.0.0.1';
$dbName = 'avirer';
$user = 'oreste';
$pass = 'Muhirehonore@1*';

try {
    // Connexion initiale au serveur MySQL
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // --- C'EST ICI QUE LE BOUTON EST CONNECTÉ ---
    if (isset($_POST['setup_db'])) {
        // 1. Recréer la base
        $pdo->exec("DROP DATABASE IF EXISTS $dbName");
        $pdo->exec("CREATE DATABASE $dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");
        $pdo->exec("USE $dbName");

        // 2. Créer la table des utilisateurs (Conception sécurisée)
        // Utilisation de utf8_bin pour la sensibilité à la casse (vu dans le PDF)
        $pdo->exec("CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            login VARCHAR(50) UNIQUE NOT NULL,
            pass VARCHAR(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin");

        // 3. Créer la table des comptes (Relationnelle)
        $pdo->exec("CREATE TABLE accounts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            owner_id INT NOT NULL,
            type VARCHAR(50),
            amount DECIMAL(10,2),
            FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB");

        // 4. Insertion de données "Normales" (Bob)
        $pdo->exec("INSERT INTO users (login, pass) VALUES ('bob', '1234')");
        $bobId = $pdo->lastInsertId();
        $pdo->exec("INSERT INTO accounts (owner_id, type, amount) VALUES 
            ($bobId, 'Compte Courant', 1250.50),
            ($bobId, 'Livret A', 4500.00)");

        // 5. Insertion de données "Sécurisées" (Alice avec mot de passe haché)
        $hashSec = password_hash('securise123', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO users (login, pass) VALUES ('alice_sec', '$hashSec')");
        $aliceId = $pdo->lastInsertId();
        $pdo->exec("INSERT INTO accounts (owner_id, type, amount) VALUES 
            ($aliceId, 'Livret Jeune', 300.00)");

        $message = "✅ La base de données 'avirer' a été réinitialisée avec succès !";
    } else {
        // Si on ne clique pas sur le bouton, on sélectionne juste la base pour les autres pages
        $pdo->exec("USE $dbName");
    }

} catch (PDOException $e) {
    // Si la base n'existe pas encore (premier lancement), on ignore l'erreur du USE
    $message = "Info : " . $e->getMessage();
}
?>