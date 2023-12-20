<?php
session_start();

// Controleren of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// Verbinding maken met de database
require_once('config.php');

// Controleren of reactie_id en post_id zijn opgegeven
if (!isset($_GET['reactie_id']) || !isset($_GET['post_id'])) {
    header("Location: index.php");
    exit();
}

// Reactie verwijderen
$reactieId = $_GET['reactie_id'];
$postId = $_GET['post_id'];
$verwijderQuery = "DELETE FROM reacties WHERE id = :reactie_id AND post_id = :post_id";
$verwijderStatement = $conn->prepare($verwijderQuery);
$verwijderStatement->bindParam(':reactie_id', $reactieId, PDO::PARAM_INT);
$verwijderStatement->bindParam(':post_id', $postId, PDO::PARAM_INT);
$verwijderStatement->execute();

// Terugkeren naar de pagina met de post
header("Location: index.php#post-$postId");
exit();
?>
