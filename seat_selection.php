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
    <title>Seat and Showtime Selection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            text-align: center;
            line-height: 40px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .seat.available {
            background-color: #28a745;
            color: #fff;
        }
        .seat.selected {
            background-color: #ffc107;
            color: #000;
        }
        .seat.occupied {
            background-color: #6c757d;
            color: #fff;
            cursor: not-allowed;
        }
        .seat-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .price-tag {
            font-size: 16px;
            margin-right: 10px;
            color: #333;
        }
        .seat-selection {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .seat:hover:not(.occupied):not(.selected) {
            background-color: #b2dfdb;
        }
        .screen {
            width: 100%;
            /* height: 25px; */
            background-color: #e0e0e0;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            border-radius: 10px;
            color: #555;
            font-weight: bold;
        }
        .text-muted {
            --bs-text-opacity: 1;
            color: #fff !important;
        }
        .modal{
            --bs-modal-bg: #373b3e;
        }
    </style>
</head>
<body class="bg-dark text-white">
<div class="container mt-4">
    <h2 class="text-center" >Seat and Showtime Selection</h2>
    <?php
    include 'config.php';
    // Check if theater name is provided in the URL, default to "Unknown Theater" if not set
    $show_id = isset($_GET['show_id']) ? intval($_GET['show_id']) : header("Location: index.php");
    $sql="SELECT s.theater_id,s.time,s.date,s.gold_row,s.gold_col,s.silver_booked,s.gold_booked,s.gold_price,s.silver_row,s.silver_col,s.silver_price,t.theater_name,t.theater_location FROM `tbl_shows` as s JOIN theater t ON s.theater_id = t.theater_id WHERE `show_id` = $show_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $theaterName = $row['theater_name'];
        $theater_location = $row['theater_location'];
        $gold_row = $row['gold_row'];
        $gold_col = $row['gold_col'];
        $silver_row = $row['silver_row'];
        $silver_col = $row['silver_col'];
        $gold_price = $row['gold_price'];
        $silver_price = $row['silver_price'];
        $showtime = $row['time'];
        $date = $row['date'];
        $gold_booked=$row['gold_booked'];
        $silver_booked=$row['silver_booked'];
        $gold = explode(',', $gold_booked);
        $silver = explode(',', $silver_booked);
        
        // echo $silver;
        // $movieInfo = $row['movie_info'];
    }
    else{
        header("Location: index.php");  // Redirect to login page if movie ID is missing
        // $movieInfo = $row['movie_info'];
    }
    ?>
    <p class="text-center text-muted"><?php echo $theaterName." : ".$theater_location." | ".$date; ?> </p>
    
    
    <!-- Showtime Selection -->
    <!-- <div class="text-center mb-3">
        <h5>Select a Showtime:</h5>
        <button class="btn btn-outline-success me-1" onclick="selectTime('10:00 AM')">10:00 AM Atmos</button>
        <button class="btn btn-outline-success me-1" onclick="selectTime('01:15 PM')">01:15 PM Atmos</button>
        <button class="btn btn-outline-success me-1" onclick="selectTime('04:30 PM')">04:30 PM Atmos</button>
        <button class="btn btn-outline-success me-1" onclick="selectTime('07:45 PM')">07:45 PM Atmos</button>
        <button class="btn btn-outline-success" onclick="selectTime('10:55 PM')">10:55 PM Atmos</button>
    </div> -->

    <p class="text-center"><strong>Selected Showtime:</strong> <span id="selectedTime">None</span></p>

    <!-- Seat Layout -->
    <div class="text-center mb-4">
        <div class="price-tag text-white">Rs. <?php echo $gold_price ?> GOLD</div>
        <?php
            $rows = $gold_row;
            $start=$rows[0];
            $end=$rows[1];
        for ($row = $start; $row <= $end; $row++) {
        echo "<div class='seat-container'>";
            $goldSeats = $gold_col;
                for ($i = 1; $i <= $goldSeats; $i++) {
                    $seatNum = $row . $i;
                    $class =  (in_array($seatNum, $gold))  ? "occupied" : "available";
                    echo "<div class='seat $class' data-price='$gold_price' data-seat='$seatNum' onclick='selectSeatgold(this)'>$seatNum</div>";
                }
        echo "</div>";
    }
    ?>
      

        <div class="price-tag text-white">Rs. <?php echo $silver_price ?> SILVER</div>
        <?php
            $rows = $silver_row;
            $start=$rows[0];
            $end=$rows[1];
        for ($row = $start; $row <= $end; $row++) {
        echo "<div class='seat-container'>";
            $silverSeats = $silver_col;
                for ($i = 1; $i <= $silverSeats; $i++) {
                    $seatNum = $row . $i;

                    // $isOccupied = false; // Randomly occupy seats
                    $class =  (in_array($seatNum, $silver))  ? "occupied" : "available";
                    echo "<div class='seat $class' data-price='$silver_price' data-seat='$seatNum' onclick='selectSeatsilver(this)'>$seatNum</div>";
                }
                echo "</div>";
            }   
            ?>
    </div>

    <!-- Screen -->
    <div class="screen">Screen</div>

    <!-- Total Price & Confirmation -->
    <div class="seat-selection mt-4">
        <div>Total Price: <span id="totalPrice">Rs. 0</span></div>
        <button class="btn btn-danger" onclick="showConfirmationModal()">Pay Now</button>
    </div>
