<?php
include('config.php');
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
    <title>Movie Ticket Booking Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" >Movie Ticket</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="About us.php">About us</a>
                    </li>
                    <!-- Account dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarAccount" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarAccount">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">Profile</a></li>
                            <li><a class="dropdown-item" href="orders.php">Your Orders</a></li>
                            <li><a class="dropdown-item" href="admin/index.php" >Admin</a></li>
                            
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Movie Cards Section -->
    <div class="container text-center mt-4">
    <?php
            echo "<h2>".$_SESSION['name'].", Welcome to the Movie Ticket Booking Dashboard!</h2>";
            ?>
        <div class="row">
            <!-- <div class="col-md-4"> -->
                <?php
                    $sql = "SELECT * FROM movies";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='col-md-4'>";
                            echo "<div class='card'>";
                            echo "<img src='admin/".$row['movie_image']."' alt='Movie poster ".$row['movie_name']."' class='card-img-top'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>".$row['movie_name']."</h5>";
                            // echo "<div class='rating-votes'>";
                            echo "<p><span class='badge bg-warning text-dark'>".$row['movie_ratings']."/10</span> |".$row['movie_vote']." Votes</p>";
                            echo "<p".$row['movie_category']."</p>";
                            echo "<a href='showtime.php?movie=".$row['movie_id']."' class='btn btn-primary'>Book Now</a>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No movies found.</p>";
                    }
                    ?>
                    
        </div>
    </div>

    <!-- Modal for User Profile -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">User Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <!-- Profile Image -->
                        <!-- <div class="text-center">
                            <img src="https://via.placeholder.com/150" alt="Profile Image" class="profile-pic" id="profilePic">
                            <input type="file" id="profileImageUpload" style="display: none;" onchange="previewImage(event)">
                            <button type="button" class="upload-btn" onclick="document.getElementById('profileImageUpload').click();">
                                Upload New Image
                            </button>
                        </div> -->
                        <!-- Profile Info -->
                        <div class="mb-3">
                            <label for="profileName" class="form-label">Name</label>
                            <?php
                            echo "<input type='text' class='form-control' id='profileName' value='".$_SESSION['name']."'>";
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="profileEmail" class="form-label">Email</label>
                            <?php
                            echo "<input type='email' class='form-control' id='profileEmail' value='".$_SESSION['email']."'>";
                            ?>
                            <!-- <input type="email" class="form-control" id="profileEmail"> -->
                        </div>
                        <div class="mb-3">
                            <label for="profilepass" class="form-label">Change_Password</label>
                            <input type="password" class="form-control" id="profilepass">
                        </div>
                        
                        <div class="mb-3">
                            <label for="profilePhone" class="form-label">Phone_no</label>
                            <input type="Phone" class="form-control" id="profilePhone">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Movie Ticket Booking | <a href="privacy.php">Privacy Policy</a></p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event) {
            const profilePic = document.getElementById('profilePic');
            profilePic.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

</body>

</html>
