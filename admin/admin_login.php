<?php
include('../config.php');
session_start();

// Check if the session variable 'type' is set
if (isset($_SESSION['type']) && $_SESSION['type'] === 'admin') {
    header("Location: index.php");  // Redirect to admin panel if already logged in
    exit();
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password); // Consider using a more secure hashing method like password_hash()

    $sql = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password' AND user_type='admin'";
    $result = mysqli_query($conn, $sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['name'] = $row['user_name'];
        $_SESSION['email'] = $row['user_email'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['type'] = $row['user_type'];
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100">
    <div class="container col-md-4 bg-white p-4 rounded shadow">
        <h2 class="text-center mb-4">Admin Login</h2>
        <form action="admin_login.php" method="POST"> <!-- Correct form action -->
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label> <!-- Change label to Email -->
                <input type="email" id="email" name="email" class="form-control" required placeholder="Enter Email"> <!-- Change input name to email -->
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Enter Password">
            </div>

            <div class="d-grid">
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>