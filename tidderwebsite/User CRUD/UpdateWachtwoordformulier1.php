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

// Gebruiker bijwerken
if (isset($_POST['update'])) {
    $gebruikersnaam = $_SESSION['gebruikersnaam'];
    $nieuwWachtwoord = $_POST['nieuw_wachtwoord'];

    // Een object van de Users-klasse maken
    $user = new Users($conn);

    // Zoek de gebruiker in de database op basis van de huidige gebruikersnaam
    $user->searchUsers($gebruikersnaam);

    // Controleren of een nieuw wachtwoord is ingevuld en dit bijwerken indien van toepassing
    if (!empty($nieuwWachtwoord)) {
        // Wachtwoord hashen
        $hashedWachtwoord = password_hash($nieuwWachtwoord, PASSWORD_DEFAULT);
        $user->set_wachtwoord($hashedWachtwoord);
    }

    // De bijgewerkte gebruikersgegevens opslaan in de database
    $user->updateUsers($user->get_id());

    // Doorverwijzen naar de hoofdpagina
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accountgegevens bijwerken</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<div class="mijn-formulier">
    <h1>Wachtwoord veranderen</h1>

    <form method="post" action="">
        <label for="nieuw_wachtwoord">Nieuw wachtwoord:</label>
        <input type="password" name="nieuw_wachtwoord" id="nieuw_wachtwoord"><br><br>

        <input type="submit" name="update" value="Bijwerken">
    </form>
</div>
<button class="terugknop" onclick="goBack()">Terug</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
