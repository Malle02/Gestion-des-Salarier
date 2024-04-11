<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des salariés</title>
  <link rel="stylesheet" href="style.css">
  <style>
    h4{
  font-size: 25px;
  color: dodgerblue;
}

  </style>
</head>
<body>
  <?php
   session_start();
   if (!isset($_SESSION['identifiant'])){
     
         header('location:../index.php');
         exit();
     }
   
  ?>
  <header>
    <nav>
     
      <div class="logo"><img src="./image/white_logo.png"  width="40%" alt=""></div>
      <div> <?php
            echo "<h4>Bienvenue ". $_SESSION['identifiant'] ."</h4>" ;
            ?></div>
      <ul class="nav-links">
        <li><a href="#messageContainer">Accueil</a></li>
        <li><a href="./Salarier/index.php">Salariés</a></li>
        <li><a href="./Ajout_salarier/ajout_salarie.php">Ajouter un salarié</a></li>
        <li><a href="./projet/index.php">Ajouter un projet</a></li>
        <li><a href="../logout/index.php">Déconnexion</a></li>
      </ul>
    </nav>
  </header>

  <?php
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

  // Fonction pour récupérer tous les salariés
  function getSalaries($conn) {
    $stmt = $conn->prepare("SELECT * FROM Salarier");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Fonction pour afficher la liste des salariés
  function afficherSalaries($salaries) {
    if (!empty($salaries)) {
      echo '<ul>';
      foreach ($salaries as $salarie) {
        echo '<li><a href="./modification/index.php?id=' . $salarie['id'] . '">' . $salarie['prenom'] . ' ' . $salarie['nom'] . '</a></li>';
        //<a href="informations.php
      }
      echo '</ul>';
    } else {
      echo '<p>Aucun salarié trouvé.</p>';
    }
  }

  // Récupération de tous les salariés
  $salaries = getSalaries($conn);
  ?>

  <main>
    <!-- Section recherche -->
    <?php
    if (isset($_GET['query'])) {
      $query = $_GET['query'];
      // Requête pour récupérer les salariés dont le prénom contient la lettre saisie
      $stmt = $conn->prepare("SELECT * FROM salarier WHERE prenom LIKE :query");
      $stmt->bindValue(':query', '%' . $query . '%');
      $stmt->execute();
      $salaries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>

    <section class="search-bar">
      <div class="placement_recherche">
        <form action="" method="GET">
          <input type="text" class="search" name="query" placeholder="Rechercher..." onkeyup="showResults(this.value)">
          
        </form>
        <div class="search-results" id="searchResults"></div>
      </div>
    </section>

    <section class="salaries">
    
  <h2>Liste des salariés</h2>
  <div id="messageContainer" style="display: none;">
  <p>Aucun salarié correspondant n'a été trouvé.</p>
</div>

  <ul class="salaries-list">
    <?php
    if (!empty($salaries)) {
      foreach ($salaries as $salarie) {
        echo '<li class="salarie-item"><a href="./modification/index.php?id=' . $salarie['id'] . '">' . $salarie['prenom'] . ' ' . $salarie['nom'] . '</a></li>';
      }
    } else {
      echo '<p>Aucun salarié trouvé.</p>';
    }
    ?>
  </ul>
</section>

  </main>
  <footer>
    <p>&copy; 2023 Gestion des salariés. Tous droits réservés.</p>
  </footer>
  <script src="script.js"></script>
</body>
</html>
