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


$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post maken</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<form class="create-form" method="post" action="CreatePostFormulier2.php" enctype="multipart/form-data">
    <h1>Post maken</h1>
    <?php if (isset($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <label for="titel">Titel:</label>
    <input type="text" name="titel" id="titel" required><br><br>

    <label for="bericht">Bericht:</label><br>
    <textarea name="bericht" id="bericht" rows="4" cols="50" required></textarea><br><br>

    <label for="afbeelding">Afbeelding of video:</label>
    <input type="file" name="afbeelding" id="afbeelding"><br><br>

    <label for="community_id">Community:</label>
    <select name="community_id" id="community_id" required>
        <?php foreach ($resultaat as $rij): ?>
            <option value="<?php echo $rij['id']; ?>"><?php echo $rij['community_naam']; ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" name="create_post" value="Post maken">
</form>
<button class="terugknop" onclick="goBack()">Terug</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
