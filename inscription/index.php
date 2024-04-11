<?php
// Informations de connexion à la base de données
$host = 'localhost';
$dbName = 'Gestion_des_salarier';
$username = 'root';
$password = '';

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Traitement du formulaire d'inscription
$msg = '';

if(isset($_POST['register'])){
    // Validation des données
    $username = $_POST['username'];
    $password = $_POST['password'];
  

    // Vérification si l'utilisateur existe déjà dans la base de données
    $query = "SELECT COUNT(*) FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if($count > 0){
        $msg = "L'utilisateur existe déjà.";
    } else {
        // Insérer les données dans la base de données
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        
        $stmt->execute();
        

        $msg = "Inscription réussie!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../style_index.css">
    
       
</head>
<body>
    <h1>DAM'STOR-FOREVER</h1>
    <div class="content">
        <div class="text">
            Inscription
        </div>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php if($msg !== ''): ?>
                <div class="<?php echo $msg === 'Inscription réussie!' ? 'success-message' : 'error-message'; ?>"><?php echo $msg; ?></div>
            <?php endif; ?>
            <div class="field">
                <input required="" type="text" name="username" id="username" class="input">
                <span class="span"><svg class="" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 512 512" y="0" x="0" height="20" width="50" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg"><g><path class="" data-original="#000000" fill="#595959" d="M256 0c-74.439 0-135 60.561-135 135s60.561 135 135 135 135-60.561 135-135S330.439 0 256 0zM423.966 358.195C387.006 320.667 338.009 300 286 300h-60c-52.008 0-101.006 20.667-137.966 58.195C51.255 395.539 31 444.833 31 497c0 8.284 6.716 15 15 15h420c8.284 0 15-6.716 15-15 0-52.167-20.255-101.461-57.034-138.805z"></path></g></svg></span>
                <label class="label">Nom d'utilisateur*</label>
            </div>
            <div class="field">
                <input required="" type="password" name="password" id="password" class="input">
                <span class="span"><svg class="" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 512 512" y="0" x="0" height="20" width="50" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg"><g><path class="" data-original="#000000" fill="#595959" d="M336 192h-16v-64C320 57.406 262.594 0 192 0S64 57.406 64 128v64H48c-26.453 0-48 21.523-48 48v224c0 26.477 21.547 48 48 48h288c26.453 0 48-21.523 48-48V240c0-26.477-21.547-48-48-48zm-229.332-64c0-47.063 38.27-85.332 85.332-85.332s85.332 38.27 85.332 85.332v64H106.668zm0 0"></path></g></svg></span>
                <label class="label">Mot de passe*</label>
            </div>
            <!-- <div class="field">
                <input  type="email" name="email" id="email" class="input"> 
                <span class="span"><svg class="" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 512 512" y="0" x="0" height="20" width="50" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg"><g><path class="" data-original="#000000" fill="#595959" d="M310 62.08l169.599 103.52v191.84l-169.599 103.52L140.4 358.4v-191.84L310 62.08zm-2.4 129.6L209.6 256l98.4 64.32v-128zM31 430.08l124.799-64.32 104 64.32 104-64.32L481 430.08v-318.4L256 160 31 111.68v318.4z"></path></g></svg></span>
                <label class="label">Email(pas obligatoire)</label>
            </div> -->
            <button class="button" type="submit" name="register">S'inscrire</button>
            <div class="sign-up">
                Déjà inscrit? <a href="../index.php">Connectez-vous ici</a>
            </div>
        </form>
       
    </div>
</body>
</html>
