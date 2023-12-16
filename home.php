
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <?php
    session_start();
    
    // Vérifiez si l'utilisateur n'est pas connecté
    if (!isset($_SESSION["subscriber"])) {
        // Rediriger vers la page de connexion s'il n'est pas connecté
        header("Location: login.php");
        exit;
    } else {
    
    // Récupérez les informations de l'utilisateur depuis la session
    $subscriber = $_SESSION["subscriber"];
    
    ?>
    <h1>Welcome to your Dashboard <?php echo $subscriber['pseudonym']; ?>!</h1>
    <p>Email: <?php echo $subscriber['mail']; ?></p>
    
    <!-- Autres informations de l'utilisateur à afficher -->
    <!-- Affichage de la dernière connexion -->
    <?php
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
    <p>Dernière connexion : <?php echo $formattedDate . " à " . $time; ?></p>
    
        <!-- Affichage de la dernière connexion -->
        <?php
        if (isset($subscriber['last_logout'])) {
            $lastLogout = new DateTime($subscriber['last_logout']);
        
            // Définir le fuseau horaire
            $lastLogout->setTimezone(new DateTimeZone('Europe/Paris')); 
        
            // Définir la localisation en français
            setlocale(LC_TIME, 'fr_FR.utf8', 'fra'); 
        
            // Créer un formateur de date pour le français
            $formatterLogout = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE); 
        
            // Formater la date avec la première lettre en majuscule pour le jour et le mois
            $formattedDateLogout = ucwords($formatterLogout->format($lastLogout));
        
            // Afficher l'heure au format souhaité (14h04)
            $timeLogout = $lastLogout->format('H\hi');
            ?>
            <p>Dernière déconnexion : <?php echo $formattedDateLogout . " à " . $timeLogout; ?></p>
        
        <?php } ?>

    <!-- Liens vers d'autres fonctionnalités de l'application -->
    <p><a href="traitement.php?action=profile">Profile</a></p>
    <p><a href="traitement.php?action=settings">Settings</a></p>

    <!-- Bouton de déconnexion -->
    <p><a href="traitement.php?action=logout">Logout</a></p>

    <?php } ?>
</body>
</html>