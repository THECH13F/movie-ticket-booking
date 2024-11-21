<?php include 'header.php'; ?>


<main class="col-md-9 mt-5 ms-sm-auto col-lg-10 px-md-4">
    <h2 class="text-center mb-4">Manage Theatre</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTheatreModal" style="float: right;">
        Add Theatre
    </button>

    <!-- Add Theatre Modal -->
    <div class="modal fade" id="addTheatreModal" tabindex="-1" aria-labelledby="addTheatreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTheatreModalLabel">Add New Theatre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newTheatreName" class="form-label">Theatre Name</label>
                        <input type="text" id="newTheatreName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="newTheatreLocation" class="form-label">Theatre Location</label>
                        <input type="text" id="newTheatreLocation" class="form-control" required>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="newCancellation">
                        <label class="form-check-label" for="newCancellation">Cancellation</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="newFoodBeverages">
                        <label class="form-check-label" for="newFoodBeverages">Food Beverages</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="newMTicket">
                        <label class="form-check-label" for="newMTicket">M_Ticket</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="addTheatre()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Theatre Modal -->
    <div class="modal fade" id="editTheatreModal" tabindex="-1" aria-labelledby="editTheatreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTheatreModalLabel">Add New Theatre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editTheatreName" class="form-label">Theatre Name</label>
                        <input type="hidden" id="editTheatreID" class="form-control" required>
                        <input type="text" id="editTheatreName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTheatreLocation" class="form-label">Theatre Location</label>
                        <input type="text" id="editTheatreLocation" class="form-control" required>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="editCancellation">
                        <label class="form-check-label" for="editCancellation">Cancellation</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="editFoodBeverages">
                        <label class="form-check-label" for="editFoodBeverages">Food Beverages</label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="editMTicket">
                        <label class="form-check-label" for="editMTicket">M_Ticket</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="saveEdit()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover mt-4">
        <thead class="table-dark">
            <tr>
                
                <th scope="col">Theatre Name</th>
                <th scope="col">Theatre Location</th>
                <th scope="col">Cancellation</th>
                <th scope="col">Food Beverages</th>
                <th scope="col">M_Ticket</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody id="theatreTableBody">
            <!-- JavaScript will populate rows here -->
        </tbody>
    </table>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const theatres = [
        <?php
                    $sql = "SELECT * FROM theater";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
        echo "{id:'".$row['theater_id']."', name: '".$row['theater_name']."', location: '".$row['theater_location']."', cancellation: ".$row['Cancellation'].", foodBeverages: ".$row['Food_Beverage'].", mTicket: ".$row['M_Ticket']." },";
                        }
                    }
                    ?>

    ];

    let currentEditIndex = null;

    function populateTable() {
        const tableBody = document.getElementById('theatreTableBody');
        tableBody.innerHTML = '';
        theatres.forEach((theatre, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${theatre.name}</td>
                <td>${theatre.location}</td>
                <td>${theatre.cancellation ? 'Yes' : 'No'}</td>
                <td>${theatre.foodBeverages ? 'Yes' : 'No'}</td>
                <td>${theatre.mTicket ? 'Yes' : 'No'}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTheatreModal" onclick="editRow(${theatre.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteRow(${theatre.id})">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    function addTheatre() {
    const name = document.getElementById('newTheatreName').value;
    const location = document.getElementById('newTheatreLocation').value;
    const cancellation = document.getElementById('newCancellation').checked ? 'true' : 'false'; // Convert to integer
    const foodBeverages = document.getElementById('newFoodBeverages').checked ? 'true' : 'false'; // Convert to integer
    const mTicket = document.getElementById('newMTicket').checked ? 'true' : 'false'; // Convert to integer

    if (name && location) {
        const formData = new FormData();
        formData.append('theater_name', name);
        formData.append('theater_location', location);
        formData.append('Cancellation', cancellation);
        formData.append('Food_Beverage', foodBeverages);
        formData.append('M_Ticket', mTicket);

        fetch('save_theater.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.message === 'theater saved successfully!') {
                window.location.reload();; // Reload the page to see the changes
            }
        })
        .catch(error => console.error('Error saving theater:', error));

        document.querySelector('#addTheatreModal .btn-close').click(); // Close modal
    } else {
        alert("Please fill in Theatre Name and Location.");
    }
}

    function clearAddForm() {
        document.getElementById('newTheatreName').value = '';
        document.getElementById('newTheatreLocation').value = '';
        document.getElementById('newCancellation').checked = false;
        document.getElementById('newFoodBeverages').checked = false;
        document.getElementById('newMTicket').checked = false;
    }
    function editRow(index) {
        currentEditIndex=index;
        const theatre=theatres[index];
        document.getElementById('editTheatreID').value=theatre.id;
        document.getElementById('editTheatreName').value=theatre.name;
        document.getElementById('editTheatreLocation').value=theatre.location;
        document.getElementById('editCancellation').checked=theatre.cancellation;
        document.getElementById('editFoodBeverages').checked=theatre.foodBeverages;
        document.getElementById('editMTicket').checked=theatre.mticket;
    }
    function saveEdit() {
        const id = document.getElementById('editTheatreID').value;
        const name = document.getElementById('editTheatreName').value;
        const location = document.getElementById('editTheatreLocation').value;
        const cancellation = document.getElementById('editCancellation').checked;
        const foodBeverages = document.getElementById('editFoodBeverages').checked;
        const mTicket = document.getElementById('editMTicket').checked;

        if (name && location) {
            const formData = new FormData();
        formData.append('theater_id', id);
        formData.append('theater_name', name);
        formData.append('theater_location', location);
        formData.append('Cancellation', cancellation);
        formData.append('Food_Beverage', foodBeverages);
        formData.append('M_Ticket', mTicket);

        fetch('save_theater.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.message === 'theater saved successfully!') {
                window.location.reload();; // Reload the page to see the changes
            }
        })
        .catch(error => console.error('Error saving theater:', error));
            document.querySelector('#editTheatreModal .btn-close').click(); // Close modal
        } else {
            alert("Please fill in Theatre Name and Location.");
        }
    }



    function deleteRow(index) {
        fetch(`delete_theater.php?id=${index}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Reload the page to see the changes
        })
        .catch(error => console.error('Error deleting movie:', error));
    }

    window.onload = populateTable;
</script>

<?php include 'footer.php'; ?>