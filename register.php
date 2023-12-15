<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>SIGN UP</h1>
    <form action="traitement.php?action=register" method="POST">
        <label for="pseudonym">Pseudonym</label>
        <input type="text" name="pseudonym" id="pseudonym"><br>

        <label for="mail">Mail</label>
        <input type="text" name="mail" id="mail"><br>

        <label for="pass1">Password</label>
        <input type="password" name="pass1" id="pass1"><br>

        <label for="pass2">Confirm your Password</label>
        <input type="password" name="pass2" id="pass2">
        
        <input type="submit" value="SIGN UP">
    </form>
</body>
</html>