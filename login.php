<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>LOGIN</h1>
    <form action="traitement.php?action=login" method="POST">
        <label for="mail">Mail</label>
        <input type="mail" name="mail" id="mail"><br>
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password"><br>

        <input type="submit" name="submit" value="LOGIN">
    </form>
</body>
</html>