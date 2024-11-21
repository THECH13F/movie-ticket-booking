<?php
session_start();
include('../config.php');
if (!isset($_SESSION['type'])) {
    header("Location: admin_login.php");  // Redirect to login page if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Movie Ticket Booking</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container-fluid">
        <!-- Sidebar -->
        <div class="row">
            <nav class="col-md-3 col-lg-2 bg-dark text-white vh-100 p-3 position-fixed">
                <h2 class="text-center">Admin Panel</h2>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link text-white">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="add_movie.php" class="nav-link text-white">Manage Movies</a>
                    </li>
                    <li class="nav-item">
                        <a href="view_user.php" class="nav-link text-white">View Users</a>
                    </li>
                    <li class="nav-item">
                        <a href="view_booking.php" class="nav-link text-white">View Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_theatre.php" class="nav-link text-white">Manage Theatre</a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_shows.php" class="nav-link text-white">Manage Shows</a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="#settings" class="nav-link text-white">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a href="../logout.php" class="nav-link text-white">Logout</a>
                    </li>
                </ul>
            </nav>