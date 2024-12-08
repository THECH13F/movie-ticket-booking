<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = md5($_POST['user_password']);
    $user_phone = $_POST['user_phone'];
    $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : 'user';

    if ($user_id) {
        // Update existing user
        if (!empty($user_password)) {
            $sql = "UPDATE users SET user_name='$user_name', user_email='$user_email', user_password='$user_password', user_phone='$user_phone', user_type='$user_type' WHERE user_id='$user_id'";
        } else {
            $sql = "UPDATE users SET user_name='$user_name', user_email='$user_email', user_phone='$user_phone', user_type='$user_type' WHERE user_id='$user_id'";
        }
    } else {
        // Insert new user
        $sql = "INSERT INTO users (user_name, user_email, user_password, user_phone, user_type) VALUES ('$user_name', '$user_email', '$user_password', '$user_phone', '$user_type')";
    }

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['message' => 'User saved successfully!']);
    } else {
        echo json_encode(['message' => 'Error saving user: ' . mysqli_error($conn)]);
    }
}
?>
