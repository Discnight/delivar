<?php 

    session_start();
    require_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car's information</title>
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
        <h3 class="mt-4">Car's details</h3>
        <hr>
        <form action="input_car_db.php"  method="post" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" aria-describedby="title">
                </div>
                <div class="col-md-6">
                    <label for="car_brand" class="form-label">Car Brand</label>
                    <input type="text" class="form-control" name="car_brand" aria-describedby="car_brand">
                </div>
                <div class="col-md-6">
                    <label for="car_color" class="form-label">Car Color</label>
                    <input type="text" class="form-control" name="car_color" aria-describedby="car_color">
                </div>
                <div class="col-md-6">
                    <label for="car_type" class="form-label">Car Type</label>
                    <input type="text" class="form-control" name="car_type">
                </div>
                <div class="col-md-6">
                    <label for="milerange" class="form-label">Milerange</label>
                    <input type="text" class="form-control" name="milerange">
                </div>
                <div class="col-md-6">
                    <label for="year" class="form-label">Year</label>
                    <input type="text" class="form-control" name="year">
                </div>
                <div class="col-md-6">
                    <label for="condition" class="form-label">Condition</label>
                    <input type="text" class="form-control" name="condition">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control" name="price">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image[]" multiple>
                </div>

            </div>

            <a href="Beseller.php" class="btn btn-warning " role="button">Back</a>
            <button type="submit" class="btn btn-warning" name="post_car">Post</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
