
<!DOCTYPE html>
<html>
<head>
    <title>Registreren</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body{
            background-image: url("../img/img.png"); /* Vervang "pad/naar/afbeelding.jpg" door het werkelijke pad naar je afbeelding */
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }
    </style>
</head>
<body>
<div class="registration-form my-form">
    <div class="registration-form">
        <h1>Registreren</h1>

        <form method="post" action="createUserFormulier2.php">
            <label for="gebruikersnaam">Gebruikersnaam:</label>
            <input type="text" name="gebruikersnaam" id="gebruikersnaam" required><br><br>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required><br><br>

            <label for="wachtwoord">Wachtwoord:</label>
            <input type="password" name="wachtwoord" id="wachtwoord" required><br><br>

            <input type="submit" name="register" value="Registreren">
        </form>
    </div>
    <?php
    if (isset($foutmelding)) {
        echo "<p>$foutmelding</p>";
    }
    ?>
    <button class="terugknop" onclick="goBack()">Terug</button>

    <script>
        function goBack() { 
            window.history.back();

    </script>
</div>
</body>
</html>
