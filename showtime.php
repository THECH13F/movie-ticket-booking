<?php
session_start();
include 'config.php';

// Retrieve the movie ID from the query parameter
$movieid = isset($_GET['movie']) ? intval($_GET['movie']) : header("Location: index.php");  // Redirect to login page if movie ID is missing
$sql = "SELECT * FROM movies where movie_id = $movieid";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $movieName = $row['movie_name'];
    // $movieInfo = $row['movie_info'];
}
else{
    header("Location: index.php");  // Redirect to login page if movie ID is missing
}
// Initialize default values for movie information
$movieTitle = "Select a Movie";
$movieInfo = "Movie Information will display here";
$dates = []; // Example dates for UI
// $regions = ["Chembur", "Sion"]; // Example regions

// Initialize an array to hold the theater and show data
$theaters = [];

// Prepare the query to fetch theater and showtime information for the specified movie ID
$query = "
    SELECT s.show_id, t.theater_id, t.theater_name, t.theater_location, t.Cancellation, t.Food_Beverage, t.M_Ticket, s.date, s.time
    FROM tbl_shows s
    JOIN theater t ON s.theater_id = t.theater_id
    WHERE s.movie_id = ?
    ORDER BY t.theater_id, s.date, s.time
";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("SQL Error: " . mysqli_error($conn));  // Display SQL error if the statement preparation fails
}

// Bind the movie ID parameter to the query
mysqli_stmt_bind_param($stmt, "i", $movieid);

// Execute the prepared statement
if (!mysqli_stmt_execute($stmt)) {
    die("Execution Error: " . mysqli_error($conn));  // Display SQL error if the execution fails
}

// Get the result set from the executed statement
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Result Error: " . mysqli_error($conn));  // Display SQL error if getting result set fails
}

