<?php
include '../config.php'; 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM booking WHERE booking_id = $id";
    
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
    mysqli_close($conn);
} else {
    echo "Invalid ID";

}
?>

