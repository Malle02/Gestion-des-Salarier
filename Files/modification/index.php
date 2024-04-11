<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Détails du salarié</title>
  <link rel="stylesheet" href="./styled.css">
  
  <style>
    .confirmation-box {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      
      transform: translate(-50%, -50%);
      background-color: #fff;
      border: 1px solid #ccc;
      padding: 20px;
      text-align: center;
    }
    .confirmation-box p {
      margin-bottom: 10px;
    }
    .confirmation-box button {
      margin-right: 10px;
    }
  </style>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['identifiant'])){
  
      header('location:../../index.php');
      exit();
  }
  // Récupérer l'ID du salarié depuis la requête GET
  if (isset($_GET['id'])) {
    $salariéId = $_GET['id'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Gestion_des_salarier";

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); // Activer la requête bufferisée
    } catch(PDOException $e) {
      echo "Erreur de connexion à la base de données : " . $e->getMessage();
      exit(); // Arrêter l'exécution du script en cas d'erreur de connexion
    }

    // Récupération des informations du salarié depuis la base de données
    $stmt = $conn->prepare("SELECT * FROM Salarier WHERE id = :id");
    $stmt->bindParam(':id', $salariéId);
    $stmt->execute();
    $salarié = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($salarié) {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Traitement de la mise à jour des informations du salarié
        if (isset($_POST['nom'])) {
          $nom = $_POST['nom'];
        } else {
          $nom = $salarié['nom'];
        }

        if (isset($_POST['prenom'])) {
          $prenom = $_POST['prenom'];
        } else {
          $prenom = $salarié['prenom'];
        }

        if (isset($_POST['poste'])) {
          $poste = $_POST['poste'];
        } else {
          $poste = $salarié['poste'];
        }

        if (isset($_POST['date_embauche'])) {
          $dateEmbauche = $_POST['date_embauche'];
        } else {
          $dateEmbauche = $salarié['date_embauche'];
        }

        if (isset($_POST['salaire'])) {
          $salaire = $_POST['salaire'];
        } else {
          $salaire = $salarié['salaire'];
        }

        if (isset($_POST['departement'])) {
          $departement = $_POST['departement'];
        } else {
          $departement = $salarié['departement'];
        }

        if (isset($_POST['adresse_email'])) {
          $adresseEmail = $_POST['adresse_email'];
        } else {
          $adresseEmail = $salarié['adresse_email'];
        }

        $stmt = $conn->prepare("UPDATE Salarier SET nom = :nom, prenom = :prenom, poste = :poste, date_embauche = :date_embauche, salaire = :salaire, departement = :departement, adresse_email = :adresse_email WHERE id = :id");

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':poste', $poste);
        $stmt->bindParam(':date_embauche', $dateEmbauche);
        $stmt->bindParam(':salaire', $salaire);
        $stmt->bindParam(':departement', $departement);
        $stmt->bindParam(':adresse_email', $adresseEmail);
        $stmt->bindParam(':id', $salariéId);

        if ($stmt->execute()) {
          $message = 'Les informations ont été mises à jour avec succès.';
          // Récupération des nouvelles informations du salarié depuis la base de données
          $stmt = $conn->prepare("SELECT * FROM Salarier WHERE id = :id");
          $stmt->bindParam(':id', $salariéId);
          $stmt->execute();
          $salarié = $stmt->fetch(PDO::FETCH_ASSOC);

        } else {
          $message = 'Une erreur est survenue lors de la mise à jour des informations.';
        }
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
        // Suppression des enregistrements liés dans la table HistoriqueSalaire
        $stmt = $conn->prepare("DELETE FROM HistoriqueSalaire WHERE id_salarier = :id");
        $stmt->bindParam(':id', $salariéId);
        $stmt->execute();

        // Suppression des enregistrements liés dans la table Attribution
        $stmt = $conn->prepare("DELETE FROM projet WHERE id_salarier = :id");
        $stmt->bindParam(':id', $salariéId);
        $stmt->execute();

        // Suppression de l'enregistrement dans la table Salarier
        $stmt = $conn->prepare("DELETE FROM Salarier WHERE id = :id");
        $stmt->bindParam(':id', $salariéId);

        if ($stmt->execute()) {
          //$message = 'Le salarié a été supprimé avec succès.';

          header('Location:./Spprime.php');
          $salarié = false; // Indicateur que le salarié n'existe plus
        } else {
          $message = 'Une erreur est survenue lors de la suppression du salarié.';
        }
      }
    }
  }
?>
       <section class="employee-details">
    <div class="employee-info">
      <?php if (!empty($message)): ?>
        <div class="success-message"><?php echo $message; ?></div>
      <?php endif; ?>
      <h2>Détails du salarié</h2>
      <h3><?php echo $salarié['nom']. " " . $salarié['prenom'] ; ?></h3>
      <form method="post" action="">
        <p><strong>Nom :</strong> <input type="text" name="nom" value="<?php echo $salarié['nom']; ?>" readonly></p>
        <p><strong>Prénom :</strong> <input type="text" name="prenom" value="<?php echo $salarié['prenom']; ?>" readonly></p>
        <p><strong>Poste :</strong> <input type="text" name="poste" value="<?php echo $salarié['poste']; ?>" readonly></p>
        <p><strong>Date d'embauche :</strong> <input type="text" name="date_embauche" value="<?php echo $salarié['date_embauche']; ?>" readonly></p>
        <p><strong>Salaire :</strong> <input type="text" name="salaire" value="<?php echo $salarié['salaire']; ?>" readonly></p>
        <p><strong>Département :</strong> <input type="text" name="departement" value="<?php echo $salarié['departement']; ?>" readonly></p>
        <p><strong>Adresse email :</strong> <input type="text" name="adresse_email" value="<?php echo $salarié['adresse_email']; ?>" readonly></p>
        <div class="employee-actions">
          <button type="button" id="edit-button" class="btn-edit">Modifier</button>
          <button type="submit" id="update-button" class="btn-edit" style="display: none;">Mettre à jour</button>
          <button type="button" id="delete-button" class="btn-delete">Supprimer</button>
        </div>
      </form>
      
      <a href="../index.php" class="btn-back">Retour à la page principale</a>
    </div>
  </section>

  <div class="confirmation-box" id="confirmation-box">
    <p>Êtes-vous sûr de vouloir supprimer ce salarié ?</p>
    <button onclick="handleConfirmation(true)">Oui</button>
    <button onclick="handleConfirmation(false)">Non</button>
  </div>

  <form id="delete-form" method="post" action="">
    <input type="hidden" name="confirm_delete" value="1">
  </form>

  <script>
    const editButton = document.getElementById('edit-button');
    const updateButton = document.getElementById('update-button');
    const deleteButton = document.getElementById('delete-button');
    const confirmationBox = document.getElementById('confirmation-box');
    const inputs = document.querySelectorAll('input');

    editButton.addEventListener('click', () => {
      inputs.forEach(input => {
        input.readOnly = false;
      });
      editButton.style.display = 'none';
      updateButton.style.display = 'inline-block';
    });

    deleteButton.addEventListener('click', () => {
      confirmationBox.style.display = 'block';
    });

    function handleConfirmation(confirmed) {
      if (confirmed) {
        document.getElementById('delete-form').submit();
      } else {
        confirmationBox.style.display = 'none';
      }
    }
  </script>
</body>
</html>

  <?php
  //  } else {
    //  echo 'Salarié non trouvé.';
    //}
  //} else {
    //echo 'ID du salarié non spécifié.';
  //}
  ?>
