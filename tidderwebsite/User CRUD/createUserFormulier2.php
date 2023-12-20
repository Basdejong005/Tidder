<?php
session_start();

require_once "../config.php";
require_once "Users.php";

// Controleren of de gebruiker al ingelogd is
if (isset($_SESSION['gebruikersnaam'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['register'])) {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];
    $email = $_POST['email'];

    // Controleren of de gebruikersnaam al in gebruik is
    $users = new Users($conn);
    $gebruiker = $users->searchUsers($gebruikersnaam);

    if (!empty($gebruiker)) {
        $foutmelding = "Deze gebruikersnaam is al in gebruik.";
    } else {
        // Wachtwoord hashen voordat het wordt opgeslagen in de database
        $hashedWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

        // Gebruiker toevoegen aan de database
        $users->createUsers($gebruikersnaam, $hashedWachtwoord, $email);

        // Inloggen en doorverwijzen naar de hoofdpagina
        $_SESSION['gebruikersnaam'] = $gebruikersnaam;
        header("Location: ../index.php");
        exit();
    }
}
