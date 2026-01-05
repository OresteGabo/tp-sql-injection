<?php require_once 'init.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TP Sécurisation BDD</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<h1>TP : Cryptage de données et Failles SQL</h1>

<div class="section">
    <h2>1. Préparation et Indices</h2>
    <form method="post">
        <button type="submit" name="setup_db" class="btn-init">🔄 Réinitialiser la Base</button>
    </form>

    <?php if(isset($message)) echo "<p style='color: #28a745; font-weight: bold;'>$message</p>"; ?>

    <div class="hint-box">
        <strong>Utilisateurs valides :</strong><br>
        • Normal : <code>bob</code> / <code>1234</code><br>
        • Sécurisé : <code>alice_sec</code> / <code>securise123</code>
    </div>

    <div class="hint-box" style="background: #fff3cd; border: 1px solid #ffeeba;">
        <strong>Injections à tester :</strong><br>
        • Contourner le mot de passe : <code>bob' -- </code><br>
        • Toujours vrai (Accès total) : <code>' OR 1='1</code>
    </div>
</div>

<div class="section vulnerable">
    <h2>2. Test Version Vulnérable</h2>
    <form action="login_vulnerable.php" method="post">
        <div class="form-group">
            <label>Login</label>
            <input type="text" name="login" placeholder="Ex: bob">
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" id="pass_vuln">
            <div class="show-pass-container">
                <input type="checkbox" onclick="togglePass('pass_vuln')"> Afficher le texte
            </div>
        </div>
        <button type="submit" class="btn-vuln">Valider (Vulnérable)</button>
    </form>
</div>

<div class="section secure">
    <h2>3. Test Version Sécurisée</h2>
    <form action="login_secure.php" method="post">
        <div class="form-group">
            <label>Login</label>
            <input type="text" name="login" placeholder="Ex: alice_sec">
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" id="pass_sec">
            <div class="show-pass-container">
                <input type="checkbox" onclick="togglePass('pass_sec')"> Afficher le texte
            </div>
        </div>
        <button type="submit" class="btn-sec">Valider (Sécurisé)</button>
    </form>
</div>

<script src="script/script.js"></script>
</body>
</html>