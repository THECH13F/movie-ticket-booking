<?php
session_start(); // Start the session

include 'config.php'; // Include the configuration file
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}
// Handle deletion
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteTicket'])) {
//     $deleteIndex = $_POST['deleteIndex'];
//     if (isset($orders[$deleteIndex])) {
//         unset($orders[$deleteIndex]); // Remove the selected ticket
//         $_SESSION['orders'] = array_values($orders); // Re-index array
//     }
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: linear-gradient(to right,#6a11cb,#2575fc);
            color:#ffffff;
            font-family: Arial, sans-serif;
            min: height 100vh;
            display: flex;
            align-items:center;
            justify-content: center;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 700px;
            margin-top: 50px;
            color:#333;
        }
        .card {
            background-color: #f0f4f8;
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.02);
        }
        .btn-delete {
            background-color: #ff6b6b;
            color: white;
            border:none;
            padding:6px 12px;
            border-radius:5px;
        }
        .btn-share {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            width: 100%;
        }
        .btn-share:hover, .btn-delete:hover {
            opacity: 0.9;
        }
        .form-check-input:checked {
            background-color: #6a11cb;
            border-color: #6a11cb;
        }
    </style>
</head>
<body class='bg-dark'>
<div class="container text-center">
    <h2 class="mb-4">Your Booking Details</h2>
    <?php
    $sql="SELECT 
    users.user_name AS user_name,
    movies.movie_name AS movie_name,
    theater.theater_name AS theater_name,
    theater.theater_location AS theater_location,
    tbl_shows.time,
    booking.silver_seat_no,
    booking.gold_seat_no,
    booking.booking_id,
    booking.payment
FROM 
    booking
JOIN 
    tbl_shows ON booking.booking_show = tbl_shows.show_id
JOIN 
    movies ON tbl_shows.movie_id = movies.movie_id
JOIN 
    theater ON tbl_shows.theater_id = theater.theater_id
JOIN 
    users ON booking.booking_user = users.user_id
where booking.booking_user='".$_SESSION['user_id']."'"; 
$result = mysqli_query($conn, $sql);
// echo $result;
if (mysqli_num_rows($result) > 0){
        echo "<form id='ticketForm' method='POST'>";
            echo "<div class='alert alert-info'>";
                echo "<h5>Your bookings:</h5>";
                while ($row = mysqli_fetch_assoc($result)) {
                    $selectedSeats = $row['silver_seat_no']." , ".$row['gold_seat_no'];
                    echo "<div class='card p-3'>";
                        echo "<div class='form-check'>";
                        echo "<input class='form-check-input' type='checkbox' name='selectedOrders[]' value='".$row['booking_id']." id='order-".$row['booking_id']."'>";
                        echo "<label class='form-check-label' for='order-".$row['booking_id'].">";
                        echo "<h5>Booking ID".$row['booking_id']."</h5>";
                        echo "</label>";
                        echo "</div>";
                        echo "<div class='card-body'>";
                        echo "<p><strong>Theater:</strong>".$row['theater_name']." : ".$row['theater_location']."</p>";
                        echo "<p><strong>Movie:</strong>".$row['movie_name']."</p>";
                        echo "<p><strong>Your seats:</strong>".$selectedSeats."</p>";
                        echo "<p><strong>Payment method ending with:</strong>".$row['payment']. "</p>";
                        // echo "<form action='orders.php' method='POST' style='display:inline;' onsubmit='return confirm('Are you sure you want to delete this booking?');'>";
                        // echo "<input type='hidden' name='deleteIndex' value='".$row['booking_id']."'>";
                        // echo "<button type='submit' name='deleteTicket' class='btn btn-delete btn-sm mt-3'>Delete</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                }
                echo "</div>";

            echo "<button type='button' class='btn btn-share mt-4' onclick='shareSelected()'>Share via WhatsApp</button>";
            echo "</form>";
            }
else{
    echo "<div class='alert alert-warning'>";
    echo "<h5>No bookings found.</h5>";
    echo "</div>";

}
?>

    <a href="index.php" class="btn btn-primary mt-4">Back to Home</a>
</div>

<script>
function shareSelected() {
    const selectedOrders = Array.from(document.querySelectorAll('input[name="selectedOrders[]"]:checked'))
        .map(input => input.value);

    if (selectedOrders.length === 0) {
        alert('Please select at least one booking to share.');
        return;
    }

    // Create WhatsApp message based on selected orders
    let message = "Here are your booking details:\n";
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    if (selectedOrders.includes("<?php echo $row['booking_id']; ?>")) {
        $selectedSeats = $row['silver_seat_no']." , ".$row['gold_seat_no'];
        message += "Booking <?php echo $row['booking_id'] + 1; ?>: Theater - <?php echo $row['theater_name']." : ".$row['theater_location']; ?>, Movie - <?php echo $row['movie_name']; ?>, Seats - <?php echo $selectedSeats; ?>, Payment ending with <?php echo $$row['payment']; ?>\n";
    }
    <?php endwhile; ?>

    const whatsappUrl = "https://wa.me/?text=" + encodeURIComponent(message);
    window.open(whatsappUrl, "_blank");
}
</script>
</body>
</html>
