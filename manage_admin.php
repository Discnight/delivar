<?php
session_start();
require_once('config/db.php');

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'Please login!';
    header('location: admin_login.php');
}

if (isset($_SESSION['admin_login'])) {
    $adminID = $_SESSION['admin_login'];
    $query = 'SELECT * FROM admins';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $adminID);
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Admin is not logged in.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div>
        <!-- navigation -->
        <nav class="navbar navbar-expand-lg bg-warning text-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="user_index.php">Delivar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <?php include('adminnav.php') ?>
                    <form class="d-flex" role="search">
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#admin_info">Your Account</button>
                    </form>
                </div>
            </div>
        </nav>


        <div class="container mt-2">
        <h3>Manage Admin</h3>
        <a href="admin_signin.php" class="btn btn-warning">Create Admin</a>

        <?php
            // Iterate over the admins array
            for ($i = 0; $i < count($admins); $i += 2): ?>
                <div class="row">
                    <?php for ($j = $i; $j <= $i + 1 && $j < count($admins); $j++): ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="container mt-3">
                                <div class="card mb-3" style="max-width: 540px;">
                                    <div class="row g-0">
                                        <div class="card-body">
                                            <h5 class="card-title">Admin Information</h5>
                                            <p class="card-text">
                                                <strong>Name:</strong> <?php echo $admins[$j]['a_firstname'] . ' ' . $admins[$j]['a_lastname']; ?><br>
                                                <strong>Email:</strong> <?php echo $admins[$j]['a_email']; ?>
                                            </p>
                                            <a href="edit_alladmin.php?a_id=<?php echo $admins[$j]['a_id']; ?>" class="btn btn-warning">Edit</a>
                                            <a href="delete_admin_db.php?a_id=<?php echo $admins[$j]['a_id']; ?>" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
