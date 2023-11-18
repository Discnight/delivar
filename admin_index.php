<?php 

        session_start();
        require_once('config/db.php');
        // var_dump($_SESSION['user_login']);
// test
        if(!isset($_SESSION['admin_login'])) {
            $_SESSION['error'] = 'Please login!';
            header('location: admin_login.php');
        }

        if (isset($_SESSION['admin_login'])) {
            $adminID = $_SESSION['admin_login'];
            $query = 'SELECT * FROM admins WHERE a_id = :id';
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $adminID);
            $stmt->execute();
            $admins = $stmt->fetch(PDO::FETCH_ASSOC);
        
        } else {
            echo "Admin is not logged in.";
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivar</title>
    <!-- <link href="bootstrap/scss/custom.scss" rel="stylesheet"> -->
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
                    <?php include('adminnav.php') ?>
                    <form class="d-flex" role="search">
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                        <!-- <a href="admin_info.php" class="btn btn-warning">Your account</a> -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#admin_info">Your Account</button>
    <!--                     <a href="login.php" class="btn btn-outline-primary">Login</a> -->
                    </form>
                </div>
            </div>
        </nav>


    <div class="container my-5">
    <div class="modal fade" id="admin_info" tabindex="-1" role="dialog" aria-labelledby="admin_infoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="admin_infoLabel">Admin Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your form here -->
                    <form id="admin_edit_form">
                        <!-- Form fields for first name, last name, email, password, and confirm password -->
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <div class="form-control" id="firstname" name="firstname"><?php echo $admins['a_firstname']; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <div class="form-control" id="lastname" name="lastname"><?php echo $admins['a_lastname']; ?></div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="email">Email</label>
                            <div class="form-control" id="email" name="email"><?php echo $admins['a_email']; ?></div>
                        </div>
                        <a href="edit_admin.php" class="btn btn-warning">Edit Information</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


    <script>
        $(document).ready(function () {
            $('#admin_edit_form').submit(function (e) {
                e.preventDefault(); // Prevent the default form submission
                // Add your code to handle the form data and update the user information
                // You can use AJAX to send the form data to the server
                // Close the modal after successful submission
                $('#admin_info').modal('hide');
            });
        });
    </script>



</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>