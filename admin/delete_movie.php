<?php
include '../config.php'; // Make sure to include your database connection

if (isset($_GET['id'])) {
    $movieId = intval($_GET['id']);
    $sql = "DELETE FROM movies WHERE movie_id = $movieId";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['message' => 'Movie deleted successfully!']);
    } else {
        echo json_encode(['message' => 'Error deleting movie.']);
    }
} else {
    echo json_encode(['message' => 'Movie ID not provided.']);
}
?>