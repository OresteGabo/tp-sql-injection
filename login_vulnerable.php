<?php
require_once 'init.php';

// On récupère les saisies
$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

// LA FAILLE : Concaténation directe.
// ASTUCE : Pour que l'injection ' -- passe même si l'utilisateur oublie l'espace,
// on peut concaténer un espace à la fin de la variable login en PHP.
$sql = "SELECT users.login, accounts.type, accounts.amount 
        FROM accounts 
        INNER JOIN users ON accounts.owner_id = users.id 
        WHERE users.login = '$login' AND users.pass = '$password'";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/style.css">
    <title>Résultat Injection</title>
</head>
<body>

<div class="section vulnerable">
    <h2>Analyse de la requête exécutée</h2>
    <div class="hint-box" style="background: #2d3436; color: #fab1a0; font-family: monospace; padding: 15px;">
        <span style="color: #636e72;">-- Requête envoyée au serveur :</span><br>
        <?php echo nl2br(htmlspecialchars($sql)); ?>
    </div>

    <?php
    try {
        // Exécution de la requête vulnérable
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            echo "<h3 style='color:red;'>✅ Injection Réussie !</h3>";
            echo "<p>Le moteur SQL a interprété la requête et retourné les données suivantes :</p>";

            echo "<table>";
            echo "<thead><tr><th>Propriétaire</th><th>Type de Compte</th><th>Solde (€)</th></tr></thead>";
            echo "<tbody>";
            foreach ($rows as $row) {
                echo "<tr>
                        <td><strong>" . htmlspecialchars($row['login']) . "</strong></td>
                        <td>" . htmlspecialchars($row['type']) . "</td>
                        <td>" . number_format($row['amount'], 2, ',', ' ') . " €</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<h3 style='color:orange;'>❌ Aucun résultat</h3>";
            echo "<p>Identifiants incorrects ou injection syntaxiquement correcte mais sans correspondance.</p>";
        }
    } catch (PDOException $e) {
        echo "<div style='background: #ffeaa7; border: 2px solid #fdcb6e; padding: 15px; margin-top: 20px; border-radius: 8px;'>";
        echo "<h3 style='color: #d63031; margin-top: 0;'>⚠️ Erreur de Syntaxe SQL</h3>";
        echo "<p>L'injection a échoué car MySQL n'a pas pu lire la requête :</p>";
        echo "<code>" . htmlspecialchars($e->getMessage()) . "</code>";
        echo "<p style='font-size: 0.9em; margin-top: 10px;'>💡 <strong>Conseil :</strong> Si vous utilisez <code>--</code>, n'oubliez pas d'ajouter un <strong>espace</strong> après. Sinon, utilisez <code>#</code> pour commenter la fin de la ligne.</p>";
        echo "</div>";
    }
    ?>

    <br>
    <a href="index.php" class="btn-init" style="text-decoration:none;">⬅️ Retour au formulaire</a>
</div>

</body>
</html>