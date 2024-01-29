<?php
session_start(); // Start the session
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ph_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_btn"])) {


    $dish_id = $_POST['dish_id']; 
    $new_quantity = $_POST['qty'];


    $sql = "UPDATE cart SET qty = :new_quantity WHERE dish_id = :dish_id";
    

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':new_quantity', $new_quantity, PDO::PARAM_INT);
    $stmt->bindParam(':dish_id', $dish_id, PDO::PARAM_INT);

    // Execute the update query
    $stmt->execute();


    header("Location: redirect_back.php");
    exit();
}
?>