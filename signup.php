<?php
include 'config.php';
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $password = md5($password);
    
    $sql = "SELECT * FROM users WHERE user_email='$email'";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows > 0){
        echo "Email Already Exists!!";
    }else{
        $sql = "INSERT INTO users (`user_name`, `user_email`, `user_password`) VALUES ('$name', '$email', '$password');";
        $result = mysqli_query($conn, $sql);
        if($result){
            header("Location: login.php");
        }else{
            echo "Somwthing Went Wrong!!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Movie Ticket Booking</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="bg-danger text-white text-center py-3">
        <h1 class="mb-0">Movie Ticket Booking</h1>
    </header>

    <main class="flex-grow-1 d-flex align-items-center justify-content-center bg-light" style="background-image: url('tic.webp'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="card p-4 shadow" style="max-width: 400px;">
            <h2 class="text-center mb-4">Sign Up</h2>
            <form action="signup.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <button type="submit" name="submit" class="btn btn-primary w-100 mb-3">Sign Up</button>
                <p class="text-center mb-0">Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </main>

    <footer class="bg-danger text-white text-center py-2 mt-auto">
        <p class="mb-0">&copy; 2024 Movie Ticket Booking</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>