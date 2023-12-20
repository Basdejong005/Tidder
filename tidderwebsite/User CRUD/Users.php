<?php

require_once "../config.php";

class Users
{
    // properties
    public $id;
    public $gebruikersnaam;
    public $email;
    public $wachtwoord;
    private $conn;

    // constructor
    function __construct($conn, $id = NULL, $gebruikersnaam = NULL, $email = NULL, $wachtwoord = NULL)
    {
        $this->conn = $conn;
        $this->id = $id;
        $this->gebruikersnaam = $gebruikersnaam;
        $this->email = $email;
        $this->wachtwoord = $wachtwoord;
    }

    // setters
    function set_id($id)
    {
        $this->id = $id;
    }

    function set_gebruikersnaam($gebruikersnaam)
    {
        $this->gebruikersnaam = $gebruikersnaam;
    }

    function set_email($email)
    {
        $this->email = $email;
    }

    function set_wachtwoord($wachtwoord)
    {
        $this->wachtwoord = $wachtwoord;
    }

    // getters
    function get_id()
    {
        return $this->id;
    }

    function get_gebruikersnaam()
    {
        return $this->gebruikersnaam;
    }

    function get_email()
    {
        return $this->email;
    }

    function get_wachtwoord()
    {
        return $this->wachtwoord;
    }

    // functies voor CRUD

    public function afdrukken()
    {
        echo "users id: " . $this->get_id() . "<br/>";
        echo "users gebruikersnaam: " . $this->get_gebruikersnaam() . "<br/>";
        echo "users email: " . $this->get_email() . "<br/>";
        echo "users wachtwoord: " . $this->get_wachtwoord() . "<br/>";
    }

    // create users
    // create users
    public function createUsers($gebruikersnaam, $wachtwoord, $email)
    {
        $id = $this->get_id();
        $this->set_gebruikersnaam($gebruikersnaam);
        $this->set_email($email);
        $this->set_wachtwoord($wachtwoord);

        $sql = $this->conn->prepare("INSERT INTO users (id, gebruikersnaam, email, wachtwoord) VALUES (?, ?, ?, ?)");
        $sql->bindParam(1, $id);
        $sql->bindParam(2, $gebruikersnaam);
        $sql->bindParam(3, $email);
        $sql->bindParam(4, $wachtwoord);
        $sql->execute();

        echo "De gebruiker is toegevoegd";
    }


    // read users
    public function readUsers()
    {
        $sql = $this->conn->prepare("SELECT * FROM users");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            echo "users id: " . $row["id"] . " - ";
            echo "users gebruikersnaam: " . $row["gebruikersnaam"] . " - ";
            echo "users email: " . $row["email"] . " - ";
            echo "users wachtwoord: " . $row["wachtwoord"] . "<br>";
        }
    }

    public function searchUsers($gebruikersnaam)
    {
        $sql = $this->conn->prepare("SELECT * FROM users WHERE gebruikersnaam = ?");
        $sql->bindParam(1, $gebruikersnaam);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $this->set_id($result['id']);
            $this->set_gebruikersnaam($result['gebruikersnaam']);
            $this->set_email($result['email']);
            $this->set_wachtwoord($result['wachtwoord']);
        } else {
            echo "Gebruiker niet gevonden.";
        }
    }


    // update users
    public function updateUsers($id)
    {
        $nieuweGebruikersnaam = $this->get_gebruikersnaam();
        $nieuwEmail = $this->get_email();
        $nieuwWachtwoord = $this->get_wachtwoord();

        $sql = $this->conn->prepare("UPDATE users SET gebruikersnaam = ?, email = ?, wachtwoord = ? WHERE id = ?");
        $sql->bindParam(1, $nieuweGebruikersnaam);
        $sql->bindParam(2, $nieuwEmail);
        $sql->bindParam(3, $nieuwWachtwoord);
        $sql->bindParam(4, $id);
        $sql->execute();

        echo "Gebruiker is bijgewerkt";
    }

    // delete users
    public function deleteUsers($id)
    {
        $sql = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $sql->bindParam(1, $id);
        $sql->execute();

        echo "Gebruiker is verwijderd";
    }
}
?>
