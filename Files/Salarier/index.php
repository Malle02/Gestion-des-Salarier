<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des salariés</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- <header>
    <nav>
      <div class="logo">Logo de l'entreprise</div>
      <ul class="nav-links">
        <li><a href="../index.php">Accueil</a></li>
        <li class="active"><a href="#">Salariés</a></li>
        <li><a href="#">Ajouter un salarié</a></li>
        <li><a href="#">Déconnexion</a></li>
      </ul>
    </nav>
  </header> -->

  <main>
    <section class="salaries">
      <div class="salaries-container">
        <h1>Liste des salariés</h1>
        
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

        // Récupération des salariés
        $stmt = $conn->prepare("
        SELECT Salarier.*, Projet.nom AS nom_projet
        FROM Salarier
        LEFT JOIN Projet ON Salarier.id = Projet.id_salarier
      ");
        $stmt->execute();
        
        $salaries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="salaries-grid">
          <?php
          foreach ($salaries as $salarie) {
            echo '<div class="salarie-card">';
            echo '<h2>' . $salarie['prenom'] . ' ' . $salarie['nom'] . '</h2>';
            echo '<p><strong>Poste:</strong> ' . $salarie['poste'] . '</p>';
            echo '<p><strong>Embauche :</strong> ' . $salarie['date_embauche'] . '</p>';
            echo '<p><strong>Projet attribuer :</strong> ' . (isset($salarie['nom_projet']) ? $salarie['nom_projet'] : 'Aucun projet') . '</p>';
            echo '<button class="btn-voir-plus">Voir plus</button>';
            echo '<div class="salarie-details">';
            echo '<p><strong>Salaire :</strong> ' . $salarie['salaire'] . '</p>';
            echo '<p><strong>Departement :</strong> ' . $salarie['departement'] . '</p>';
            echo '<p><strong>Adresse Mail:</strong> ' . $salarie['adresse_email'] . '</p>';
            echo '</div>';
            echo '</div>';
          }
          ?>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2023 Gestion des salariés. Tous droits réservés.</p>
  </footer>

  <script src="index.js"></script>
</body>
</html>
