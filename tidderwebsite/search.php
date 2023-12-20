<?php
require_once('config.php');
require_once('Community CRUD/Community.php');
require_once('Posts CRUD/PostCRUD.php');
require_once('User CRUD/Users.php');

// Controleren of er een zoekterm is ingevoerd
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $searchTerm = $_GET['query'];

    // Databaseverbinding
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Zoeken naar communities
    $community = new Community($conn);
    $communityResultaten = $community->searchCommunities($searchTerm);

    // Zoeken naar posts
    $postCRUD = new PostCRUD($conn);
    $postResultaten = $postCRUD->searchPosts($searchTerm);

    // Zoeken naar gebruikers
    $users = new Users($conn);
    $userResultaten = $users->searchUsers($searchTerm);

    // Resultaten weergeven
    echo "<h2>Community resultaten:</h2>";
    foreach ($communityResultaten as $community) {
        echo "<p>".$community->getTitle()."</p>";
    }

    echo "<h2>Post resultaten:</h2>";
    foreach ($postResultaten as $post) {
        echo "<p>".$post->getTitle()."</p>";
    }

    echo "<h2>Gebruiker resultaten:</h2>";
    foreach ($userResultaten as $user) {
        echo "<p>".$user->getUsername()."</p>";
    }
}
