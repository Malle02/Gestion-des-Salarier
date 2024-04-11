<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style_index.css">
</head>
<body>
    <h1>DAM'STOR-FOREVER</h1>
    <div class="content">
        <div class="text">
            Connexion
        </div>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php
                session_start();
               

                $msg = '';

                if(isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])){
                    // Connexion à la base de données
                    $dsn = 'mysql:host=localhost;dbname=Gestion_des_salarier';
                    $username = 'root';
                    $password = '';
                   $a = $_SESSION['identifiant'] = $_POST['username'];

                    try {
                        $pdo = new PDO($dsn, $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Vérification des informations d'identification
                        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
                        $stmt->execute(array(':username' => $_POST['username'], ':password' => $_POST['password']));
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        if($row){
                            // Les informations d'identification sont correctes, ouvrez une session et redirigez l'utilisateur vers une autre page
                           
                            header("Location: ./Files/index.php");
                            exit();
                        } else {
                            $msg = "Nom d'utilisateur ou mot de passe incorrect";
                        }
                    } catch(PDOException $e) {
                        echo "Erreur de connexion à la base de données : " . $e->getMessage();
                    }
                }
            ?>
            <div class="field">
                <input required="" type="text" name="username" class="input">
                <span class="span"><svg class="" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 512 512" y="0" x="0" height="20" width="50" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg"><g><path class="" data-original="#000000" fill="#595959" d="M256 0c-74.439 0-135 60.561-135 135s60.561 135 135 135 135-60.561 135-135S330.439 0 256 0zM423.966 358.195C387.006 320.667 338.009 300 286 300h-60c-52.008 0-101.006 20.667-137.966 58.195C51.255 395.539 31 444.833 31 497c0 8.284 6.716 15 15 15h420c8.284 0 15-6.716 15-15 0-52.167-20.255-101.461-57.034-138.805z"></path></g></svg></span>
                <label class="label">Nom d'utilisateur</label>
            </div>
            <div class="field">
                <input required="" type="password" name="password" class="input">
                <span class="span"><svg class="" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 512 512" y="0" x="0" height="20" width="50" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg"><g><path class="" data-original="#000000" fill="#595959" d="M336 192h-16v-64C320 57.406 262.594 0 192 0S64 57.406 64 128v64H48c-26.453 0-48 21.523-48 48v224c0 26.477 21.547 48 48 48h288c26.453 0 48-21.523 48-48V240c0-26.477-21.547-48-48-48zm-229.332-64c0-47.063 38.27-85.332 85.332-85.332s85.332 38.27 85.332 85.332v64H106.668zm0 0"></path></g></svg></span>
                <label class="label">Mot de passe</label>
            </div>
            <div class="forgot-pass">
                <a href="#">Mot de passe oublié? (soon)</a>
            </div>
            <button class="button" type="submit" name="login">Connexion</button>
            <div class="sign-up">
                Pas de compte?
                <a href="./inscription/index.php">S'inscrire maintenant!</a>
            </div>
            <?php if(!empty($msg)) { ?>
                <div class="error"><?php echo $msg; ?></div>
            <?php } ?>
        </form>
    </div>
</body>
</html>
