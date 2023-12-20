<?php
session_start();

if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: ../login.php");
    exit();
}

require_once('../config.php');
require_once('PostCRUD.php');

$query = "SELECT * FROM communities";
$statement = $conn->prepare($query);
$statement->execute();
$resultaat = $statement->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['create_post'])) {
    $titel = $_POST['titel'];
    $bericht = $_POST['bericht'];
    $community_id = $_POST['community_id'];
    $gebruikersnaam = $_SESSION['gebruikersnaam'];

    // Controleer of de titel leeg is
    if (empty($titel)) {
        $error = "Titel is verplicht";
    } else {
        $afbeelding = '';

        if ($_FILES['afbeelding']['error'] === 0) {
            $targetDir = 'uploads/';
            $targetFile = $targetDir . basename($_FILES['afbeelding']['name']);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            $isImage = getimagesize($_FILES['afbeelding']['tmp_name']);
            $isVideo = $imageFileType === 'mp4';

            if ($isImage || $isVideo) {
                if (move_uploaded_file($_FILES['afbeelding']['tmp_name'], $targetFile)) {
                    $afbeelding = $targetFile;
                }
            }
        }

        $postCRUD = new PostCRUD($conn);
        $postCRUD->createPost($titel, $bericht, $afbeelding, $community_id, $gebruikersnaam);

        header("Location: ../index.php");
        exit();
    }
}

$conn = null;
?>
