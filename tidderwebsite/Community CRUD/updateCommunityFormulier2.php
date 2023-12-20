<?php
session_start();

// Controleren of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: ../login.php");
    exit();
}

// Verbinding maken met de database
require_once('../config.php');
require_once('Community.php');

// Maak een instantie van de Community-klasse en geef de databaseverbinding door

$community = new Community($conn);

// Controleren of de community-id is ingesteld
if (isset($_GET['community_id'])) {
    $community_id = $_GET['community_id'];

    // Query om de communitygegevens op te halen
    $query = "SELECT * FROM communities WHERE id = :community_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':community_id', $community_id);
    $stmt->execute();

    // Controleren of de community bestaat
    if ($stmt->rowCount() == 1) {
        $communityData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Controleren of de huidige gebruiker de eigenaar is van de community
        if ($communityData['gebruikersnaam'] == $_SESSION['gebruikersnaam']) {
            // Gebruiker is de eigenaar van de community
            if (isset($_POST['update_community'])) {
                $nieuwe_naam = $_POST['nieuwe_naam'];

                // Community-klasse gebruiken om de community bij te werken
                $community->updateCommunity($community_id, $nieuwe_naam);

                // Redirect naar de hoofdpagina na het updaten van de community
                header("Location: ../index.php");
                exit();
            }
        } else {
            // Gebruiker is niet de eigenaar van de community, redirect naar de hoofdpagina
            header("Location: ../index.php");
            exit();
        }
    } else {
        // Community bestaat niet, redirect naar de hoofdpagina
        header("Location: ../index.php");
        exit();
    }
} else {
    // Community-id is niet ingesteld, redirect naar de hoofdpagina
    header("Location:../index.php");
    exit();
}

// Sluit de databaseverbinding
$conn = null;
?>
