<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>HOME</h1>
    <?php
    session_start();
    
    // Vérifiez si l'utilisateur n'est pas connecté
    if (!isset($_SESSION["subscriber"])) { ?>
        
        <p><a href="traitement.php?action=login">LOGIN</a></p>
        <p><a href="traitement.php?action=register">SIGN UP</a></p>

        <?php
        exit;
    } else {
        
    // Récupérez les informations de l'utilisateur depuis la session
    $subscriber = $_SESSION["subscriber"];
    $loginCount = $subscriber["login_count"];
    ?>

    <h2>Welcome to your Dashboard <?php echo $subscriber['pseudonym']; ?>!</h2>
    
    <?php
    if($loginCount === null || $loginCount == 0) {  
        ?>
                
        <p>
            Félicitations <?php echo $subscriber['pseudonym']; ?>, c'est votre première connexion.
        </p>
        <p>
            Bienvenue dans notre communauté dédiée aux NFT et au metaverse, <?php echo $subscriber['pseudonym']; ?>! Ensemble, explorons le potentiel infini de ce monde virtuel.
        </p>

        <?php
    } else { 

        //Autres informations de l'utilisateur à afficher
        // Affichage de la dernière connexion 
        $lastLogin = new DateTime($subscriber['last_login']);
        // Définir le fuseau horaire
        $lastLogin->setTimezone(new DateTimeZone('Europe/Paris')); 
        // Définir la localisation en français
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra'); 
        // Créer un formateur de date pour le français
        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE); 
        // Formater la date avec la première lettre en majuscule pour le jour et le mois
        $formattedDate = ucwords($formatter->format($lastLogin));
        // Afficher l'heure au format souhaité
        $time = $lastLogin->format('H\hi');
        ?>
        <p>
            Dernière connexion : <?php echo $formattedDate . " à " . $time; ?>
        </p>
        <?php
        // Affichage de la dernière connexion 
        $lastLogout = new DateTime($subscriber['last_logout']);
    
        // Définir le fuseau horaire
        $lastLogout->setTimezone(new DateTimeZone('Europe/Paris')); 
    
        // Définir la localisation en français
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra'); 
    
        // Créer un formateur de date pour la langue française
        $formatterLogout = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE); 
    
        // Formater la date avec la première lettre en majuscule pour le jour et le mois
        $formattedDateLogout = ucwords($formatterLogout->format($lastLogout));
    
        // Afficher l'heure au format souhaité (00h00)
        $timeLogout = $lastLogout->format('H\hi');
        $pseudo = $subscriber['pseudonym'];
        ?>
        <p>
            Dernière déconnexion : <?php echo $formattedDateLogout . " à " . $timeLogout; ?>
        </p> 

    <?php } ?>
       

    <!-- Liens vers d'autres fonctionnalités de l'application -->
    <p><a href="traitement.php?action=profile">Profile</a></p>
    <p><a href="traitement.php?action=settings">Settings</a></p>

    <!-- Lien de déconnexion -->
    <p><a href="traitement.php?action=logout">Logout</a></p>

    <?php } ?>
</body>
</html>