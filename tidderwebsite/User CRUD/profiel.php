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
    <title>Profiel</title>
    <link rel="stylesheet" type="text/css" href="../style.css">

</head>
<body>
<div class="profile-container">
    <h1 class="profile-title">Profiel</h1>

    <div class="profile-info">
        <p class="profile-label">Naam:</p>
        <p class="profile-value"><?php echo $user->get_gebruikersnaam(); ?></p>
    </div>

    <div class="profile-actions">
        <a href="UpdateEmailFormulier1.php" class="profile-button">E-mailadres bijwerken</a>
        <a href="UpdateWachtwoordformulier1.php" class="profile-button">Wachtwoord bijwerken</a>
        <a href="readUserFormulier1.php" class="profile-button">Gegevens bekijken</a>
        <a href="deleteUserFormulier1.php" class="profile-button">Account verwijderen</a>
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