<?php
require "../config.php";

class PostCRUD {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createPost($titel, $bericht, $afbeelding, $community_id, $gebruikersnaam) {
        $query = "INSERT INTO posts (titel, bericht, afbeelding, community_id, gebruikersnaam)
                  VALUES (:titel, :bericht, :afbeelding, :community_id, :gebruikersnaam)";

        $statement = $this->conn->prepare($query);
        $statement->bindParam(':titel', $titel);
        $statement->bindParam(':bericht', $bericht);
        $statement->bindParam(':afbeelding', $afbeelding);
        $statement->bindParam(':community_id', $community_id);
        $statement->bindParam(':gebruikersnaam', $gebruikersnaam);

        if ($statement->execute()) {
            return true;
        } else {
            throw new Exception("Fout bij het maken van de post: " . $statement->error);
        }
    }

    public function readPost($id) {
        $query = "SELECT * FROM posts WHERE id = :id";

        $statement = $this->conn->prepare($query);
        $statement->bindParam(':id', $id);

        if ($statement->execute()) {
            return $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("Fout bij het ophalen van de post: " . $statement->error);
        }
    }


    public function updatePost($id, $titel, $bericht, $afbeelding, $community_id, $gebruikersnaam) {
        $query = "UPDATE posts SET titel = :titel, bericht = :bericht, afbeelding = :afbeelding,
                  community_id = :community_id, gebruikersnaam = :gebruikersnaam WHERE id = :id";

        $statement = $this->conn->prepare($query);
        $statement->bindParam(':titel', $titel);
        $statement->bindParam(':bericht', $bericht);
        $statement->bindParam(':afbeelding', $afbeelding);
        $statement->bindParam(':community_id', $community_id);
        $statement->bindParam(':gebruikersnaam', $gebruikersnaam);
        $statement->bindParam(':id', $id);

        if ($statement->execute()) {
            return true;
        } else {
            throw new Exception("Fout bij het bijwerken van de post: " . $statement->error);
        }
    }

    public function deletePost($id) {
        $query = "DELETE FROM posts WHERE id = :id";

        $statement = $this->conn->prepare($query);
        $statement->bindParam(':id', $id);

        if ($statement->execute()) {
            return true;
        } else {
            throw new Exception("Fout bij het verwijderen van de post: " . $statement->error);
        }
    }

    public function searchPosts($search_term) {
        $query = "SELECT * FROM posts WHERE titel LIKE :search_term OR bericht LIKE :search_term";

        $statement = $this->conn->prepare($query);
        $search_term = "%" . $search_term . "%";
        $statement->bindParam(':search_term', $search_term);

        if ($statement->execute()) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("Fout bij het uitvoeren van de zoekopdracht: " . $statement->error);
        }
    }
}

// Gebruik van de PostCRUD-klasse met de PDO-verbinding
$postCRUD = new PostCRUD($conn);

