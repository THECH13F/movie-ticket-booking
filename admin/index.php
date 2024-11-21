<?php include 'header.php'; ?>
<?php
$sql="select count(*) from movies";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);
$total_movies=$row[0];

$sql="select count(*) from users";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);
$total_users=$row[0];

$sql="select count(*) from booking";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);
$total_orders=$row[0];

?>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <header class="pt-3 pb-2 mb-3 border-bottom">
                    <h1>Welcome, Admin!</h1>
                </header>

                <section id="dashboard">
                    <h2>Dashboard</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center bg-primary text-white mb-3">
                                <div class="card-body">
                                    <h3 class="card-title">Total Movies</h3>
                                    <p class="card-text"><?php echo $total_movies ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center bg-success text-white mb-3">
                                <div class="card-body">
                                    <h3 class="card-title">Total Users</h3>
                                    <p class="card-text"><?php echo $total_users ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center bg-warning text-white mb-3">
                                <div class="card-body">
                                    <h3 class="card-title">Total Bookings</h3>
                                    <p class="card-text"><?php echo $total_orders ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
<?php include 'footer.php'; ?>