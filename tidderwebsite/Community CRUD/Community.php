<?php

class Community {
    private $conn;
    private $community_naam;
    private $gebruikersnaam;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Setters
    public function setCommunityNaam($community_naam) {
        $this->community_naam = $community_naam;
    }

    public function setGebruikersnaam($gebruikersnaam) {
        $this->gebruikersnaam = $gebruikersnaam;
    }

    // Getters
    public function getCommunityNaam() {
        return $this->community_naam;
    }

    public function getGebruikersnaam() {
        return $this->gebruikersnaam;
    }

    public function createCommunity() {
        // Check if the user is logged in
        if (!isset($_SESSION['gebruikersnaam'])) {
            header("Location: login.php");
            exit();
        }

        $community_naam = $this->getCommunityNaam();
        $gebruikersnaam = $this->getGebruikersnaam();

        // Query to add the community to the database
        $query = "INSERT INTO communities (community_naam, gebruikersnaam) VALUES (?, ?)";
        $statement = $this->conn->prepare($query);
        $statement->execute([$community_naam, $gebruikersnaam]);

        // Redirect to the main page after creating the community
        header("Location: ../index.php");
        exit();
    }

    public function updateCommunity($community_id, $new_community_name) {
        $query = "UPDATE communities SET community_naam = ? WHERE id = ?";
        $statement = $this->conn->prepare($query);
        $statement->execute([$new_community_name, $community_id]);
    }

    public function deleteCommunity($community_id) {
        $query = "DELETE FROM communities WHERE id = ?";
        $statement = $this->conn->prepare($query);
        $statement->execute([$community_id]);
    }

    public function searchCommunities($search_term) {
        $query = "SELECT * FROM communities WHERE community_naam LIKE ?";
        $statement = $this->conn->prepare($query);
        $statement->execute(["%$search_term%"]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function readCommunity($community_id) {
        $query = "SELECT * FROM communities WHERE id = ?";
        $statement = $this->conn->prepare($query);
        $statement->execute([$community_id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}

