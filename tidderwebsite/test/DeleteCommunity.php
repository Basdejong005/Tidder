<?php
session_start();

require_once('config.php');
require_once('Community.php');

// Controleren of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// Controleren of de community-id is ingesteld
if (isset($_GET['community_id'])) {
    $community_id = $_GET['community_id'];

    // Query om de communitygegevens op te halen
    $query = "SELECT * FROM communities WHERE id = $community_id";
    $resultaat = mysqli_query($verbinding, $query);

    // Controleren of de community bestaat
    if (mysqli_num_rows($resultaat) == 1) {
        $community = mysqli_fetch_assoc($resultaat);

        // Controleren of de huidige gebruiker de eigenaar is van de community
        if ($community['gebruikersnaam'] == $_SESSION['gebruikersnaam']) {
            // Gebruiker is de eigenaar van de community, dus de community kan worden verwijderd
            if (isset($_POST['delete_community'])) {
                $community_naam = $community['community_naam'];
                $gebruikersnaam = $_SESSION['gebruikersnaam'];

                $community = new Community($community_naam, $gebruikersnaam, $verbinding);
                $community->performCrudOperation();

                // Redirect naar de hoofdpagina na het verwijderen van de community
                header("Location: index.php");
                exit();
            }
        } else {
            // Gebruiker is niet de eigenaar van de community, redirect naar de hoofdpagina
            header("Location: index.php");
            exit();
        }
    } else {
        // Community bestaat niet, redirect naar de hoofdpagina
        header("Location: index.php");
        exit();
    }
} else {
    // Community-id is niet ingesteld, redirect naar de hoofdpagina
    header("Location: index.php");
    exit();
}

mysqli_close($verbinding);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Community verwijderen</title>
</head>
<body>
<h1>Community verwijderen</h1>

<p>Weet je zeker dat je de community wilt verwijderen?</p>

<form method="post" action="">
    <input type="submit" name="delete_community" value="Community verwijderen">
</form>
</body>
</html>

