<?php
include 'config.php';
$user_id = 1; // Replace with logged-in user's ID
$seat_ids = $_POST['seat_ids'];

foreach ($seat_ids as $seat_id) {
    $sql = "INSERT INTO bookings (user_id, screen_id, seat_id) VALUES ($user_id, 1, $seat_id)";
    $conn->query($sql);
    $updateSeat = "UPDATE seats SET status = 'booked' WHERE seat_id = $seat_id";
    $conn->query($updateSeat);
}

echo "Booking successful!";
?>
