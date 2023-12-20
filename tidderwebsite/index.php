<?php
session_start();

// Controleren of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// Verbinding maken met de database
require_once('config.php');


require_once('Community CRUD/Community.php');

// Instantie van Community maken
$community = new Community($conn);

// Communities ophalen
$communities = $community->searchCommunities("");

// Query om alle posts op te halen
$query = "SELECT p.*, c.community_naam, COUNT(l.post_id) AS likes_count FROM posts p JOIN communities c ON p.community_id = c.id LEFT JOIN likes l ON p.id = l.post_id";
$searchTerm = isset($_GET['gebruiker']) ? $_GET['gebruiker'] : "";
$communityId = isset($_GET['community_id']) ? $_GET['community_id'] : null;
if (!empty($searchTerm)) {
    $query .= " JOIN users u ON p.gebruikersnaam = u.gebruikersnaam WHERE (u.gebruikersnaam LIKE '%$searchTerm%' OR p.titel LIKE '%$searchTerm%' OR c.community_naam LIKE '%$searchTerm%')";
} elseif (!empty($communityId)) {
    $query .= " WHERE c.id = $communityId";
}
$query .= " GROUP BY p.id";
$postsResultaat = $conn->query($query);

// Query om alle reacties op te halen
$query = "SELECT * FROM reacties";
$reactiesResultaat = $conn->query($query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Hoofdpagina</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function goToAnchor(anchor, event) {
            event.preventDefault();
            var loc = document.location.toString().split('#')[0];
            document.location = loc + '#' + anchor;
        }

        function restartPage(event) {
            event.preventDefault();
            window.location.href = "index.php";
        }
        function toggleHeart(button) {
            button.classList.add('liked'); // Voeg de klasse 'liked' toe aan de knop
            const heartOverlay = button.querySelector('.heart-overlay');
            heartOverlay.classList.add('show'); // Voeg de klasse 'show' toe aan het overlay-element

            setTimeout(() => {
                button.classList.remove('liked'); // Verwijder de klasse 'liked' van de knop
                heartOverlay.classList.remove('show'); // Verwijder de klasse 'show' van het overlay-element
            }, 1000); // Stel de duur in van hoe lang het hartbeeld in beeld moet blijven (in milliseconden)
        }

    </script>
</head>
<body>
<nav>
    <h1>Tidder</h1>
    <!-- Zoekformulier -->
    <form method="GET" action="index.php" class="nav-search">
        <input type="text" name="gebruiker" placeholder="Zoeken tidder">
        <input type="submit" value="Zoeken">
    </form>
    <ul>
        <li><a <button onclick="restartPage()"><i class="fas fa-home"></i></button></a></li>
        <script>
            function restartPage() {
                window.location.href = "index.php";
            }

        </script>
        <li><a href="User CRUD/profiel.php">Accountgegevens bijwerken</a></li>
        <li><a href="logout.php">Uitloggen</a></li>

    </ul>
</nav>

<div class="sidebar">
    <h2>Communities</h2>
    <ul>
        <?php foreach ($communities as $rij): ?>
            <li>
                <a href="index.php?community_id=<?php echo $rij['id']; ?>&gebruiker=<?php echo urlencode($searchTerm); ?>">
                    <?php echo $rij['community_naam']; ?>
                </a>

                <?php if ($rij['gebruikersnaam'] == $_SESSION['gebruikersnaam']): ?>
                    <div class="button-group">
                        <a href="Community%20CRUD/updateCommunityFormulier1.php?community_id=<?php echo $rij['id']; ?>" class="button">Aanpassen</a>
                        <a href="Community%20CRUD/deleteCommunityFormulier1.php?community_id=<?php echo $rij['id']; ?>" class="button">Verwijderen</a>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="titelpost">
    <h2>Posts</h2>
</div>
<div class="post-container">
    <div class="button-container">
        <a href="Community%20CRUD/createCommunityFormulier1.php" class="button">Community aanmaken</a>
        <a href="Posts%20CRUD/CreatePostFormulier1.php" class="button">Post maken</a>
    </div>

    <?php while ($rij = $postsResultaat->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="post">
            <h3><?php echo $rij['titel']; ?></h3>
            <p><?php echo $rij['bericht']; ?></p>
            <?php if (!empty($rij['afbeelding'])): ?>
                <img src="<?php echo $rij['afbeelding']; ?>" alt="Post afbeelding" style="max-width: 150%;">
            <?php endif; ?>
            <p>Gemaakt door: <?php echo $rij['gebruikersnaam']; ?></p>
            <p>Community: <?php echo $rij['community_naam']; ?></p>
            <p>Likes: <?php echo $rij['likes_count']; ?></p>
            <form method="post" action="like.php">
                <input type="hidden" name="post_id" value="<?php echo $rij['id']; ?>">
                <button type="submit" name="like" class="like-button <?php echo isset($_SESSION['liked_by_user'][$rij['id']]) ? 'liked' : ''; ?>" onclick="toggleHeart(this)">
                    <?php if (isset($_SESSION['liked_by_user'][$rij['id']])): ?>
                        <i class="fas fa-heart"></i>
                        Unlike
                    <?php else: ?>
                        <i class="far fa-heart"></i>
                        Like
                    <?php endif; ?>
                    <span class="heart-overlay"></span>
                </button>
            </form>

            <br/>

            <?php if ($rij['gebruikersnaam'] == $_SESSION['gebruikersnaam']): ?>
                <a href="Posts CRUD/updatePostFormulier1.php?post_id=<?php echo $rij['id']; ?>" class="update-button">Bijwerken</a>
                <a href="Posts CRUD/deletePostFormulier1.php?post_id=<?php echo $rij['id']; ?>" onclick="return bevestigVerwijderen();" class="delete-button">Verwijderen</a>
            <?php endif; ?>
            <h4>Reacties:</h4>

            <button class="button-toggle-comments" onclick="toggleComments(this)">Toon/Verberg reacties</button>

            <div class="comments comments-hidden">
                <?php $reactiesResultaat->execute(); ?>
                <?php while ($reactie = $reactiesResultaat->fetch(PDO::FETCH_ASSOC)): ?>
                    <?php if ($reactie['post_id'] == $rij['id']): ?>
                        <p>
                            <strong><?php echo $reactie['gebruikersnaam']; ?>:</strong>
                            <?php echo $reactie['reactie']; ?>
                            <?php if ($reactie['gebruikersnaam'] == $_SESSION['gebruikersnaam']): ?>
                                <a href="delete_comment.php?reactie_id=<?php echo $reactie['id']; ?>&post_id=<?php echo $rij['id']; ?>" onclick="return confirm('Weet je zeker dat je deze reactie wilt verwijderen?')">Verwijderen</a>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                <?php endwhile; ?>

                <form class="comment-form" method="post" action="add_comment.php">
                    <input type="hidden" name="post_id" value="<?php echo $rij['id']; ?>">
                    <textarea name="reactie" placeholder="Plaats een reactie"></textarea><br>
                    <input type="submit" name="submit" value="Plaats reactie">
                </form>
            </div>
        </div>
    <?php endwhile; ?>

</div>
</body>
</html>