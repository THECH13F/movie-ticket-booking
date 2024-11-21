<?php include 'header.php'; ?>

<main class="col-md-9 mt-5 ms-sm-auto col-lg-10 px-md-4">
        <h2>View Users</h2>
        
        <button class="btn btn-primary" onclick="openaddModal()">Add User</button>
        <div class="table-responsive table-container">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>User Password</th>
                        <th>User Phone</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT * FROM users";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                            echo "<td>".$row['user_name']."</td>";
                            echo "<td>".$row['user_email']."</td>";
                            echo "<td>".$row['user_password']."</td>";
                            echo "<td>".$row['user_phone']."</td>";
                            echo "<td>".$row['user_type']."</td>";
                            echo "<td>";
                                echo "<button class='btn btn-primary btn-edit' data-bs-toggle='modal' onclick=openEdituserModal('".$row['user_id']."')>Edit</button>    
                                <button class='btn btn-danger btn-delete' data-bs-toggle='modal' onclick=openDeleteModal('".$row['user_id']."')>Delete</button>";
                            echo "</td>";
                            echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No Users found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </main>
<!-- ADD Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form  id="adduserform" enctype="multipart/form -data" method="POST" action="save_user.php">
                        <div class="mb-3">
                        <!-- <input type="hidden" name="user_id" id="edituserId"> -->
                            <label for="userName" class="form-label">User Name</label>
                            <input type="text" class="form-control" name="user_name" id="userName" value="John Doe">
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">User Email</label>
                            <input type="email" class="form-control" name="user_email" id="userEmail" value="john.doe@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label">User Password</label>
                            <input type="password" class="form-control" name="user_password" id="userPassword" value="123456">
                        </div>
                        <div class="mb-3">
                            <label for="userPhone" class="form-label">User Phone</label>
                            <input type="text" class="form-control" name="user_phone" id="userPhone" value="+123456789">
                        </div>
                        <div class="mb-3">
                            <label for="userType" class="form-label">User Type</label>
                            <select class="form-select" name="user_type" id="userType">
                                <option selecte value="user"d>User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMovieForm" enctype="multipart/form-data" method="POST" action="save_user.php">
                    <input type="hidden" name="user_id" id="edituserId">
                    <div class="mb-3">
                        <label for="edituserName" class="form-label">User Name</label>
                        <input type="text" class="form-control" name="user_name" id="edituserName">
                    </div>
                    <div class="mb-3">
                        <label for="edituserEmail" class="form-label">User Email</label>
                        <input type="email" class="form-control" name="user_email" id="edituserEmail">
                    </div>
                    <div class="mb-3">
                        <label for="edituserPassword" class="form-label">User Password</label>
                        <input type="password" class="form-control" name="user_password" id="edituserPassword" placeholder="Leave blank to keep current password">
                    </div>
                    <div class="mb-3">
                        <label for="edituserPhone" class="form-label">User Phone</label>
                        <input type="text" class="form-control" name="user_phone" id="edituserPhone">
                    </div>
                    <div class="mb-3">
                        <label for="edituserType" class="form-label">User Type</label>
                        <select class="form-select" name="user_type" id="edituserType">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
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
            function openaddModal() {
        const addModal = new bootstrap.Modal(document.getElementById('addModal'));
        addModal.show();
    }
    function openDeleteModal(movieId) {
    // document.getElementById('deleteMovieName').textContent = movieName;
    document.getElementById('confirmDeleteButton').onclick = function() {
        confirmDelete(movieId);
    };
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function confirmDelete(movieId) {
    fetch(`delete_user.php?id=${movieId}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Reload the page to see the changes
        })
        .catch(error => console.error('Error deleting movie:', error));
}
    function openEdituserModal(userId) {
    fetch(`get_user.php?id=${userId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edituserId').value = data.user_id;
            document.getElementById('edituserName').value = data.user_name;
            document.getElementById('edituserEmail').value = data.user_email;
            document.getElementById('edituserPhone').value = data.user_phone;
            document.getElementById('edituserType').value = data.user_type;
            // Leave password field empty if admin doesn't want to change it
            document.getElementById('edituserPassword').value = '';
            
            // Show the modal
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        })
        .catch(error => console.error('Error fetching user data:', error));
}

document.getElementById('adduserform').onsubmit = function(event) {
    event.preventDefault(); // Prevent default form submission
    const formData = new FormData(this);
    fetch('save_user.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.message === 'User saved successfully!') {
            location.reload(); // Reload the page to see the changes
        }
    })
    .catch(error => console.error('Error saving User:', error));
};

document.getElementById('editMovieForm').onsubmit = function(event) {
    event.preventDefault(); // Prevent default form submission
    const formData = new FormData(this);
    fetch('save_user.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.message === 'User saved successfully!') {
            location.reload(); // Reload the page to see the changes
        }
    })
    .catch(error => console.error('Error saving user:', error));
};
    </script>
<?php include 'footer.php'; ?>