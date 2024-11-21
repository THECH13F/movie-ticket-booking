<?php
include '../config.php'; // Make sure to include your database connection

if (isset($_GET['id'])) {
    $theaterId = intval($_GET['id']);
    $sql = "DELETE FROM tbl_shows WHERE show_id = $theaterId";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['message' => 'Show deleted successfully!']);
    } else {
        echo json_encode(['message' => 'Error deleting show.']);
    }
} else {
    echo json_encode(['message' => 'show ID not provided.']);
}
?>