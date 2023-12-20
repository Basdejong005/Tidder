<?php

session_start();

require_once('config.php');
require_once('Community.php');

if (isset($_POST['create_community'])) {
    $community_naam = $_POST['community_naam'];
    $gebruikersnaam = $_SESSION['gebruikersnaam']; // Gebruikersnaam van de ingelogde gebruiker

    $community = new Community($community_naam, $gebruikersnaam, $verbinding);
    $community->performCrudOperation();

    mysqli_close($verbinding);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Community aanmaken</title>
</head>
<body>
<h1>Community aanmaken</h1>

<form method="post" action="">
    <label for="community_naam">Community naam:</label>
    <input type="text" name="community_naam" id="community_naam" required><br><br>

    <input type="submit" name="create_community" value="Community aanmaken">
</form>
</body>
</html>

