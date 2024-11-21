<?php
include '../config.php';
// Handle form submissions for Add/Edit Booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_booking"])) {
        // Add Booking
        $user = $_POST["user"];
        $show = $_POST["show"];
        $silver_seats = $_POST["silver_seat_no"];
        $gold_seats = $_POST["gold_seat_no"];
        $payment = $_POST["payment"];

        $stmt = $conn->prepare("INSERT INTO booking (booking_user, booking_show, silver_seat_no, gold_seat_no, payment) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $user, $show, $silver_seats, $gold_seats, $payment);
        if ($stmt->execute()) {
            $_SESSION['status'] = "success";
            $_SESSION['message'] = "Booking added successfully!";
        } else {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Error: " . $stmt->error;
        }
        $stmt->close();

        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST["edit_booking"])) {
        // Edit Booking
        $id = $_POST["booking_id"];
        $user = $_POST["user"];
        $show = $_POST["show"];
        $silver_seats = $_POST["silver_seat_no"];
        $gold_seats = $_POST["gold_seat_no"];
        $payment = $_POST["payment"];

        $stmt = $conn->prepare("UPDATE booking SET booking_user = ?, booking_show = ?, silver_seat_no = ?, gold_seat_no = ?, payment = ? WHERE booking_id = ?");
        $stmt->bind_param("sssssi", $user, $show, $silver_seats, $gold_seats, $payment, $id);
        if ($stmt->execute()) {
            $_SESSION['status'] = "success";
            $_SESSION['message'] = "Booking Updated successfully!";
        } else {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Error: " . $stmt->error;
        }
        $stmt->close();

        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch all bookings
$result = $conn->query("SELECT * FROM booking");
if (!$result) {
    die("Error fetching bookings: " . $conn->error);
}
?>

<?php include 'header.php'; ?>

<main class="col-md-9 mt-5 ms-sm-auto col-lg-10 px-md-4">
    <h2>Manage Bookings</h2>

    <button class="btn btn-primary" onclick="openAddModal()" style="float: right;">Add Booking</button>

    <table class="table table-hover table-bordered mt-4">
        <thead class="table-primary">
            <tr>
                <th>Booking ID</th>
                <th>Booking User</th>
                <th>Booking Show</th>
                <th>Silver Seats</th>
                <th>Gold Seats</th>
                <th>Payment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row["booking_id"] ?></td>
                        <td><?= $row["booking_user"] ?></td>
                        <td><?= $row["booking_show"] ?></td>
                        <td><?= $row["silver_seat_no"] ?></td>
                        <td><?= $row["gold_seat_no"] ?></td>
                        <td><?= $row["payment"] ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="openEditModal(<?= $row['booking_id'] ?>, '<?= $row['booking_user'] ?>', '<?= $row['booking_show'] ?>', '<?= $row['silver_seat_no'] ?>', '<?= $row['gold_seat_no'] ?>', '<?= $row['payment'] ?>')">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteBooking(<?= $row['booking_id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No bookings found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<!-- Add Booking Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="add_booking" value="1">
                    <div class="mb-3">
                        <label for="user" class="form-label">Booking User</label>
                        <input type="number" name="user" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="show" class="form-label">Booking Show</label>
                        <input type="number" name="show" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="silver_seat_no" class="form-label">Silver Seats</label>
                        <textarea class="form-control" name="silver_seat_no" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gold_seat_no" class="form-label">Gold Seats</label>
                        <textarea class="form-control" name="gold_seat_no" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="payment" class="form-label">Payment</label>
                        <input type="text" name="payment" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Edit Booking Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_booking" value="1">
                    <input type="hidden" name="booking_id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-user" class="form-label">Booking User</label>
                        <input type="number" name="user" id="edit-user" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-show" class="form-label">Booking Show</label>
                        <input type="number" name="show" id="edit-show" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-silver_seat_no" class="form-label">Silver Seats</label>
                        <textarea class="form-control" id="edit-silver_seat_no" name="silver_seat_no" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-gold_seat_no" class="form-label">Gold Seats</label>
                        <textarea class="form-control" id="edit-gold_seat_no" name="gold_seat_no" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-payment" class="form-label">Payment</label>
                        <input type="text" name="payment" id="edit-payment" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    const modal = new bootstrap.Modal(document.getElementById('addModal'));
    modal.show();
}

function openEditModal(id, user, show, silverSeats, goldSeats, payment) {
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-user').value = user;
    document.getElementById('edit-show').value = show;
    document.getElementById('edit-silver_seat_no').value = silverSeats;
    document.getElementById('edit-gold_seat_no').value = goldSeats;
    document.getElementById('edit-payment').value = payment;

    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}

function deleteBooking(id) {
    if (confirm("Are you sure you want to delete this booking?")) {
        window.location.href = `delete_booking.php?id=${id}`;
    }
}
</script>

<?php include 'footer.php'; ?>
