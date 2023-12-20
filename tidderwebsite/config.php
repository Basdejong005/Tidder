<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');



$servername = "localhost";
$dbname = "tidderwebsite";
$username = "root";
$password = "root";

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username , $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "";

}catch(PDOException $e){
    echo "de connectie is mislukt" . $e->getMessage();
}
?>

