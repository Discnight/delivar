<?php
    session_start();
    require_once('config/db.php');

    if (!isset($_SESSION['user_login'])) {
        $_SESSION['error'] = 'Please login!';
        header('location: login.php');
        exit;
    }

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Retrieve cars posted by the logged-in user
    $query = 'SELECT cars.c_id, cars.c_title, sellers.s_firstname, sellers.s_lastname, sellers.s_lineid, MAX(car_images.image_path) as image_path
            FROM cars JOIN sellers ON cars.s_id = sellers.s_id 
            JOIN car_images ON cars.c_id = car_images.c_id 
            GROUP BY cars.c_id, sellers.s_firstname, sellers.s_lastname, sellers.s_lineid 
            ORDER BY MAX(cars.c_id) DESC;';

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['user_login']['user_id']);
    $stmt->execute();
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Posted Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-warning">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_index">Delivar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php include('nav.php') ?>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <?php foreach ($cars as $car): ?>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card mb-3" style="width: 100%;">
                        <div class="row g-0">
                            <div class="col-md-5">
                                <?php if (isset($car['image_path']) && file_exists($car['image_path'])): ?>
                                    <img src="<?php echo $car['image_path']; ?>" class="img-fluid rounded-start" alt="Car Image" style="width: 100%; height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <p>Image Not Available</p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo $car['c_title']; ?>
                                    </h5>

                                    <p class="card-text">
                                        Seller: <?php echo $car['s_firstname'] . ' ' . $car['s_lastname']; ?><br>
                                        Line ID: <?php echo $car['s_lineid']; ?>
                                    </p>

                                    <!-- Add a delete button with a link to delete_car.php -->
                                    <a href="delete_car.php?c_id=<?php echo $car['c_id']; ?>" class="btn btn-danger">Delete Post</a>

                                    <a href="view_car.php?c_id=<?php echo $car['c_id']; ?>" class="btn btn-warning">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-5Qe3Nl8AKtP7jweE2dx4NM3dc8ha7Aq6ISxyL58Z1NlF0lFWYjKA1p6IxOfJKBCU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>