</div>



<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Your Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Selected Showtime:</strong> <span id="modalSelectedTime">None</span></p>
                <p>Selected Seats: <span id="modalSeats"></span></p>
                <p>Total Price: <strong><span id="modalTotalPrice"></span></strong></p>
                <p>Do you want to proceed with the payment?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="proceedToPayment()">Confirm and Pay</button>
            </div>
        </div>
    </div>
</div>
<form id="paymentForm" action="payment.php" method="POST" style="display: none;">
            <input type="hidden" name="selectedSeatsSilver" id="formSelectedSeatsSilver">
            <input type="hidden" name="selectedSeatsGold" id="formSelectedSeatsGold">
            <input type="hidden" name="totalPrice" id="formTotalPrice">
            <input type="hidden" name="selectedTime" id="formSelectedTime">
            <input type="hidden" name="show_id" id="formuserId" value="<?php echo $show_id; ?>">
        </form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let selectedSeatssilver = [];
    let selectedSeatsgold = [];
    let selectedseats=[]
    let totalPrice = 0;
    let selectedTime = "<?php echo $showtime ?>";
    document.getElementById('selectedTime').textContent = "<?php echo $showtime ?>";

    function selectSeatsilver(element) {
        if (element.classList.contains('occupied')) return;

        const price = parseInt(element.getAttribute('data-price'));
        const seat = element.getAttribute('data-seat');

        if (element.classList.contains('selected')) {
            element.classList.remove('selected');
            selectedSeatssilver = selectedSeatssilver.filter(s => s !== seat);
            totalPrice -= price;
        } else {
            element.classList.add('selected');
            selectedSeatssilver.push(seat);
            totalPrice += price;
        }

        document.getElementById('totalPrice').textContent = `Rs. ${totalPrice}`;
    }
    function selectSeatgold(element) {
        if (element.classList.contains('occupied')) return;

        const price = parseInt(element.getAttribute('data-price'));
        const seat = element.getAttribute('data-seat');

        if (element.classList.contains('selected')) {
            element.classList.remove('selected');
            selectedSeatsgold = selectedSeatsgold.filter(s => s !== seat);
            totalPrice -= price;
        } else {
            element.classList.add('selected');
            selectedSeatsgold.push(seat);
            totalPrice += price;
        }

        document.getElementById('totalPrice').textContent = `Rs. ${totalPrice}`;
    }

    // function selectTime(time) {
    //     selectedTime = time;
    //     document.getElementById('selectedTime').textContent = time;
    // }

    function showConfirmationModal() {
        if (selectedSeatssilver.length === 0 && selectedSeatsgold.length==0) {
            alert("Please select at least one seat to proceed.");
            return;
        }
        selectedseats=selectedSeatssilver+selectedSeatsgold;
        document.getElementById('modalSeats').textContent = selectedSeatssilver.join(',')+" , "+selectedSeatsgold.join(', ');
        document.getElementById('modalTotalPrice').textContent = `Rs. ${totalPrice}`;
        document.getElementById('modalSelectedTime').textContent = selectedTime;

        new bootstrap.Modal(document.getElementById('confirmationModal')).show();
    }

    function proceedToPayment() {
        if (selectedSeatssilver.length === 0 && selectedSeatsgold.length==0) {
            alert("Please select at least one seat to proceed.");
            return;
        }
        // selectedseats=selectSeatsilver+selectedSeatsgold;
        document.getElementById('formSelectedSeatsSilver').value = selectedSeatssilver.join(',');
        document.getElementById('formSelectedSeatsGold').value = selectedSeatsgold.join(',');
        document.getElementById('formTotalPrice').value = totalPrice;
        document.getElementById('formSelectedTime').value = selectedTime;

        document.getElementById('paymentForm').submit();
    }
</script>
</body>
</html>
