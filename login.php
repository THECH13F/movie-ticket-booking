<?php
include('config.php');
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");  // Redirect to login page if not logged in
    exit();
}
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);
    $sql = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password'";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['name'] = $row['user_name'];
        $_SESSION['email'] = $row['user_email'];
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: index.php");
    }else{
        echo "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Ticket Booking - Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
  <!-- Header -->
  <header class="bg-danger text-white text-center py-3">
    <h1 class="mb-0">Movie Ticket Booking</h1>
  </header>

  <!-- Main Content -->
  <main class="flex-grow-1 d-flex align-items-center justify-content-center" style="background-image: url('tic.webp'); background-size: cover; background-position: center; background-attachment: fixed;">
    <!-- Login Box -->
    <div class="card p-4 shadow" style="max-width: 400px;">
      <h2 class="text-center mb-4">Login</h2>
      <form action="login.php" method="POST"> 
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control rounded-pill" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control rounded-pill" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="rememberMe">
          <label class="form-check-label" for="rememberMe">Remember me</label>
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100 rounded-pill mb-3">Login</button>
      </form>
      <div class="text-center">
        <p class="mb-1">Don't have an account? <a href="signup.php">Sign Up</a></p>
       
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-danger text-white text-center py-2 mt-auto">
    <p class="mb-0">&copy; 2024 Movie Ticket Booking</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>