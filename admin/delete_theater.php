<?php
include '../config.php'; // Make sure to include your database connection

if (isset($_GET['id'])) {
    $theaterId = intval($_GET['id']);
    $sql = "DELETE FROM theater WHERE theater_id = $theaterId";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['message' => 'theater deleted successfully!']);
    } else {
        echo json_encode(['message' => 'Error deleting theater.']);
    }
} else {
    echo json_encode(['message' => 'theater ID not provided.']);
}
?>