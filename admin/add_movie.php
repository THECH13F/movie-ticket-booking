<?php include 'header.php'; ?>

<main class="col-md-9 mt-5 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manage Movies</h2>
        <button class="btn btn-primary" onclick="openAddMovieModal()"> Add Movie</button>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Movie Name</th>
                <th>Movie Image</th>
                <th>Category</th>
                <th>Votes</th>
                <th>Ratings</th>
                <th>Seats</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    $sql = "SELECT * FROM movies";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                            echo "<td>" .$row['movie_name']."</td>";
                            echo "<td><img src=".$row['movie_image']." alt='Movie poster ".$row['movie_name']."' width='60'></td>";
                            echo "<td>".$row['movie_category']."</td>";
                            echo "<td>".$row['movie_vote']."</td>";
                            echo "<td>".$row['movie_ratings']."</td>";
                            echo "<td>100</td>";
                            echo "<td>250rs</td>";
                            echo "<td>";
                                echo "<button class='btn btn-warning btn-sm' onclick='openEditMovieModal(".$row['movie_id'].")'>Edit</button>";
                                echo "<button class='btn btn-danger btn-sm' onclick='openDeleteMovieModal(".$row['movie_id'].", \"".$row['movie_name']."\")'>Delete</button>";
                            echo "</td>";
                        echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No movies found</td></tr>";
                    }
            ?>
            <!-- Repeat rows for more movies as needed -->
        </tbody>
    </table>
</main>

<!-- Add Movie Modal -->
<div class="modal fade" id="addMovieModal" tabindex="-1" aria-labelledby="addMovieModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="addMovieForm" enctype="multipart/form -data" method="POST" action="save_movie.php">
            <input type="hidden" name="movieId" id="movieId" value="">
            <div class="modal-header">
                <h5 class="modal-title" id="addMovieModalLabel">Add New Movie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="movieTitle" class="form-label">Movie Title</label>
                    <input type="text" class="form-control" name="movieTitle" id="movieTitle" required>
                </div>
                <div class="mb-3">
                    <label for="movieCategory" class="form-label">Category</label>
                    <input type="text" class="form-control" name="movieCategory" id="movieCategory">
                </div>
                <div class="mb-3">
                    <label for="movieVotes" class="form-label">Votes</label>
                    <input type="number" class="form-control" name="movieVotes" id="movieVotes">
                </div>
                <div class="mb-3">
                    <label for="movieRating" class="form-label">Rating</label>
                    <input type="number" class="form-control" name="movieRating" id="movieRating" step="0.1">
                </div>
                <div class="mb-3">
                    <label for="movieSeats" class="form-label">Seats</label>
                    <input type="number" class="form-control" name="movieSeats" id="movieSeats">
                </div>
                <div class="mb-3">
                    <label for="movieImage">Movie Image:</label>
                    <input type="file" class="form-control" name="movieImage" id="movieImage" required>
                </div>
                <div class="mb-3">
                    <label for="moviePrice" class="form-label">Price</label>
                    <input type="number" class="form-control" name="moviePrice" id="moviePrice" step="0.01">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Movie</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Edit Movie Modal -->
<div class="modal fade" id="editMovieModal" tabindex="-1" aria-labelledby="editMovieModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editMovieForm" enctype="multipart/form-data" method="POST" action="save_movie.php">
                <input type="hidden" name="movieId" id="editMovieId">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMovieModalLabel">Edit Movie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editMovieTitle" class="form-label">Movie Title</label>
                        <input type="text" class="form-control" name="movieTitle" id="editMovieTitle" required>
                        <!-- <input type="text" class="form-control" name="movieId" id="editMovieid" hidden> -->
                    </div>
                    <div class="mb-3">
                        <label for="editMovieCategory" class="form-label">Category</label>
                        <input type="text" class="form-control" name="movieCategory" id="editMovieCategory" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMovieVotes" class="form-label">Votes</label>
                        <input type="number" class="form-control" name="movieVotes" id="editMovieVotes" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMovieRating" class="form-label">Rating</label>
                        <input type="number" class="form-control" name="movieRating" id="editMovieRating" required step="0.1">
                    </div>
                    <div class="mb-3">
                        <label for="editMovieSeats" class="form-label">Seats</label>
                        <input type="number" class="form-control" name="movieSeats" id="editMovieSeats" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMovieImage">Movie Image:</label>
                        <input type="file" class="form-control" name="movieImage" id="editMovie Image" >
                    </div>
                    <div class="mb-3">
                        <label for="editMoviePrice" class="form-label">Price</label>
                        <input type="number" class="form-control" name="moviePrice" id="editMoviePrice" required step="0.01">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Movie Modal -->
<div class="modal fade" id="deleteMovieModal" tabindex="-1" aria-labelledby="deleteMovieModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMovieModalLabel">Delete Movie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteMovieName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openAddMovieModal() {
        const addModal = new bootstrap.Modal(document.getElementById('addMovieModal'));
        addModal.show();
    }

    function openEditMovieModal(movieId) {
    fetch(`get_movie.php?id=${movieId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editMovieTitle').value = data.movie_name;
            document.getElementById('editMovieId').value = data.movie_id;
            document.getElementById('editMovieCategory').value = data.movie_category;
            document.getElementById('editMovieVotes').value = data.movie_vote;
            document.getElementById('editMovieRating').value = data.movie_ratings;
            document.getElementById('editMovieSeats').value = data.movie_seats;
            document.getElementById('editMoviePrice').value = data.movie_price;
            const editModal = new bootstrap.Modal(document.getElementById('editMovieModal'));
            editModal.show();
        })
        .catch(error => console.error('Error fetching movie data:', error));
}


function openDeleteMovieModal(movieId, movieName) {
    document.getElementById('deleteMovieName').textContent = movieName;
    document.getElementById('confirmDeleteButton').onclick = function() {
        confirmDelete(movieId);
    };
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteMovieModal'));
    deleteModal.show();
}

function confirmDelete(movieId) {
    fetch(`delete_movie.php?id=${movieId}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Reload the page to see the changes
        })
        .catch(error => console.error('Error deleting movie:', error));
}
document.getElementById('addMovieForm').onsubmit = function(event) {
    event.preventDefault(); // Prevent default form submission
    const formData = new FormData(this);
    fetch('save_movie.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.message === 'Movie saved successfully!') {
            location.reload(); // Reload the page to see the changes
        }
    })
    .catch(error => console.error('Error saving movie:', error));
};

document.getElementById('editMovieForm').onsubmit = function(event) {
    event.preventDefault(); // Prevent default form submission
    const formData = new FormData(this);
    fetch('save_movie.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.message === 'Movie saved successfully!') {
            location.reload(); // Reload the page to see the changes
        }
    })
    .catch(error => console.error('Error saving movie:', error));
};
</script>

<?php include 'footer.php'; ?>