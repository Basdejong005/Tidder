<?php
session_start();

// Sessie vernietigen en uitloggen
session_destroy();

// Terug naar de hoofdpagina
header("Location: index.php");
exit();
?>

