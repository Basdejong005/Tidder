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
    $nieuweGebruikersnaam = $_POST['nieuwe_gebruikersnaam'];
    $nieuwWachtwoord = $_POST['nieuw_wachtwoord'];
    $nieuwEmail = $_POST['nieuw_email'];

    // Een object van de Users-klasse maken
    $user = new Users($conn);

    // Zoek de gebruiker in de database op basis van de huidige gebruikersnaam
    $user->searchUsers($gebruikersnaam);

    // De gevonden gebruikersgegevens bijwerken met de nieuwe waarden
    $user->set_gebruikersnaam($nieuweGebruikersnaam);
    $user->set_email($nieuwEmail);

    // Controleren of een nieuw wachtwoord is ingevuld en dit bijwerken indien van toepassing
    if (!empty($nieuwWachtwoord)) {
        // Wachtwoord hashen
        $hashedWachtwoord = password_hash($nieuwWachtwoord, PASSWORD_DEFAULT);
        $user->set_wachtwoord($hashedWachtwoord);
    }

    // De bijgewerkte gebruikersgegevens opslaan in de database
    $user->updateUsers($user->get_id());

    // Gebruikersnaam bijwerken in de huidige sessie
    $_SESSION['gebruikersnaam'] = $nieuweGebruikersnaam;

    // Doorverwijzen naar de hoofdpagina
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accountgegevens bijwerken</title>
</head>
<body>
<h1>Accountgegevens bijwerken</h1>

<form method="post" action="">
    <label for="nieuwe_gebruikersnaam">Nieuwe gebruikersnaam:</label>
    <input type="text" name="nieuwe_gebruikersnaam" id="nieuwe_gebruikersnaam" required><br><br>

    <label for="nieuw_email">Nieuw e-mailadres:</label>
    <input type="email" name="nieuw_email" id="nieuw_email" required><br><br>

    <label for="nieuw_wachtwoord">Nieuw wachtwoord:</label>
    <input type="password" name="nieuw_wachtwoord" id="nieuw_wachtwoord"><br><br>

    <input type="submit" name="update" value="Bijwerken">
</form>

</body>
</html>
