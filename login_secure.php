<?php
require_once 'init.php';

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

// Dans une requête préparée, on affiche la structure avec les marqueurs '?'
// C'est ce qui prouve la sécurité : les données ne sont JAMAIS mélangées au SQL.
$sql_structure = "SELECT id, login, pass FROM users WHERE login = ?";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/style.css">
    <title>Résultat Sécurisé</title>
</head>
<body>

<div class="section secure">
    <h2>Analyse de la requête sécurisée</h2>

    <div class="hint-box" style="background: #2d3436; color: #74b9ff; font-family: monospace; padding: 15px; border-radius: 8px;">
        <span style="color: #636e72;">-- Structure de la requête préparée (Protection active) :</span><br>
        <?php echo htmlspecialchars($sql_structure); ?>
        <br><br>
        <span style="color: #636e72;">-- Paramètre lié (Bound Parameter) :</span><br>
        [1] => "<?php echo htmlspecialchars($login); ?>"
    </div>



    <?php
    try {
        // 1. Recherche de l'utilisateur (Sécurisé)
        $stmt = $pdo->prepare($sql_structure);
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<h2>Résultat du test</h2>";

        // 2. Vérification du mot de passe haché
        if ($user && password_verify($password, $user['pass'])) {
            echo "<h3 style='color:green;'>✅ Accès Autorisé (Sécurisé) !</h3>";
            echo "<p>Bienvenue, <b>" . htmlspecialchars($user['login']) . "</b>. Voici vos soldes :</p>";

            // Récupération des comptes
            $stmtAcc = $pdo->prepare("SELECT type, amount FROM accounts WHERE owner_id = ?");
            $stmtAcc->execute([$user['id']]);
            $accounts = $stmtAcc->fetchAll(PDO::FETCH_ASSOC);

            if ($accounts) {
                echo "<table>";
                echo "<thead><tr><th>Type de Compte</th><th>Solde (€)</th></tr></thead>";
                echo "<tbody>";
                foreach ($accounts as $acc) {
                    echo "<tr>
                            <td>" . htmlspecialchars($acc['type']) . "</td>
                            <td>" . number_format($acc['amount'], 2, ',', ' ') . " €</td>
                          </tr>";
                }
                echo "</tbody></table>";
            }
        } else {
            echo "<h3 style='color:red;'>❌ Accès Refusé.</h3>";
            echo "<p>L'injection SQL a été traitée comme du texte brut et n'a pas pu modifier la structure de la base.</p>";
        }

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
    }
    ?>

    <br>
    <a href="index.php" class="btn-init" style="text-decoration:none;">⬅️ Retour</a>
</div>
</body>
</html>