// Process the result set if there are rows returned
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $theater_id = $row['theater_id'];
        $theater_name = $row['theater_name'];
        $region = $row['theater_location'];
        $cancellation = $row['Cancellation'];
        $M_Ticket = $row['M_Ticket'];
        $Food_Beverage = $row['Food_Beverage'];
        $date = $row['date'];
        array_push($dates,$date);
        $time = $row['time'];
        // $show_type = $row['show_type'];

        // Organize data by theater
        if (!isset($theaters[$theater_id])) {
            $theaters[$theater_id] = [
                "name" => $theater_name,
                "region" => $region,
                // "priceRange" => $price_range,
                "cancellation" => $cancellation, // Assuming all theaters allow cancellation
                "M_Ticket" => $M_Ticket, // Assuming all theaters allow cancellation
                "Food_Beverage" => $Food_Beverage, // Assuming all theaters allow cancellation
                "showtimes" => [] // Initialize showtimes
            ];
        }

        // Add showtime to the theater's showtimes array
        $theaters[$theater_id]["showtimes"][] = [
            "time" => $time,
            "date" => $date,
            "show_id" => $row["show_id"] // Include show_id for redirection
        ];
    }
} else {
    echo "No showtimes available for this movie.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Showtime for <?php echo $movieName; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .navbar {
            background-color: #343a40;
            color: #fff;
        }
        .navbar-brand {
            color: #ff4d4d;
            font-weight: bold;
            font-size: 1.8rem;
        }
        .filter-section {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .theater-card {
            padding: 1.5rem;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            transition: transform 0.2s;
        }
        .theater-card:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-showtime {
            margin: 0.2rem;
        }
        .btn-primary {
            background-color: #ff4757;
            border: none;
        }
        .btn-primary:hover {
            background-color: #e63946;
        }
        .badge-cancel {
            background-color: #ffc107;
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand">MovieBook</a>
        </div>
    </nav>

    <div class="container mt-4">

        <!-- Movie Title and Date Selection -->
        <div class="row mt-4 text-center">
            <div class="col">
                <h1 class="mt-4">Showtime for: <?php echo $movieName; ?></h1>
                <p class="text-muted" id="movieInfo"><?php echo $movieInfo; ?></p>
            </div>
        </div>

        <div class="row mt-3 text-center">
    <div class="col-md-12">
        <!-- Render dates dynamically as buttons -->
        <?php foreach (array_unique($dates) as $index => $date): ?>
            <button class="btn btn-outline-dark me-2 date-btn <?php echo $index === 0 ? 'active' : ''; ?>" data-date="<?php echo $date; ?>">
                <?php echo $date; ?>
            </button>
        <?php endforeach; ?>
    </div>
</div>

        <!-- Filter Section -->
        <!-- <div class="row filter-section">
            <div class="col-md-3">
                <select id="regionFilter" class="form-select">
                    <option value="">Filter Sub Regions</option>
                    <?php foreach ($regions as $region): ?>
                        <option value="<?php echo $region; ?>"><?php echo $region; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select id="priceFilter" class="form-select">
                    <option value="">Filter Price Range</option>
                    <?php foreach ($priceRanges as $range): ?>
                        <option value="<?php echo $range; ?>"><?php echo $range; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select id="timeFilter" class="form-select">
                    <option value="">Filter Show Timings</option>
                    <?php foreach ($showTimes as $time): ?>
                        <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" onclick="applyFilters()"><i class="bi bi-search"></i> Search</button>
            </div>
        </div> -->

        <!-- Theater List with Showtimes -->
        <div class="row theater-section mt-3" id="theaterList">
    <?php foreach ($theaters as $theater_id => $theater): ?>
        <div class="col-12 theater-card" 
             data-region="<?php echo $theater['region']; ?>" 
             data-dates="<?php echo implode(',', array_unique(array_column($theater['showtimes'], 'date'))); ?>"> <!-- Store dates -->
            <h5><?php echo $theater['name']; ?></h5>
            <p class="text-muted">
                <?php if ($theater['M_Ticket'] === 'true'): ?>
                    <i class="bi bi-phone"></i> M-Ticket &nbsp; | &nbsp; 
                <?php endif; ?>
                <?php if ($theater['Food_Beverage'] === 'true'): ?>
                    <i class="bi bi-cup"></i> Food & Beverage &nbsp; | &nbsp; 
                <?php endif; ?>
                <?php if ($theater['cancellation'] === 'true'): ?>
                    <span class="badge badge-cancel">Cancellation Available</span>
                <?php endif; ?>
            </p>
            <div class="d-flex flex-wrap">
                <?php foreach ($theater['showtimes'] as $showtime): ?>

                    <button 
                        class="btn btn-outline-success btn-showtime" 
                        data-showid="<?php echo $showtime['show_id']; ?>" 
                        data-date="<?php echo $showtime['date']; ?>" 
                        data-time="<?php echo $showtime['time']; ?>">
                        <?php echo $showtime['time']; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Select the first date by default
        const dateButtons = document.querySelectorAll('.date-btn');
        const theaters = document.querySelectorAll('.theater-card');
        const showtimeButtons = document.querySelectorAll('.btn-showtime');

        // Add 'active' class to the first date button on load
        if (dateButtons.length > 0) {
            const firstDateButton = dateButtons[0];
            firstDateButton.classList.add("active");
            const selectedDate = firstDateButton.getAttribute('data-date');

            // Filter theaters and showtimes for the default selected date
            filterByDate(selectedDate);
        }

        // Add click event listeners to date buttons
        dateButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                // Remove 'active' class from all buttons
                dateButtons.forEach(btn => btn.classList.remove("active"));
                // Add 'active' class to the clicked button
                this.classList.add("active");

                const selectedDate = this.getAttribute('data-date');
                filterByDate(selectedDate);
            });
        });

        function filterByDate(selectedDate) {
            // Filter theaters by date
            theaters.forEach(theater => {
                const theaterDates = theater.getAttribute('data-dates').split(',');
                if (theaterDates.includes(selectedDate)) {
                    theater.style.display = 'block'; // Show theater if it matches the selected date
                } else {
                    theater.style.display = 'none'; // Hide otherwise
                }
            });

            // Filter show timings within visible theaters
            showtimeButtons.forEach(showtime => {
                const showtimeDate = showtime.getAttribute('data-date');
                if (showtimeDate === selectedDate) {
                    showtime.style.display = 'inline-block'; // Show showtime if it matches the date
                } else {
                    showtime.style.display = 'none'; // Hide otherwise
                }
            });
        }

        // Handle "Book Now" button for seat selection
        showtimeButtons.forEach(showtime => {
            showtime.addEventListener('click', function () {
                const showId = this.getAttribute('data-showid');
                window.location.href = `seat_selection.php?show_id=${showId}`;
            });
        });
    });
</script>
</body>
</html>
