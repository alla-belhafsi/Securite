<?php

$password = "myPassword1234";
$password2 = "myPassword1234";
$password3 = "myPassword123";
echo "Mot de passe 1: myPassword1234<br>";
echo "Mot de passe 2: myPassword1234<br>";
echo "Mot de passe 3: myPassword123<br><br>";

// algorithme de hashage Faible (MD5)
$md5 = hash('md5', $password);
$md5_2 = hash('md5', $password2);
$md5_3 = hash('md5', $password3);

echo "Mot de passe 1 (MD5):<br>";
echo $md5."<br>";
echo "Mot de passe 2 (MD5):<br>";
echo $md5_2."<br>";
echo "Mot de passe 3 (MD5):<br>";
echo $md5_3."<br><br>";

// algorithme de hashage Faible (SHA-256)
$sha256 = hash('sha256', $password);
$sha256_2 = hash('sha256', $password2);
$sha256_3 = hash('sha256', $password3);

echo "Mot de passe 1 (SHA-256):<br>";
echo $sha256."<br>";
echo "Mot de passe 2 (SHA-256):<br>";
echo $sha256_2."<br>";
echo "Mot de passe 3 (SHA-256):<br>";
echo $sha256_3."<br><br>";

// algorithme de hashage FORT (Argon2I)
$argon2i = password_hash($password, PASSWORD_ARGON2I);
$argon2i_2 = password_hash($password2, PASSWORD_ARGON2I);
$argon2i_3 = password_hash($password3, PASSWORD_ARGON2I);

echo "À chaque actualisation un nouveau hashage<br>";
echo "Mot de passe 1 (Argon2i):<br>";
echo $argon2i . "<br>";
echo "Mot de passe 2 (Argon2i):<br>";
echo $argon2i_2 . "<br>";
echo "Mot de passe 3 (Argon2i):<br>";
echo $argon2i_3 . "<br><br>";

// algorithme de hashage FORT (Argon2ID)
$argon2id = password_hash($password, PASSWORD_ARGON2ID);
$argon2id_2 = password_hash($password2, PASSWORD_ARGON2ID);
$argon2id_3 = password_hash($password3, PASSWORD_ARGON2ID);

echo "À chaque actualisation un nouveau hashage<br>";
echo "Mot de passe 1 (Argon2id):<br>";
echo $argon2id . "<br>";
echo "Mot de passe 2 (Argon2id):<br>";
echo $argon2id_2 . "<br>";
echo "Mot de passe 3 (Argon2id):<br>";
echo $argon2id_3 . "<br><br>";

// algorithme de hashage FORT (BCrypt)
$bcrypt = password_hash($password, PASSWORD_BCRYPT);
$bcrypt_2 = password_hash($password2, PASSWORD_BCRYPT);
$bcrypt_3 = password_hash($password3, PASSWORD_BCRYPT);

echo "À chaque actualisation un nouveau hashage<br>";
echo "Mot de passe 1 (bcrypt):<br>";
echo $bcrypt."<br>";
echo "Mot de passe 2 (bcrypt):<br>";
echo $bcrypt_2."<br>";
echo "Mot de passe 3 (bcrypt):<br>";
echo $bcrypt_3."<br><br>";

// algorithme de hashage FORT (par défaut)
$hash = password_hash($password, PASSWORD_DEFAULT);
$hash_2 = password_hash($password2, PASSWORD_DEFAULT);
$hash_3 = password_hash($password3, PASSWORD_DEFAULT);

echo "Pour choisir le plus sécuriser sans se préoccuper de l'utilisation choisir :<br> PASSWORD_DEFAULT = PASSWORD_BCRYPT<br><br>";
echo "À chaque actualisation un nouveau hashage<br>";
echo "Mot de passe 1 (par défaut):<br>";
echo $hash . "<br>";
echo "Mot de passe 2 (par défaut):<br>";
echo $hash_2 . "<br>";
echo "Mot de passe 3 (par défaut):<br>";
echo $hash_3 . "<br><br><br><br>";

// saisie dans le formulaire de login
$saisie = "myPassword1234";
echo "Dans le cas où les deux passwords se correspondent :<br>";
$check = password_verify($saisie, $hash);
if (password_verify($saisie, $hash)) {
    echo "Mot de passe correct : true";
} else {
    echo "Mot de passe incorrect : false";
}
echo "<br><br>Dans le cas où les deux passwords ne se correspondent pas :<br>";
if (password_verify($saisie, $hash_3)) {
    echo "Mot de passe correct : true";
} else {
    echo "Mot de passe incorrect : false";
}