<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 500px;
        }
        h2 {
            color: #343a40;
            font-weight: bold;
        }
        .payment-option {
            display: flex;
            align-items: center;
            margin-top: 20px;
            cursor: pointer;
        }
        .payment-option img {
            width: 30px;
            margin-right: 10px;
        }
        .payment-option.active {
            border: 2px solid #0d6efd;
            border-radius: 8px;
            padding: 10px;
        }
        .qr-code {
            width: 150px;
            height: 150px;
            display: none;
            margin: 0 auto;
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
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Payment</h2>

    <?php
    $selectedSeatsSilver = isset($_POST['selectedSeatsSilver']) ? htmlspecialchars($_POST['selectedSeatsSilver']) : 'No seats selected';
    $selectedSeatsGold = isset($_POST['selectedSeatsGold']) ? htmlspecialchars($_POST['selectedSeatsGold']) : 'No seats selected';
    $totalPrice = isset($_POST['totalPrice']) ? htmlspecialchars($_POST['totalPrice']) : '0';
    $selectedTime = isset($_POST['selectedTime']) ? htmlspecialchars($_POST['selectedTime']) : 'No time selected';
    $show_id = isset($_POST['show_id']) ? htmlspecialchars($_POST['show_id']) : header("Location: login.php");
    $selectedSeats=$selectedSeatsSilver.' , '.$selectedSeatsGold;
    ?>

    <div class="mb-3">
        <h5>Selected Seats:</h5>
        <p><?php echo $selectedSeats ? htmlspecialchars($selectedSeats) : 'No seats selected'; ?></p>
    </div>
    <div class="mb-3">
        <h5>Selected Showtime:</h5>
        <p><?php echo $selectedTime; ?></p>
    </div>
    <div class="mb-3">
        <h5>Total Price:</h5>
        <p>Rs. <?php echo $totalPrice; ?></p>
    </div>

    <!-- Payment Options -->
    <h5>Choose Payment Method:</h5>
    <div class="payment-option active" id="cardOption" onclick="selectPaymentMethod('card')">
        <img src="https://img.icons8.com/ios-filled/50/000000/bank-card-back-side.png" alt="Card">
        <span>Credit/Debit Card</span>
    </div>
    <div class="payment-option" id="upiOption" onclick="selectPaymentMethod('upi')">
        <img src="https://img.icons8.com/ios-filled/50/000000/qr-code.png" alt="UPI">
        <span>UPI Payment</span>
    </div>
    
    <!-- Card Payment Form -->
    <form action="confirm_booking.php" method="POST" id="cardForm">
        <input type="hidden" name="selectedSeatsSilver" value="<?php echo htmlspecialchars($selectedSeatsSilver); ?>">
        <input type="hidden" name="selectedSeatsGold" value="<?php echo htmlspecialchars($selectedSeatsGold); ?>">
        <input type="hidden" name="showId" value="<?php echo htmlspecialchars($show_id); ?>">
        <div class="mb-3 mt-3">
            <label for="cardNumber" class="form-label">Card Number</label>
            <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
        </div>
        <div class="mb-3">
            <label for="expiryDate" class="form-label">Expiry Date</label>
            <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
        </div>
        <div class="mb-3">
            <label for="cvv" class="form-label">CVV</label>
            <input type="password" class="form-control" id="cvv" name="cvv" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Pay Now</button>
    </form>

    <!-- UPI Payment Form with QR Code -->
    <div id="upiForm" style="display: none;">
        <div class="text-center mt-3">
            <p>Scan this QR code to pay with UPI</p>
            <img src="Qr_code.jpeg" alt="UPI QR Code" class="qr-code" id="qrCode">
            <p class="mt-3">or enter your UPI ID:</p>
            <input type="text" class="form-control" id="upiId" name="upiId" placeholder="Enter UPI ID">
        </div>
        <button type="submit" form="cardForm" class="btn btn-primary w-100 mt-3">Confirm UPI Payment</button>
    </div>
</div>

<script>
    function selectPaymentMethod(method) {
        const cardOption = document.getElementById('cardOption');
        const upiOption = document.getElementById('upiOption');
        const cardForm = document.getElementById('cardForm');
        const upiForm = document.getElementById('upiForm');

        if (method === 'card') {
            cardOption.classList.add('active');
            upiOption.classList.remove('active');
            cardForm.style.display = 'block';
            upiForm.style.display = 'none';
        } else {
            upiOption.classList.add('active');
            cardOption.classList.remove('active');
            cardForm.style.display = 'none';
            upiForm.style.display = 'block';
            document.getElementById('qrCode').style.display = 'block';
        }
    }
</script>
</body>
</html>
