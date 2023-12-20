<?php
session_start();

// Controleren of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: ../login.php");
    exit();
}

// Verbinding maken met de database
require_once('../config.php');
require_once('PostCRUD.php');

// Controleren of het bijgewerkte formulier is ingediend
if (isset($_POST['update_post'])) {
    $postId = $_POST['post_id'];
    $titel = $_POST['titel'];
    $bericht = $_POST['bericht'];

    // Postgegevens ophalen uit de database op basis van de post_id
    $query = "SELECT * FROM posts WHERE id = :postId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':postId', $postId);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Controleren of de post behoort tot de ingelogde gebruiker
    if ($post['gebruikersnaam'] !== $_SESSION['gebruikersnaam']) {
        header("Location: ../index.php");
        exit();
    }

    // Controleer of er een nieuwe afbeelding is geüpload
    if (!empty($_FILES['afbeelding']['name'])) {
        $afbeelding = $_FILES['afbeelding'];

        // Afbeelding uploaden
        $targetDir = 'uploads/';
        $targetFile = $targetDir . basename($afbeelding['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Controleer of het een geldige afbeelding is
        $isImage = getimagesize($afbeelding['tmp_name']);
        $isVideo = $imageFileType === 'mp4';

        if ($isImage || $isVideo) {
            if (move_uploaded_file($afbeelding['tmp_name'], $targetFile)) {
                // Afbeelding succesvol geüpload, update de bestandsnaam in de database
                $bestandsnaam = $targetFile;
            }
        }
    } else {
        // Geen nieuwe afbeelding geüpload, behoud de oorspronkelijke afbeelding
        $bestandsnaam = $post['afbeelding'];
    }

    // Instantieer een object van de PostCRUD-klasse
    $postCRUD = new PostCRUD($conn);

    // Roep de updatePost-methode aan om de post bij te werken
    $postCRUD->updatePost($postId, $titel, $bericht, $bestandsnaam, $post['community_id'], $_SESSION['gebruikersnaam']);

    // Redirect naar de hoofdpagina na het bijwerken van de post
    header("Location: ../index.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
