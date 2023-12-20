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
    $nieuwEmail = $_POST['nieuw_email'];

    // Een object van de Users-klasse maken
    $user = new Users($conn);

    // Zoek de gebruiker in de database op basis van de huidige gebruikersnaam
    $user->searchUsers($gebruikersnaam);

    // De gevonden gebruikersgegevens bijwerken met de nieuwe waarden
    $user->set_email($nieuwEmail);

    // De bijgewerkte gebruikersgegevens opslaan in de database
    $user->updateUsers($user->get_id());

    // Doorverwijzen naar de hoofdpagina
    header("Location: ../index.php");
    exit();
}

// Sluit de databaseverbinding
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accountgegevens bijwerken</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<div class="email-profile-container">
    <h1 class="email-profile-title">Accountgegevens bijwerken</h1>

    <div class="email-form-container">
        <form class="email-update-form" method="post" action="">
            <div class="email-form-group">
                <label class="email-form-label" for="nieuw_email">Nieuw e-mailadres:</label>
                <input class="email-form-input" type="email" name="nieuw_email" id="nieuw_email" required>
            </div>

            <div class="email-form-group">
                <input class="email-form-submit" type="submit" name="update" value="Bijwerken">
            </div>
        </form>
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
