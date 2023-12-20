<!DOCTYPE html>
<html>
<head>
    <title>Bevestiging</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<div class="mijn-formulier">
<h1>Weet je zeker dat je de community wilt verwijderen?</h1>

<form method="post" action="deleteCommunityFormulier1.php?community_id=<?php echo $community_id; ?>">
    <input type="submit" name="confirm_delete" value="Ja, verwijder de community">
</form>
</div>
<button class="terugknop" onclick="goBack()">Terug</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
