<?php
session_start();

// Controleren of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: ../login.php");
    exit();
}

// Controleren of de post_id is meegegeven in de URL
if (!isset($_GET['post_id'])) {
    header("Location: ../index.php");
    exit();
}

// Verbinding maken met de database
require_once('../config.php');
require_once('PostCRUD.php');

// Post verwijderen als de gebruiker de eigenaar is
$postId = $_GET['post_id'];
$gebruikersnaam = $_SESSION['gebruikersnaam'];

$postCRUD = new PostCRUD($conn);
$postCRUD->deletePost($postId, $gebruikersnaam);

header("Location: ../index.php");
exit();
?>
