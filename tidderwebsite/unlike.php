<?php
session_start();

// Controleren of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// Verbinding maken met de database
require_once('config.php');

// Controleer of het formulier is ingediend en verwerk de unlike
if (isset($_POST['unlike'])) {
    $post_id = $_POST['post_id'];
    $gebruikersnaam = $_SESSION['gebruikersnaam'];

    // Verwijder de like uit de database
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "DELETE FROM likes WHERE post_id = :post_id AND gebruikersnaam = :gebruikersnaam";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
    $stmt->execute();
}

// Sluit de databaseverbinding
$conn = null;

// Stuur de gebruiker terug naar de hoofdpagina
header("Location: index.php");
exit();


