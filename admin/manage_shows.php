<?php include 'header.php'; ?>

<?php
// Fetch theaters and movies
$theaters = [];
$movies = [];

$sqlTheaters = "SELECT theater_id, theater_name FROM theater";
$resultTheaters = mysqli_query($conn, $sqlTheaters);
if (mysqli_num_rows($resultTheaters) > 0) {
    while ($row = mysqli_fetch_assoc($resultTheaters)) {
        $theaters[] = $row;
    }
}

$sqlMovies = "SELECT movie_id, movie_name FROM movies";
$resultMovies = mysqli_query($conn, $sqlMovies);
if (mysqli_num_rows($resultMovies) > 0) {
    while ($row = mysqli_fetch_assoc($resultMovies)) {
        $movies[] = $row;
    }
}
?>

<script>
    const theaters = <?php echo json_encode($theaters); ?>;
    const movies = <?php echo json_encode($movies); ?>;
</script>
<main class="col-md-9 mt-5 ms-sm-auto col-lg-10 px-md-4">
        <h2>Show Theatre</h2>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal" style="float: right;">Add Show</button>
        
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Theatre Name</th>
                    <th>Movie Name</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Gold Row</th>
                    <th>Gold Column</th>
                    <th>Gold Price</th>
                    <th>Silver Row</th>
                    <th>Silver Column</th>
                    <th>Silver Price</th>
                    <th>Silver Booked</th>
                    <th>Gold Booked</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="showTableBody">
                <!-- Rows will be dynamically added here -->
            </tbody>
        </table>
