<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valideer en sanitize de input
    $post_id = $_POST['post_id'];
    $reactie = $_POST['reactie'];

    // Valideer de input (voer aanvullende validatie uit naar gelang uw vereisten)
    if (empty($reactie)) {
        $foutmelding = "Reactie is verplicht.";
    } else {
        // Maak verbinding met de database
        require_once('config.php');

        try {
            // Voeg de reactie toe aan de 'reacties' tabel
            $gebruikersnaam = isset($_SESSION['gebruikersnaam']) ? $_SESSION['gebruikersnaam'] : "";
            $query = "INSERT INTO reacties (post_id, reactie, gebruikersnaam) VALUES (?, ?, ?)";
            $statement = $conn->prepare($query);
            $statement->execute([$post_id, $reactie, $gebruikersnaam]);

            // Stuur door naar de hoofdpagina
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            $foutmelding = "Er is een fout opgetreden bij het toevoegen van de reactie: " . $e->getMessage();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
```