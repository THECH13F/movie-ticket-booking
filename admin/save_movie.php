<?php
include '../config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = isset($_POST['movieId']) ? intval($_POST['movieId']) : null;
    $movieName = $_POST['movieTitle'];
    $movieCategory = $_POST['movieCategory'];
    $movieVotes = $_POST['movieVotes'];
    $movieRating = $_POST['movieRating'];
    $movieSeats = $_POST['movieSeats'];
    $moviePrice = $_POST['moviePrice'];

    $targetDir = "../uploads/"; 
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["movieImage"]["name"], PATHINFO_EXTENSION));
    $existingImagePath = ""; // Variable to hold the existing image path

    if ($movieId) {
        // Fetch the existing movie details if editing
        $sql = "SELECT movie_image FROM movies WHERE movie_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $movieId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $existingImagePath);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // Handle file upload
    if (isset($_FILES["movieImage"]) && $_FILES["movieImage"]["error"] === UPLOAD_ERR_OK) {
        $targetFile = $targetDir . basename($_FILES["movieImage"]["name"]);

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["movieImage"]["tmp_name"]);
        if ($check === false) {
            echo json_encode(['message' => 'File is not an image.']);
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo json_encode(['message' => 'Sorry, file already exists.']);
            $uploadOk = 0;
        }

        // Check file size (optional)
        if ($_FILES["movieImage"]["size"] > 500000) {
            echo json_encode(['message' => 'Sorry, your file is too large.']);
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo json_encode(['message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
            $uploadOk = 0;
        }

        // If everything is ok, try to upload file
        if ($uploadOk === 1) {
            if (move_uploaded_file($_FILES["movieImage"]["tmp_name"], $targetFile)) {
                // Use the new image path
                $imagePathToUse = $targetFile;
            } else {
                echo json_encode(['message' => 'Sorry, there was an error uploading your file.']);
                exit;
            }
        } else {
            // If upload failed, use the existing image path
            $imagePathToUse = $existingImagePath;
        }
    } else {
        // If no new image is uploaded, use the existing image path
        $imagePathToUse = $existingImagePath;
    }

    // Update or insert movie details
    if ($movieId) {
        // Update movie
        $sql = "UPDATE movies SET movie_name=?, movie_category=?, movie_vote=?, movie_ratings=?, movie_seats=?, movie_price=?, movie_image=? WHERE movie_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssissssi", $movieName, $movieCategory, $movieVotes, $movieRating, $movieSeats, $moviePrice, $imagePathToUse, $movieId);
    } else {
        // Add new movie
        $sql = "INSERT INTO movies (movie_name, movie_category, movie_vote, movie_ratings , movie_seats, movie_price, movie_image) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssissss", $movieName, $movieCategory, $movieVotes, $movieRating, $movieSeats, $moviePrice, $imagePathToUse);
    }

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['message' => 'Movie saved successfully!']);
    } else {
        echo json_encode(['message' => 'Error saving movie.']);
    }
    mysqli_stmt_close($stmt);
}
?>