</main>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Show</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form fields to add a new show -->
                        <div class="mb-3">
                        <label for="addTheatreName" class="form-label">Theatre Name</label>
                        <select class="form-control" id="addTheatreName" required>
                            <option value="" disabled selected>Select Theatre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addMovieName" class="form-label">Movie Name</label>
                        <select class="form-control" id="addMovieName" required>
                            <option value="" disabled selected>Select Movie</option>
                        </select>
                    </div>
                        <div class="mb-3">
                            <label for="addTime" class="form-label">Time</label>
                            <input type="time" class="form-control" id="addTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="addDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="addDate" required>
                        </div>
                        <!-- Additional fields for Gold/Silver details -->
                        <div class="mb-3">
                            <label for="addGoldRow" class="form-label">Gold Row</label>
                            <input type="text" class="form-control" id="addGoldRow" required>
                        </div>
                        <div class="mb-3">
                            <label for="addGoldColumn" class="form-label">Gold Column</label>
                            <input type="number" class="form-control" id="addGoldColumn" required>
                        </div>
                        <div class="mb-3">
                            <label for="addGoldPrice" class="form-label">Gold Price</label>
                            <input type="number" class="form-control" id="addGoldPrice" required>
                        </div>
                        <div class="mb-3">
                            <label for="addSilverRow" class="form-label">Silver Row</label>
                            <input type="text" class="form-control" id="addSilverRow" required>
                        </div>
                        <div class="mb-3">
                            <label for="addSilverColumn" class="form-label">Silver Column</label>
                            <input type="number" class="form-control" id="addSilverColumn" required>
                        </div>
                        <div class="mb-3">
                            <label for="addSilverPrice" class="form-label">Silver Price</label>
                            <input type="number" class="form-control" id="addSilverPrice" required>
                        </div>
                        <div class="mb-3">
                            <label for="addsBooked" class="form-label">Silver Booked</label>
                            <textarea class="form-control" id="addsBooked" placeholder="Enter booked details"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="addgBooked" class="form-label">Gold Booked</label>
                            <textarea class="form-control" id="addgBooked" placeholder="Enter booked details"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Show</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Show</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Similar fields as Add Modal for editing -->
                        <div class="mb-3">
                        <label for="editTheatreName" class="form-label">Theatre Name</label>
                        <select class="form-control" id="editTheatreName" required>
                            <option value="" disabled>Select Theatre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editMovieName" class="form-label">Movie Name</label>
                        <select class="form-control" id="editMovieName" required>
                            <option value="" disabled>Select Movie</option>
                        </select>
                    </div>
                        <div class="mb-3">
                            <label for="editTime" class="form-label">Time</label>
                            <input type="time" class="form-control" id="editTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="editDate" required>
                        </div>
                        <!-- Additional fields for Gold/Silver details -->
                        <div class="mb-3">
                            <label for="editGoldRow" class="form-label">Gold Row</label>
                            <input type="text" class="form-control" id="editGoldRow" required>
                        </div>
                        <div class="mb-3">
                            <label for="editGoldColumn" class="form-label">Gold Column</label>
                            <input type="number" class="form-control" id="editGoldColumn" required>
                        </div>
                        <div class="mb-3">
                            <label for="editGoldPrice" class="form-label">Gold Price</label>
                            <input type="number" class="form-control" id="editGoldPrice" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSilverRow" class="form-label">Silver Row</label>
                            <input type="text" class="form-control" id="editSilverRow" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSilverColumn" class="form-label">Silver Column</label>
                            <input type="number" class="form-control" id="editSilverColumn" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSilverPrice" class="form-label">Silver Price</label>
                            <input type="number" class="form-control" id="editSilverPrice" required>
                        </div>
                        <div class="mb-3">
                            <label for="editsBooked" class="form-label">Silver Booked</label>
                            <textarea class="form-control" id="editsBooked"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editgBooked" class="form-label">Gold Booked</label>
                            <textarea class="form-control" id="editgBooked"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const addTheatreName = document.getElementById("addTheatreName");
    const addMovieName = document.getElementById("addMovieName");
    const editTheatreName = document.getElementById("editTheatreName");
    const editMovieName = document.getElementById("editMovieName");

    function populateSelectOptions(select, data, defaultText) {
        select.innerHTML = `<option value="" disabled selected>${defaultText}</option>`;
        data.forEach(item => {
            const option = document.createElement("option");
            option.value = item.theater_id || item.movie_id;
            option.textContent = item.theater_name || item.movie_name;
            select.appendChild(option);
        });
    }
    populateSelectOptions(addTheatreName, theaters, "Select Theatre");
    populateSelectOptions(addMovieName, movies, "Select Movie");
    function populateEditForm(show) {
        populateSelectOptions(editTheatreName, theaters, "Select Theatre");
        populateSelectOptions(editMovieName, movies, "Select Movie");

        editTheatreName.value = show.theatreId;
        editMovieName.value = show.movieName;
    }
        const showTableBody = document.getElementById("showTableBody");
        let shows = [
            <?php
                    $sql = "SELECT 
                        movies.movie_name AS movie_name,
                        theater.theater_name AS theater_name,
                        movies.movie_id AS movie_id,
                        theater.theater_id AS theater_id,
                        theater.theater_location AS theater_location,
                        tbl_shows.*
                        FROM 
                        tbl_shows
                        JOIN 
                        movies ON tbl_shows.movie_id = movies.movie_id
                        JOIN 
                        theater ON tbl_shows.theater_id = theater.theater_id";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
        echo "{id:'".$row['show_id']."', theatreName: '".$row['theater_name']."', theatreId: '".$row['theater_id']."', movieName: '".$row['movie_name']."', movieId: '".$row['movie_id']."', location: '".$row['theater_location']."', time: '".$row['time']."', date: '".$row['date']."', goldRow: '".$row['gold_row']."', goldColumn: '".$row['gold_col']."', goldPrice: '".$row['gold_price']."', silverRow: '".$row['silver_row']."', silverColumn: '".$row['silver_col']."', silverPrice: '".$row['silver_price']."', Sbooked: '".$row['silver_booked']."', Gbooked: '".$row['gold_booked']."' },";
                        }
                    }
                    ?>
        ];

        document.getElementById("addForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const newShow = {
                theatreName: document.getElementById("addTheatreName").value,
                movieName: document.getElementById("addMovieName").value,
                time: document.getElementById("addTime").value,
                date: document.getElementById("addDate").value,
                goldRow: document.getElementById("addGoldRow").value,
                goldColumn: document.getElementById("addGoldColumn").value,
                goldPrice: document.getElementById("addGoldPrice").value,
                silverRow: document.getElementById("addSilverRow").value,
                silverColumn: document.getElementById("addSilverColumn").value,
                silverPrice: document.getElementById("addSilverPrice").value,
                Sbooked: document.getElementById("addsBooked").value,
                Gbooked: document.getElementById("addgBooked").value,
            };
            const formData = new FormData();
        formData.append("theatreName",newShow.theatreName);
        formData.append("movieName",newShow.movieName);
        formData.append("time",newShow.time);
        formData.append("date",newShow.date);
        formData.append("gold_row",newShow.goldRow);
        formData.append("gold_col",newShow.goldColumn);
        formData.append("gold_price",newShow.goldPrice);
        formData.append("silver_row",newShow.silverRow);
        formData.append("silver_col",newShow.silverColumn);
        formData.append("silver_price",newShow.silverPrice);
        formData.append("silver_booked",newShow.Sbooked);
        formData.append("gold_booked",newShow.Gbooked);

        fetch('save_shows.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.message === 'show saved successfully!') {
                window.location.reload();; // Reload the page to see the changes
            }
        })
        .catch(error => console.error('Error saving show:', error));
            document.getElementById("addForm").reset();
            bootstrap.Modal.getInstance(document.getElementById("addModal")).hide();
        });

        function renderTable() {
            showTableBody.innerHTML = "";
            shows.forEach((show, index) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${show.theatreName}</td>
                    <td>${show.movieName}</td>
                    <td>${show.time}</td>
                    <td>${show.date}</td>
                    <td>${show.goldRow}</td>
                    <td>${show.goldColumn}</td>
                    <td>${show.goldPrice}</td>
                    <td>${show.silverRow}</td>
                    <td>${show.silverColumn}</td>
                    <td>${show.silverPrice}</td>
                    <td>${show.Sbooked}</td>
                    <td>${show.Gbooked}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editShow(${show.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteShow(${show.id})">Delete</button>
                    </td>
                `;
                showTableBody.appendChild(row);
            });
        }

        function editShow(id) {
    const show = shows.find((s) => s.id == id);
    if (show) {
        populateEditForm(show)
        document.getElementById("editTheatreName").value = show.theatreId;
        document.getElementById("editMovieName").value = show.movieId;
        document.getElementById("editTime").value = show.time;
        document.getElementById("editDate").value = show.date;
        document.getElementById("editGoldRow").value = show.goldRow;
        document.getElementById("editGoldColumn").value = show.goldColumn;
        document.getElementById("editGoldPrice").value = show.goldPrice;
        document.getElementById("editSilverRow").value = show.silverRow;
        document.getElementById("editSilverColumn").value = show.silverColumn;
        document.getElementById("editSilverPrice").value = show.silverPrice;
        document.getElementById("editsBooked").value = show.Sbooked;
        document.getElementById("editgBooked").value = show.Gbooked;

        // Save the id for updating
        document.getElementById("editForm").dataset.showId = id;
        const editModal = new bootstrap.Modal(document.getElementById("editModal"));
        editModal.show();
    }
}

document.getElementById("editForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const id = this.dataset.showId;
    const updatedShow = {
        show_id: id,
        theatreName: document.getElementById("editTheatreName").value,
        movieName: document.getElementById("editMovieName").value,
        time: document.getElementById("editTime").value,
        date: document.getElementById("editDate").value,
        gold_row: document.getElementById("editGoldRow").value,
        gold_col: document.getElementById("editGoldColumn").value,
        gold_price: document.getElementById("editGoldPrice").value,
        silver_row: document.getElementById("editSilverRow").value,
        silver_col: document.getElementById("editSilverColumn").value,
        silver_price: document.getElementById("editSilverPrice").value,
        silver_booked: document.getElementById("editsBooked").value,
        gold_booked: document.getElementById("editgBooked").value,
    };

    const formData = new FormData();
    for (let key in updatedShow) {
        formData.append(key, updatedShow[key]);
    }

    fetch("save_shows.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            alert(data.message);
            if (data.message === 'show saved successfully!') {
                window.location.reload();
            }
        })
        .catch((error) => console.error("Error updating show:", error));
});

        function deleteShow(index) {
            fetch(`delete_shows.php?id=${index}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Reload the page to see the changes
        })
        .catch(error => console.error('Error deleting movie:', error));
        }

        renderTable();
    </script>
<?php include 'footer.php'; ?>
