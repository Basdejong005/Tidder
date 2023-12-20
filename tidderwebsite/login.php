<?php
session_start();

// Controleren of de gebruiker al ingelogd is
if (isset($_SESSION['gebruikersnaam'])) {
    header("Location: index.php");
    exit();
}

// Verbinding maken met de database
require_once('config.php');

if (isset($_POST['login'])) {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    // Query om de gebruiker op te halen op basis van de gebruikersnaam
    $query = "SELECT * FROM users WHERE gebruikersnaam = :gebruikersnaam";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        $gehashtWachtwoord = $rij['wachtwoord'];

        // Controleren of het ingevoerde wachtwoord overeenkomt met het gehashte wachtwoord in de database
        if (password_verify($wachtwoord, $gehashtWachtwoord)) {
            // Inloggen en doorverwijzen naar de hoofdpagina
            $_SESSION['gebruikersnaam'] = $gebruikersnaam;
            header("Location: index.php");
            exit();
        } else {
            $foutmelding = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    } else {
        $foutmelding = "Ongeldige gebruikersnaam of wachtwoord.";
    }
}

// Sluit de databaseverbinding
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inloggen</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body{
            background-image: url("img/img.png"); /* Vervang "pad/naar/afbeelding.jpg" door het werkelijke pad naar je afbeelding */
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }
    </style>
</head>
<body>
<div class="containers login-form">
    <h1>Inloggen</h1>

    <form method="post" action="">
        <label for="gebruikersnaam">Gebruikersnaam:</label>
        <input type="text" name="gebruikersnaam" id="gebruikersnaam" required><br><br>

        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" name="wachtwoord" id="wachtwoord" required><br><br>

        <input type="submit" name="login" value="Inloggen" class="button">
    </form>

    <?php
    if (isset($foutmelding)) {
        echo "<p>$foutmelding</p>";
    }
    ?>

    <p>Heb je nog geen account? <a href="User%20CRUD/createUserFormulier1.php">Registreer hier</a>.</p>
</div>
</body>
</html>
