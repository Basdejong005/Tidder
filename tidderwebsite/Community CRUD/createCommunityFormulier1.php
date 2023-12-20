
<!DOCTYPE html>
<html>

<head>
    <title>Community aanmaken</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
<div class="my-community-form">
    <h1>Community aanmaken</h1>

    <form method="post" action="createCommunityFormulier2.php">
        <label for="community_naam">Community naam:</label>
        <input type="text" name="community_naam" id="community_naam" required><br><br>

        <input type="submit" name="create_community" value="Community aanmaken">
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
