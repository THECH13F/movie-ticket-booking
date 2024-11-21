<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $show_id = isset($_POST['show_id']) ? $_POST['show_id'] : '';
    $theater_id = $_POST['theatreName'];
    $movie_id = $_POST['movieName'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $gold_row = $_POST['gold_row'];
    $gold_col = $_POST['gold_col'];
    $gold_price = $_POST['gold_price'];
    $silver_row = $_POST['silver_row'];
    $silver_col = $_POST['silver_col'];
    $silver_price = $_POST['silver_price'];
    $silver_booked = $_POST['silver_booked'];
    $gold_booked = $_POST['gold_booked'];

    if ($show_id) {
        // Update existing show
            $sql = "UPDATE tbl_shows SET theater_id='$theater_id', movie_id='$movie_id', time='$time', date='$date', gold_row='$gold_row', gold_col='$gold_col', gold_price='$gold_price', silver_row='$silver_row', silver_col='$silver_col', silver_price='$silver_price', silver_booked='$silver_booked', gold_booked='$gold_booked' WHERE show_id='$show_id'";
    } else {
        // Insert new show
        $sql = "INSERT INTO tbl_shows (theater_id, movie_id, time, date, gold_row, gold_col, gold_price, silver_row, silver_col, silver_price, silver_booked, gold_booked) VALUES ('$theater_id', '$movie_id', '$time', '$date', '$gold_row', '$gold_col', '$gold_price', '$silver_row', '$silver_col', '$silver_price', '$silver_booked', '$gold_booked')";
    }

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['message' => 'show saved successfully!']);
    } else {
        echo json_encode(['message' => 'Error saving show: ' . mysqli_error($conn)]);
    }
}
?>
