<?php
    session_start();
    require_once('config/db.php');

    if (!isset($_SESSION['user_login'])) {
        $_SESSION['error'] = 'Please login!';
        header('location: login.php');
    }

    // Check if c_id is provided in the URL
    if (!isset($_GET['c_id'])) {
        $_SESSION['error'] = 'Car ID not provided!';
        header('location: user_index.php');
    }

    // Retrieve c_id from the URL
    $c_id = $_GET['c_id'];

    // Query to get car details and associated images based on c_id
    $query = 'SELECT cars.*, car_images.image_path
            FROM cars
            LEFT JOIN car_images ON cars.c_id = car_images.c_id
            WHERE cars.c_id = :c_id';

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':c_id', $c_id, PDO::PARAM_INT);
    $stmt->execute();
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the car with the provided c_id exists
    if (!$car) {
        $_SESSION['error'] = 'Car not found!';
        header('location: user_index.php');
    }

    // Query to get all images for the given c_id
    $queryImages = 'SELECT image_path FROM car_images WHERE c_id = :c_id';
    $stmtImages = $conn->prepare($queryImages);
    $stmtImages->bindParam(':c_id', $c_id, PDO::PARAM_INT);
    $stmtImages->execute();
    $images = $stmtImages->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $car['c_title']; ?> Details</title>
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
                    </form>
                </div>
            </div>
        </nav>

        <div class="container mt-3">
            <h2 class="d-flex justify-content-center"><?php echo $car['c_title']; ?></h2>
            <div class="row">
                <?php if (!empty($images)): ?>
                    <!-- Left-hand side: Display all images in a loop -->
                    <div class="col-md-6">
                        <div class="row g-2">
                            <?php foreach ($images as $image): ?>
                                <div class="col-6">
                                    <div class="p-3">
                                        <img src="<?php echo $image['image_path']; ?>" class="img-fluid" alt="Car Image">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Right-hand side: Car details -->
                <div class="col-md-6">
                    <div class="p-3">
                        <p>
                            Brand: <?php echo $car['c_brand']; ?>
                        </p>
                        <p>
                            Description: <?php echo $car['c_description']; ?>
                        </p>
                        <p>
                            Color: <?php echo $car['c_color']; ?>&nbsp;&nbsp;
                            Type: <?php echo $car['c_type']; ?>
                        </p>
                        <p>
                            Milerange: <?php echo $car['c_milerange']; ?>&nbsp;&nbsp;
                            Year: <?php echo $car['c_year']; ?>
                        </p>
                        <p>
                            Condition: <?php echo $car['c_condition']; ?>
                        </p>
                        <h2><?php echo $car['c_price']; ?> THB</h2>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

