<?php
include 'config.php';
$screen_id = 1; // Example screen ID

$sql = "SELECT * FROM seats WHERE screen_id = $screen_id";
$result = $conn->query($sql);
$output = '';

while ($row = $result->fetch_assoc()) {
    $class = $row['status'] === 'booked' ? 'seat booked' : 'seat available';
    $output .= "<div class='seat $class' data-seat-id='{$row['seat_id']}'>{$row['row']}{$row['number']}</div>";
}

echo $output;
?>
