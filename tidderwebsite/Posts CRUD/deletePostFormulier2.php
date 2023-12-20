<!DOCTYPE html>
<html>
<head>
    <title>Verwijder Post</title>
    <script>
        function bevestigVerwijderen() {
            var bevestigen = confirm("Weet je zeker dat je deze post wilt verwijderen?");
            if (bevestigen) {
                // Als de gebruiker bevestigt, de post verwijderen
                window.location.href = "deletePostFormulier1.php?post_id=<?php echo $postId; ?>";
            } else {
                // Als de gebruiker annuleert, terugkeren naar de indexpagina
                window.location.href = "index.php";
            }
        }
    </script>
</head>
<body>
<h1>Verwijder Post</h1>
<p>Weet je zeker dat je deze post wilt verwijderen?</p>
<button onclick="bevestigVerwijderen()">Verwijderen</button>
<button onclick="window.location.href = 'index.php'">Annuleren</button>
</body>
</html>
