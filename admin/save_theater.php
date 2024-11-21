<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theater_id = isset($_POST['theater_id']) ? $_POST['theater_id'] : '';
    $theater_name = $_POST['theater_name'];
    $theater_location = $_POST['theater_location'];
    $Cancellation = $_POST['Cancellation'];
    $Food_Beverage = $_POST['Food_Beverage'];
    $M_Ticket = $_POST['M_Ticket'];

    if ($theater_id) {
        // Update existing theater
            $sql = "UPDATE theater SET theater_name='$theater_name', theater_location='$theater_location', Food_Beverage='$Food_Beverage', M_Ticket='$M_Ticket' WHERE theater_id='$theater_id'";
    } else {
        // Insert new theater
        $sql = "INSERT INTO theater (theater_name, theater_location, Cancellation, Food_Beverage, M_Ticket) VALUES ('$theater_name', '$theater_location', '$Cancellation', '$Food_Beverage', '$M_Ticket')";
    }

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['message' => 'theater saved successfully!']);
    } else {
        echo json_encode(['message' => 'Error saving theater: ' . mysqli_error($conn)]);
    }
}
?>
