<?php 

    session_start();
    require_once('config/db.php');

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
 
    $query = 'SELECT cars.c_id, cars.c_title, sellers.s_firstname, sellers.s_lastname, sellers.s_lineid, MAX(car_images.image_path) as image_path
    FROM cars JOIN sellers ON cars.s_id = sellers.s_id 
    JOIN car_images ON cars.c_id = car_images.c_id 
    GROUP BY cars.c_id, sellers.s_firstname, sellers.s_lastname, sellers.s_lineid 
    ORDER BY MAX(cars.c_id) DESC;
    ';
                            // <!-- this is for testing -->

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['unsetError'])) {
        unset($_SESSION['error']);
        // You can send a response if needed
        echo json_encode(['success' => true]);
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivar</title>
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
                        <a href="login.php" class="btn btn-dark me-3">Login</a>
                        <!-- <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#user_info">Login</button> -->
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
                                        <a href="view_car.php" class="btn btn-warning">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endfor; ?>
        </div>


        <footer>
            <?php include('footer.php')?>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>