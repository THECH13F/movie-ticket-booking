<?php
include '../config.php'; 

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    $sql = "SELECT * FROM users WHERE user_id = $userId";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    echo json_encode($user);
} else {
    echo json_encode(['error' => 'Movie ID not provided.']);
}
?>