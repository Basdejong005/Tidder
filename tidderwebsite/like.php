<?php
session_start();

// Controleren of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// Verbinding maken met de database
require_once('config.php');

// Controleer of het formulier is ingediend en verwerk de like/unlike
if (isset($_POST['like'])) {
    $post_id = $_POST['post_id'];
    $gebruikersnaam = $_SESSION['gebruikersnaam'];

    // Controleer of de gebruiker de post al heeft geliked
    $query = "SELECT * FROM likes WHERE post_id = :post_id AND gebruikersnaam = :gebruikersnaam";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        // Gebruiker heeft de post nog niet geliked, voeg de like toe aan de database
        $query = "INSERT INTO likes (post_id, gebruikersnaam) VALUES (:post_id, :gebruikersnaam)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
        $stmt->execute();

        // Update de sessievariabele om aan te geven dat de gebruiker de post heeft geliked
        $_SESSION['liked_by_user'][$post_id] = true;
    } else {
        // Gebruiker heeft de post al geliked, verwijder de like uit de database (unlike)
        $query = "DELETE FROM likes WHERE post_id = :post_id AND gebruikersnaam = :gebruikersnaam";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
        $stmt->execute();

        // Update de sessievariabele om aan te geven dat de gebruiker de post heeft unliked
        unset($_SESSION['liked_by_user'][$post_id]);
    }

    // Update het aantal likes voor de post in de "posts" tabel
    $query = "UPDATE posts SET likes_count = (SELECT COUNT(*) FROM likes WHERE post_id = :post_id) WHERE id = :post_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->execute();
}

// Sluit de databaseverbinding
$conn = null;

// Stuur de gebruiker terug naar de vorige pagina
header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
?>
