<?php

session_start();

if(isset($_GET["action"])) {
    switch($_GET["action"]) {
        case "register":

            // Si le formulaire est soumis
            if($_POST["submit"]) {
                // Connexion à ma base de données
                $pdo = new PDO("mysql:host=localhost;dbname=php_hash;charset=utf8", "root", "");
    
                // Sanitize la saisie des champs du formulaire d'inscription
                $pseudo = filter_input(INPUT_POST, "pseudonym", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
                if($pseudo && $mail && $pass1 && $pass2) {
                    $requete = $pdo->prepare("
                    SELECT *
                    FROM subscriber
                    WHERE mail = :mail 
                    ");
                    $requete->execute([
                        "mail" => $mail
                    ]);
                    $subscriber = $requete->fetch();
    
                    // Si l'utilisateur existe
                    if($subscriber) {
                        header("Location: register.php"); 
                        exit;
                    } else {
    
                        // Vérification et hashage du mot de passe
                        if($pass1 == $pass2 && strlen($pass1) > 5) {
                            $insertSubscriber = $pdo->prepare("
                            INSERT INTO subscriber (pseudonym, mail, password)
                            VALUES (:pseudonym, :mail, :password)
                            ");
                            $insertSubscriber->execute([
                                "pseudonym" => $pseudo,
                                "mail" => $mail,
                                "password" => password_hash($pass1, PASSWORD_DEFAULT)
                            ]);
                            header("Location: login.php"); 
                            exit;
                        } else {
                            // Message d'erreur
                            echo "Les mots de passe ne sont pas identiques ou le mot de passe est trop court !";
                        }
                    }
                } else {
                    // Message d'erreur
                    echo "Problème de saisie dans les champs de formulaire.";
                }
            } else {
                // Par défaut j'affiche le formulaire d'inscription
                header("Location: register.php"); 
                exit;
            }
            break; 

        case "login";

            // Connexion à l'application
            if($_POST["submit"]) {
                // Connexion à ma base de données
                $pdo = new PDO("mysql:host=localhost;dbname=php_hash;charset=utf8", "root", "");

                // Sanitize et préparation contre les failles XSS (formulaire)
                $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                // Si les filtres sont valides
                if($mail && $password) {

                    // Préparation contre les injections SQL
                    $requete = $pdo->prepare("
                    SELECT *
                    FROM subscriber
                    WHERE mail = :mail
                    ");

                    // Exécution de la requête
                    $requete->execute([
                        "mail" => $mail
                    ]);
                    $subscriber = $requete->fetch();
                    // var_dump($subscriber);die;

                    // Si l'utilisateur existe
                    if($subscriber) {
                        $hash = $subscriber["password"];

                        // Si password est correct
                        if(password_verify($password, $hash)) {
                            // Mettre à jour l'heure de la dernière connexion dans la base de données
                            $lastLogin = date("Y-m-d H:i:s");
                            // Assurez-vous d'avoir une colonne 'last_login' dans votre table 'subscriber'
                            $updateLastLogin = $pdo->prepare("
                            UPDATE subscriber 
                            SET last_login = :last_login 
                            WHERE id_subscriber = :id_subscriber
                            ");
                            $updateLastLogin->execute([
                                "last_login" => $lastLogin,
                                "id_subscriber" => $subscriber['id_subscriber']
                            ]);

                            // Incrémentation du compteur de connexions
                            $updateLoginCount = $pdo->prepare("
                            UPDATE subscriber 
                            SET login_count = login_count + 1
                            WHERE id_subscriber = :id_subscriber
                            ");
                            $updateLoginCount->execute([
                            "id_subscriber" => $subscriber['id_subscriber']
                            ]);

                            // Mettre l'utilisateur en session
                            $_SESSION["subscriber"] = $subscriber;

                            header("Location: home.php");
                            exit;
                        } else {

                            // Redirection vers la page de login
                            header("Location: login.php");
                            exit;
                            // message utilisateur inconnu ou mot de passe incorrect
                        }
                    } else {

                        // Redirection vers la page de login
                        header("Location: login.php");
                        exit;
                        // message utilisateur inconnu ou mot de passe incorrect
                    }
                }
            } else {
                // Par défaut j'affiche la session
                header("Location: login.php"); 
                exit;
            }
        break;

        case "logout":

            if ($_GET["action"] === "logout") {
                session_start(); // Démarrez la session si ce n'est pas déjà fait
        
                // Vérifiez si l'utilisateur est connecté
                if (!isset($_SESSION["subscriber"])) {
                    // Redirigez vers la page de connexion s'il n'est pas connecté
                    header("Location: login.php");
                    exit;
                }
        
                // Récupérez les informations de l'utilisateur depuis la session
                $subscriber = $_SESSION["subscriber"];
        
                // Connexion à la base de données
                $pdo = new PDO("mysql:host=localhost;dbname=php_hash;charset=utf8", "root", "");
        
                // Mettre à jour l'heure de la dernière déconnexion dans la base de données
                $lastLogout = date("Y-m-d H:i:s");
                $updateLastLogout = $pdo->prepare("
                    UPDATE subscriber 
                    SET last_logout = :last_logout 
                    WHERE id_subscriber = :id_subscriber
                ");
                $updateLastLogout->execute([
                    "last_logout" => $lastLogout,
                    "id_subscriber" => $subscriber['id_subscriber']
                ]);
        
                // Effacer toutes les données de la session
                $_SESSION = array();
                session_destroy();
        
                // Rediriger l'utilisateur vers la page de connexion ou une autre page appropriée
                header("Location: login.php");
                exit;
            }
        break;

        case "profile":
            header("Location: profile.php");
            exit;
        break;
    }   
}