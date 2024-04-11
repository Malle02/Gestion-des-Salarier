<?php

session_start();
if (!isset($_SESSION['identifiant'])){
  
      header('location:../../index.php');
      exit();
  }
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Gestion_des_salarier";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

$errors = array();
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $poste = $_POST['Poste'];
    $dateEmbauche = $_POST['Date_embauche'];
    $salaire = $_POST['Salaire'];
    $departement = $_POST['Departement'];
    $mail = $_POST['Mail'];
    $nomProjet = $_POST['Nom_projet'];

    // Validation des données
    if (empty($firstName)) {
        $errors['firstName'] = "Le nom est requis.";
    }

    if (empty($lastName)) {
        $errors['lastName'] = "Le prénom est requis.";
    }

    if (empty($poste)) {
        $errors['poste'] = "Le poste est requis.";
    }

    if (empty($nomProjet)) {
        $errors['nomProjet'] = "Le nom du projet est requis.";
    } else {
        // Vérifier si le nom du projet existe dans la base de données
        $sqlProjet = "SELECT id FROM Projet WHERE nom = :nom_projet";
        $stmtProjet = $pdo->prepare($sqlProjet);
        $stmtProjet->bindParam(':nom_projet', $nomProjet);
        $stmtProjet->execute();
        $projetId = $stmtProjet->fetchColumn();

        if (!$projetId) {
            $errors['nomProjet'] = "Le nom du projet est invalide.";
        }
    }

    // Vérification des erreurs
    if (count($errors) === 0) {
        // Requête d'insertion du salarié
        $sqlSalarie = 'INSERT INTO salarier (nom, prenom, poste, date_embauche, salaire, departement, adresse_email)
                VALUES (:nom, :prenom, :poste, :date_embauche, :salaire, :departement, :email)';
        $stmtSalarie = $pdo->prepare($sqlSalarie);
    
        // Requête d'insertion du projet
        $sqlProjet = 'INSERT INTO projet (id_salarier, nom, date_debut, date_fin)
                VALUES (:id_salarier, :nom_projet, NOW(), DATE_ADD(NOW(), INTERVAL 20 DAY))';
        $stmtProjet = $pdo->prepare($sqlProjet);
    
        try {
            // Exécution de la requête d'insertion du salarié
            $stmtSalarie->bindParam(':nom', $firstName);
            $stmtSalarie->bindParam(':prenom', $lastName);
            $stmtSalarie->bindParam(':poste', $poste);
            $stmtSalarie->bindParam(':date_embauche', $dateEmbauche);
            $stmtSalarie->bindParam(':salaire', $salaire);
            $stmtSalarie->bindParam(':departement', $departement);
            $stmtSalarie->bindParam(':email', $mail);
            $stmtSalarie->execute();
    
            // Récupération de l'id du salarié nouvellement ajouté
            $salarieId = $pdo->lastInsertId();
    
            // Exécution de la requête d'insertion du projet
            $stmtProjet->bindParam(':id_salarier', $salarieId);
            $stmtProjet->bindParam(':nom_projet', $nomProjet);
            $stmtProjet->execute();
    
            $successMessage = "Le salarié a été ajouté avec succès !";
        } catch (PDOException $e) {
            die('Erreur lors de l\'ajout du salarié : ' . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajout d'un nouveau salarié</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        table {
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }

        td {
            padding: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="email"] {
            width: 250px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }

        .return-button {
            display: inline-block;
            background-color: #f44336;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 3px;
            margin-top: 10px;
        }

        .return-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <h1>Bienvenue sur la page d'ajout</h1>
    <h2>Merci de saisir les informations du nouveau salarié</h2>
    <form method="POST" action="ajout_salarie.php">
        <table>
            <tr>
                <td>Nom :</td>
                <td><input type="text" name="FirstName"></td>
            </tr>
            <?php if (isset($errors['firstName'])): ?>
                <tr>
                    <td></td>
                    <td class="error-message"><?php echo $errors['firstName']; ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td>Prénom :</td>
                <td><input type="text" name="LastName"></td>
            </tr>
            <?php if (isset($errors['lastName'])): ?>
                <tr>
                    <td></td>
                    <td class="error-message"><?php echo $errors['lastName']; ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td>Poste occupé :</td>
                <td><input type="text" name="Poste"></td>
            </tr>
            <?php if (isset($errors['poste'])): ?>
                <tr>
                    <td></td>
                    <td class="error-message"><?php echo $errors['poste']; ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td>Date d'embauche :</td>
                <td><input type="date" name="Date_embauche"></td>
            </tr>
            <tr>
                <td>Salaire :</td>
                <td><input type="text" name="Salaire"></td>
            </tr>
            <tr>
                <td>Département :</td>
                <td><input type="text" name="Departement"></td>
            </tr>
            <tr>
                <td>Email de contact :</td>
                <td><input type="email" name="Mail"></td>
            </tr>
            <tr>
                <td>Nom du projet :</td>
                <td>
                    <select name="Nom_projet">
                        <option value="">Sélectionnez un projet</option>
                        <?php
                        $sqlProjetList = "SELECT nom FROM Projet";
                        $stmtProjetList = $pdo->query($sqlProjetList);
                        while ($rowProjetList = $stmtProjetList->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $rowProjetList['nom'] . '">' . $rowProjetList['nom'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <?php if (isset($errors['nomProjet'])): ?>
                <tr>
                    <td></td>
                    <td class="error-message"><?php echo $errors['nomProjet']; ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" value="Ajouter">
                </td>
            </tr>
            <tr><td> <?php if (!empty($successMessage)): ?>
        <p class="success-message"><?php echo $successMessage; ?></p>
    <?php endif; ?></td></tr>
        </table>
    </form>
   
    <a href="../index.php" class="return-button">Retourner au menu</a>
</body>
</html>
