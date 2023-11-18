<?php
    session_start();
    require_once('config/db.php');

    if (!isset($_SESSION['user_login'])) {
        $_SESSION['error'] = 'Please login!';
        header('location: login.php');
    }
    // $userID = 1; // Replace with the actual user ID or use a session variable
    // // $userID = $_SESSION['user_id']; // Assuming you have a session variable named 'user_id'
    // $query = 'SELECT * FROM users WHERE id = :id';
    // $stmt = $conn->prepare($query);
    // $stmt->bindParam(':id', $userID); // Bind the user ID parameter
    // $stmt->execute();
    // $users = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($_SESSION['user_login'])) {
        // Retrieve the user ID from the session
        $userID = $_SESSION['user_login'];
        // Use the user ID in your database query
        $query = 'SELECT * FROM users WHERE id = :id';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $userID);
        $stmt->execute();
        $users = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Now, $user contains the information of the logged-in user
    } else {
        // Handle the case where the user is not logged in
        echo "User is not logged in.";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>

    <nav class="navbar navbar-expand-lg bg-warning">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_index.php">Delivar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php include('nav.php') ?>
                <form class="d-flex" role="search">       
                </form>
            </div>
        </div>
    </nav>


    <div class="container">
        <h3 class="mt-4">Your Information</h3>
        <hr>
            <div class="mb-3">
                <label for="firstname" class="form-label">First name</label>
                <input type="text" class="form-control" name="firstname" aria-describedby="firstname" placeholder="<?php echo $users['firstname'];?>">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last name</label>
                <input type="text" class="form-control" name="lastname" aria-describedby="lastname" placeholder="<?php echo $users['lastname'];?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="email" placeholder="<?php echo $users['email'];?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <a href="user_index.php" class="btn btn-warning " role="button">Back</a>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">Edit Info</button>
        
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your form here -->
                    <form id="editForm">
                        <!-- Form fields for first name, last name, email, password, and confirm password -->
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input type="text" class="form-control" id="firstname" name="firstname">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="cf_password">Confirm Password</label>
                            <input type="text" class="form-control mb-2" id="cf_password" name="cf_password">
                        </div>
                        <!-- Add similar form fields for last name, email, password, and confirm password -->

                        <button type="submit" class="btn btn-warning">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#editForm').submit(function (e) {
                e.preventDefault(); // Prevent the default form submission
                // Add your code to handle the form data and update the user information
                // You can use AJAX to send the form data to the server
                // Close the modal after successful submission
                $('#editModal').modal('hide');
            });
        });
    </script>


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>