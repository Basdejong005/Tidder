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

// Controleren of de post_id is opgegeven in de querystring
if (!isset($_GET['post_id'])) {
    header("Location: ../index.php");
    exit();
}

// Postgegevens ophalen uit de database op basis van de post_id
$postId = $_GET['post_id'];
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
?>



<!DOCTYPE html>
<html>
<head>
    <title>Post bijwerken</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<form id="update-form" method="post" action="updatePostFormulier2.php" enctype="multipart/form-data">
    <h1>Post bijwerken</h1>

    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">

    <label for="titel">Titel:</label>
    <input type="text" name="titel" id="titel" value="<?php echo $post['titel']; ?>" required><br><br>

    <label for="bericht">Bericht:</label><br>
    <textarea name="bericht" id="bericht" rows="4" cols="50" required><?php echo $post['bericht']; ?></textarea><br><br>

    <label for="afbeelding">Huidige afbeelding:</label>
    <br>
    <?php if (!empty($post['afbeelding'])) : ?>
        <img src="<?php echo $post['afbeelding']; ?>" alt="Huidige afbeelding">
        <br><br>
    <?php endif; ?>

    <label for="nieuwe_afbeelding">Nieuwe afbeelding:</label>
    <input type="file" name="afbeelding" id="nieuwe_afbeelding"><br><br>

    <input type="submit" name="update_post" value="Post bijwerken">
</form>
<button class="terugknop" onclick="goBack()">Terug</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>

