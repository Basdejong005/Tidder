<!DOCTYPE html>
<html>
<head>
    <title>Account Verwijderen</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<div class="mijn-formulier">
    <div class="delete-account-container">
        <h1 class="delete-account-title">Account Verwijderen</h1>
        <p class="delete-account-message">Weet u zeker dat u uw account wilt verwijderen?</p>
        <form method="POST" action="deleteUserFormulier2.php">
            <button type="submit" name="confirm-delete" class="delete-account-button">Bevestigen</button>
        </form>
    </div>
</div>
<button class="terugknop" onclick="goBack()">Terug</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>