
<?php
session_start();

// Require the Community class
require_once('Community.php');

// Checking if the user is logged in
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: ../login.php");
    exit();
}

// Verbinding maken met de database
require_once('../config.php');

if (isset($_POST['create_community'])) {
    $community_naam = $_POST['community_naam'];
    $gebruikersnaam = $_SESSION['gebruikersnaam']; // Gebruikersnaam van de ingelogde gebruiker

    // Create an instance of the Community class
    $communityCreator = new Community($conn);
    $communityCreator->setCommunityNaam($community_naam);
    $communityCreator->setGebruikersnaam($gebruikersnaam);
    $communityCreator->createCommunity();

    // Close the database connection
    $communityCreator->closeConnection();

    // Redirect naar de hoofdpagina na het aanmaken van de community
    header("Location: ../index.php");
    exit();
}

$conn = null;
?>