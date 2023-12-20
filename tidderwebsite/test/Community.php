<?php

class Community {
    private $community_naam;
    private $gebruikersnaam;
    private $verbinding;

    public function __construct($community_naam, $gebruikersnaam, $verbinding) {
        $this->community_naam = $community_naam;
        $this->gebruikersnaam = $gebruikersnaam;
        $this->verbinding = $verbinding;
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

    // CRUD functie (afgedrukt voor demonstratiedoeleinden)
    public function performCrudOperation() {
        echo "Community naam: " . $this->community_naam . "<br>";
        echo "Gebruikersnaam: " . $this->gebruikersnaam . "<br>";

        // Create
        $query = "INSERT INTO communities (community_naam, gebruikersnaam) VALUES ('$this->community_naam', '$this->gebruikersnaam')";
        mysqli_query($this->verbinding, $query);
        echo "Community aangemaakt<br>";

        // Read
        $query = "SELECT * FROM communities";
        $result = mysqli_query($this->verbinding, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Community ID: " . $row['community_id'] . ", Naam: " . $row['community_naam'] . ", Gebruikersnaam: " . $row['gebruikersnaam'] . "<br>";
        }

        // Update
        $newCommunityNaam = "Nieuwe community naam";
        $query = "UPDATE communities SET community_naam = '$newCommunityNaam' WHERE gebruikersnaam = '$this->gebruikersnaam'";
        mysqli_query($this->verbinding, $query);
        echo "Community bijgewerkt<br>";

        // Delete
        $query = "DELETE FROM communities WHERE gebruikersnaam = '$this->gebruikersnaam'";
        mysqli_query($this->verbinding, $query);
        echo "Community verwijderd<br>";
    }
}