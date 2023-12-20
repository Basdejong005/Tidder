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

// Verwijderen van het account
if (isset($_POST['confirm-delete'])) {
    $user->deleteUsers($user->get_id());
    session_destroy();
    header("Location: ../login.php");
    exit();
}
