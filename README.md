# 🛡️ Tests de failles par injections SQL 💻

**Cours :** Sécurisation des applications  
**Étudiant :** Oreste MUHIRWA GABO  
**Formation :** Master 2 Informatique et Mobilité — Université de Haute-Alsace (UHA)  
**Enseignant :** M. Karim HAMMOUDI

---

## 📝 Description du projet

Ce projet est une étude pratique réalisée dans le cadre du module **Sécurisation des applications**.  
Il vise à démontrer l’exploitation technique d’une vulnérabilité de type **SQL Injection (SQLi)** sur un système d’authentification bancaire simulé, puis à mettre en œuvre les **mécanismes de défense standards utilisés en industrie**.

L’objectif est double :
- Comprendre le fonctionnement interne des attaques par injection SQL.
- Implémenter des contre-mesures robustes et conformes aux bonnes pratiques de sécurité.

---

## 🚀 Fonctionnalités

- **Analyse de vulnérabilité**  
  Exploitation d’un formulaire d’authentification utilisant la concaténation directe de chaînes SQL.

- **Démonstration offensive**  
  Bypass de l’authentification et extraction massive de données via des tautologies (`OR 1=1`).

- **Remédiation technique**  
  Sécurisation des requêtes via des **requêtes préparées (Prepared Statements)** avec **PDO**.

- **Protection des secrets**  
  Hachage cryptographique des mots de passe à l’aide de **BCRYPT**.

- **Environnement réaliste**  
  Base de données relationnelle **MySQL (InnoDB)** avec gestion des clés primaires et étrangères.

---

## 🛠️ Stack technique

- **Backend :** PHP 8.x
- **Base de données :** MySQL (moteur InnoDB)
- **Frontend :** HTML5 / CSS3 / JavaScript
- **Documentation :** LaTeX (template FST / UHA)

---

## 📁 Structure du dépôt

```text
.
├── assets/                # Captures d'écran et schémas du rapport
├── style/                 # Feuilles de style CSS
├── script/                # Scripts JavaScript
├── login_vulnerable.php   # Version vulnérable (concaténation SQL)
├── login_secure.php       # Version sécurisée (requêtes préparées PDO)
├── init.php               # Initialisation et réinitialisation de la base
├── rapport.tex            # Source LaTeX du rapport
└── out/
    └── rapport.pdf        # Rapport final compilé
```

---

## ⚙️ Installation et test

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/OresteGabo/tp-sql-injection.git
   ```

2. **Configurer la base de données**  
   Modifier les paramètres de connexion dans le fichier `config.php`.

3. **Initialiser la base**
    - Lancer `init.php` via votre navigateur pour créer les tables et insérer les données de test.

4. **Tester l’application**
    - Accéder à `index.php`.
    - Comparer le comportement de l’authentification vulnérable et sécurisée.

---

## 📄 Rapport PDF

Le rapport complet détaille :
- L’analyse syntaxique des attaques SQLi
- Les scénarios d’exploitation
- Les mécanismes de défense et bonnes pratiques

👉 **[Consulter le rapport final (PDF)](out/rapport.pdf)**

---

**Université de Haute-Alsace**  
Faculté des Sciences et Techniques (FST)
