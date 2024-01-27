<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $size = $_POST['size'];
    $dish_id = $_POST['dish_id'];

    $db = new mysqli('localhost', 'root', '', 'ph_db');
    $sql = "INSERT INTO bag (size, dish_id) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('si', $size, $dish_id);
    $stmt->execute();

    // Redirect to a success page or show a success message
    header('Location: success.php');
    exit();
}
?>