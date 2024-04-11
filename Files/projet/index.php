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
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Récupération des salariés pour afficher dans le formulaire de sélection
$stmt = $conn->prepare("SELECT id, nom, prenom FROM Salarier");
$stmt->execute();
$salariés = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire d'ajout de projet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nomProjet = $_POST['nomProjet'];
  $dateDébut = $_POST['dateDébut'];
  $dateFin = $_POST['dateFin'];
  $idSalarié = $_POST['idSalarié'];

  // Insertion du projet dans la table Projet
  $stmt = $conn->prepare("INSERT INTO Projet (nom, date_debut, date_fin, id_salarier) VALUES (:nom, :dateDebut, :dateFin, :idSalarie)");

  $stmt->bindParam(':nom', $nomProjet);
  $stmt->bindParam(':dateDebut', $dateDébut);
  $stmt->bindParam(':dateFin', $dateFin);
  $stmt->bindParam(':idSalarie', $idSalarié); // Utilisation d'un nom de paramètre différent ici
 
  
  $stmt->execute();

  // Redirection vers une page de confirmation ou une autre action
  header('Location: index.php?success=true');
  exit();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un projet</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .success-message {
      background-color: #dff0d8;
      color: #3c763d;
      padding: 10px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <h1>Ajouter un projet</h1>

  <form action="" method="POST">
  <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
    <div class="success-message">
      Le projet a été ajouté avec succès !
    </div>
  <?php endif; ?>
    <label for="nomProjet">Nom du projet :</label>
    <input type="text" name="nomProjet" id="nomProjet" required>

    <label for="dateDébut">Date de début :</label>
    <input type="date" name="dateDébut" id="dateDébut" required>

    <label for="dateFin">Date de fin :</label>
    <input type="date" name="dateFin" id="dateFin" required>

    <label for="idSalarié">Salarié concerné :</label>
    <select name="idSalarié" id="idSalarié" required>
      <?php foreach ($salariés as $salarié): ?>
        <option value="<?php echo $salarié['id']; ?>"><?php echo $salarié['prenom'] . ' ' . $salarié['nom']; ?></option>
      <?php endforeach; ?>
    </select>

    <button type="submit">Ajouter le projet</button>
    <a href="../index.php" class="btn-back">Retour à la page principale</a>
  </form>
</body>
</html>
