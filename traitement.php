<?php


if(isset($_GET["action"])) {
    switch($_GET["action"]) {
        case "register":

            // Connexion à ma base de données
            $pdo = new PDO("mysql:host=localhost;dbname=php_hash_colmar;charset=utf8", "root", "");

            // Sanitize la saisie des champs du formulaire d'inscription
            $pseudo = filter_input(INPUT_POST, "pseudonym", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($pseudonym && $mail && $pass1 && $pass2) {
                $requete = $pdo->prepare("
                SELECT *
                FROM subscriber
                WHERE mail = :mail 
                ");
                $requete->execute(["mail => $mail"]);
                $subscriber = $requete->fetch();

                // Si l'utilisateur existe
                if($subscriber) {
                    header("Location: register.php"); exit;
                } else {

                    // Insertion de l'utilisateur dans ma base de données
                    // Vérification et hashage du mot de passe
                    if($pass1 == $pass2 && strlen($pass1) > 5) {
                        $insertSubscriber = $pdo->prepare("
                        INSERT TO subscriber (pseudonym, mail, password)
                        VALUES (:pseudonym, :mail, :password
                        ");
                        $insertSubscriber->execute([
                            "pseudonym" => $pseudonym,
                            "mail" => $mail,
                            "password" => password_hash($pass1, PASSWORD_DEFAULT)
                        ]);
                        header("Loacation: login.php"); exit;
                    } else {
                        // Message "Les mots de passe ne sont pas identiques ou mot de passe trop court !
                    }
                }
            } else {
                // Problème de saisie dans les champs de formulaire
            }
        break; 

        case "Login";
            // Connexion à l'application
        break;
    }   
}