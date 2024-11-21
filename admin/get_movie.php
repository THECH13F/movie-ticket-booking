<?php
include '../config.php'; 

if (isset($_GET['id'])) {
    $movieId = intval($_GET['id']);
    $sql = "SELECT * FROM movies WHERE movie_id = $movieId";
    $result = mysqli_query($conn, $sql);
    $movie = mysqli_fetch_assoc($result);
    echo json_encode($movie);
} else {
    echo json_encode(['error' => 'Movie ID not provided.']);
}
?>