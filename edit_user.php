<?php 
    session_start();
    require_once('config/db.php');

    if(!isset($_SESSION['user_login'])) {
        $_SESSION['error'] = 'Please login!';
        header('location: login.php');
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>
    <div>
        <!-- navigation -->
        <nav class="navbar navbar-expand-lg bg-warning text-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="user_index.php">Delivar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <?php include('nav.php') ?>
                    <form class="d-flex" role="search">
                        <a href="beseller.php" class="btn btn-dark me-2">Be Seller</a>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                        <!-- <a href="user_info.php" class="btn btn-warning">Your account</a> -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#user_info">Your Account</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container mt-3">
            <form method="post" action="edit_user_db.php">
                <div class="mb-3">
                    <label for="firstname" class="form-label">Firstname</label>
                    <input type="text" class="form-control" name="firstname" aria-describedby="firstname">
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Lastname</label>
                    <input type="text" class="form-control" name="lastname" aria-describedby="lastname">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" aria-describedby="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="mb-3">
                    <label for="confirm password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="c_password">
                </div>
                <a href="user_index.php" class="btn btn-warning">Back</a>
                <button type="submit" name="save_changes" class="btn btn-success">Save Change</button>
            </form>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
</body>
</html>