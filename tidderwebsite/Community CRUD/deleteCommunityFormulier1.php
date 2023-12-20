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

// Maak een instantie van de Community-klasse
$community = new Community($conn);

// Controleren of de community-id is ingesteld
if (isset($_GET['community_id'])) {
    $community_id = $_GET['community_id'];

    // Query om de communitygegevens op te halen
    $query = "SELECT * FROM communities WHERE id = :community_id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':community_id', $community_id);
    $stmt->execute();

    // Controleren of de community bestaat
    if ($stmt->rowCount() == 1) {
        $community_data = $stmt->fetch();

        // Controleren of de huidige gebruiker de eigenaar is van de community
        if ($community_data['gebruikersnaam'] == $_SESSION['gebruikersnaam']) {
            // Gebruiker is de eigenaar van de community, dus de community kan worden verwijderd
            if (isset($_POST['confirm_delete'])) {
                // Verwijder de community
                $community->deleteCommunity($community_id);

                // Redirect naar de hoofdpagina
                header("Location: ../index.php");
                exit();
            } else {
                // Toon de bevestigingspagina
                include('deleteCommunityFormulier2.php');
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
    header("Location: ../index.php");
    exit();
}
?>
