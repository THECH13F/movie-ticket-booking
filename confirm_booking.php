

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 500px;
            margin-top: 50px;
        }
        .container h2 {
            color: #28a745;
            font-weight: bold;
            animation: bounce 1s ease infinite alternate;
        }
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        .btn-primary {
            background: linear-gradient(90deg, #ff4757, #ff6b81);
            border: none;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(255, 71, 87, 0.4);
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #ff6b81, #ff4757);
        }
        @keyframes bounce {
            0% { transform: translateY(0); }
            100% { transform: translateY(-10px); }
        }
        .icon-check {
            font-size: 50px;
            color: #28a745;
        }
    </style>
</head>
<body>

    <div class="container text-center">
        <i class="fas fa-check-circle icon-check mb-4"></i>
        <h2 class="mb-4">Booking Confirmed!</h2>
        <a href="orders.php" class="btn btn-primary">View Orders</a>
    </div>
    <?php
        session_start(); // Start the session
        include 'config.php';
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");  // Redirect to login page if not logged in
            exit();
        }
        // Your existing code...

        $selectedSeatsGold = isset($_POST['selectedSeatsGold']) ? htmlspecialchars($_POST['selectedSeatsGold']) : 'No seats selected';
        $selectedSeatsSilver = isset($_POST['selectedSeatsSilver']) ? htmlspecialchars($_POST['selectedSeatsSilver']) : 'No seats selected';
        $cardNumber = isset($_POST['cardNumber']) ? htmlspecialchars($_POST['cardNumber']) : '';
        $upiId = isset($_POST['upiId']) ? htmlspecialchars($_POST['upiId']) : '';
        $show_id = isset($_POST['showId']) ? htmlspecialchars($_POST['showId']) : header("Location: login.php");
        $lastDigits = $cardNumber ? substr($cardNumber, -4) : ($upiId ? 'UPI Payment' : '');
        $oldsql="Select * from tbl_shows where show_id='$show_id'";
        $oldresult=mysqli_query($conn,$oldsql);
        $oldrow=mysqli_fetch_assoc($oldresult);
        $oldSeatsGold=$oldrow['gold_booked'];
        $newSeatsGold=$oldSeatsGold.','.$selectedSeatsGold;
        $oldSeatsSilver=$oldrow['silver_booked'];
        $newSeatsSilver=$oldSeatsSilver.','.$selectedSeatsSilver;
        $updatesql="Update tbl_shows set gold_booked='$newSeatsGold' , silver_booked='$newSeatsSilver' where show_id='$show_id'";
        mysqli_query($conn,$updatesql);
        $sql = "INSERT INTO booking (booking_user, booking_show, silver_seat_no , gold_seat_no , payment) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iisss", $_SESSION['user_id'], $show_id, $selectedSeatsSilver, $selectedSeatsGold, $lastDigits);
        mysqli_stmt_execute($stmt);
        // Initialize orders array in session if not already set

        // header("Location: orders.php");
        // exit();
    ?>
   
</body>
</html>

</html>
