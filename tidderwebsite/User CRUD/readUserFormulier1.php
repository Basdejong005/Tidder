<?php
session_start();

// Controleren of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: ../login.php");
    exit();
}

// Verbinding maken met de database
require_once('../config.php');
require_once('Users.php');

// Gebruiker ophalen op basis van de huidige gebruikersnaam
$user = new Users($conn);
$user->searchUsers($_SESSION['gebruikersnaam']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mijn Gegevens</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<div class="mijn-formulier">
    <h1>Mijn Gegevens</h1>

    <div>
        <p>Gebruikersnaam: <?php echo $user->get_gebruikersnaam(); ?></p>
    </div>

    <div>
        <p>E-mail: <?php echo $user->get_email(); ?></p>
    </div>
</div>
<button class="terugknop" onclick="goBack()">Terug</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>