<?php 

        session_start();
        require_once('config/db.php');
        // var_dump($_SESSION['user_login']);

        if(!isset($_SESSION['user_login'])) {
            $_SESSION['error'] = 'Please login!';
            header('location: login.php');
        }
        
        $query = 'SELECT cars.c_id, cars.c_title, sellers.s_firstname, sellers.s_lastname, sellers.s_lineid, MAX(car_images.image_path) as image_path
        FROM cars JOIN sellers ON cars.s_id = sellers.s_id 
        JOIN car_images ON cars.c_id = car_images.c_id 
        GROUP BY cars.c_id, sellers.s_firstname, sellers.s_lastname, sellers.s_lineid 
        ORDER BY MAX(cars.c_id) DESC;';
        
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_SESSION['user_login'])) {
            $userID = $_SESSION['user_login'];
            $query = 'SELECT * FROM users WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $userID);
            $stmt->execute();
            $users = $stmt->fetch(PDO::FETCH_ASSOC);
        
        } else {
            echo "User is not logged in.";
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> <!-- add this -->

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
                        <i class="bi bi-person" id="user-circle-icon" style='margin-left: 5px;' data-bs-toggle="modal" data-bs-target="#user_info"></i>

                        <!-- <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#user_info">Your Account</button> -->

                        
    <!--                     <a href="login.php" class="btn btn-outline-primary">Login</a> -->
                    </form>
                </div>
            </div>
        </nav>


    <div class="container my-5">
    <?php
    // Iterate over the cars array in pairs
    for ($i = 0; $i < count($cars); $i += 2): ?>
        <div class="row">
            <?php for ($j = $i; $j <= $i + 1 && $j < count($cars); $j++): ?>
                <div class="col-lg-6 col-md-12">
                    <div class="card mb-3" style="width: 100%;">
                        <div class="row g-0">
                            <div class="col-md-5">
                                <?php if (isset($cars[$j]['image_path']) && file_exists($cars[$j]['image_path'])): ?>
                                    <img src="<?php echo $cars[$j]['image_path']; ?>" class="img-fluid rounded-start" alt="Car Image" style="width: 100%; height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <p>Image Not Available</p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <?php
                                    // Truncate c_title to 20 characters
                                    $truncatedTitle = strlen($cars[$j]['c_title']) > 20 ? substr($cars[$j]['c_title'], 0, 20) . '...' : $cars[$j]['c_title'];
                                    ?>
                                    <h5 class="card-title"><?php echo $truncatedTitle; ?></h5>

                                    <p class="card-text">
                                        Seller: <?php echo $cars[$j]['s_firstname'] . ' ' . $cars[$j]['s_lastname']; ?><br>
                                        Line ID: <?php echo $cars[$j]['s_lineid']; ?>
                                    </p>
                                    <a href="view_car.php?c_id=<?php echo $cars[$j]['c_id']; ?>" class="btn btn-warning">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    <?php endfor; ?>
    </div>

    <div class="modal fade" id="user_info" tabindex="-1" role="dialog" aria-labelledby="user_infoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="user_infoLabel">User Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your form here -->
                    <form id="editForm">
                        <!-- Form fields for first name, last name, email, password, and confirm password -->
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <div class="form-control" id="firstname" name="firstname"><?php echo $users['firstname']; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <div class="form-control" id="lastname" name="lastname"><?php echo $users['lastname']; ?></div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="email">Email</label>
                            <div class="form-control" id="email" name="email"><?php echo $users['email']; ?></div>
                        </div>
                        <a href="edit_user.php" class="btn btn-warning">Edit Information</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Add a click event handler to the icon
            $('#user-circle-icon').click(function () {
                // Show the modal by targeting its ID
                $('#user_info').modal('show');
            });
        });
    </script>




</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>