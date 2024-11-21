<?php
include '../config.php'; // Make sure to include your database connection

if (isset($_GET['id'])) {
    $movieId = intval($_GET['id']);
    $sql = "DELETE FROM users WHERE user_id = $movieId";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['message' => 'User deleted successfully!']);
    } else {
        echo json_encode(['message' => 'Error deleting User.']);
    }
} else {
    echo json_encode(['message' => 'User ID not provided.']);
}
?>