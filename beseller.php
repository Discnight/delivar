<?php 

        session_start();
        require_once('config/db.php');
        // var_dump($_SESSION['user_login']);

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
    <title>Be Seller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>
    <!-- navigation -->
    <nav class="navbar navbar-expand-lg bg-warning text-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Delivar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php include('nav.php') ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <h3 class="mt-3"> Seller's information</h3>
        <form action="beseller_db.php" method="post" enctype="multipart/form-data">
            <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="firstname" class="form-label">First name</label>
                <input type="text" class="form-control" name="firstname" aria-describedby="firstname">
            </div>
            <div class="col-md-6">
                <label for="lastname" class="form-label">Last name</label>
                <input type="text" class="form-control" name="lastname" aria-describedby="lastname">
            </div>
            <div class="col-md-6">
                <label for="telnum" class="form-label">Telephone Number</label>
                <input type="text" class="form-control" name="telnum" aria-describedby="telnum">
            </div>
            <div class="col-md-6">
                <label for="lineid" class="form-label">Line ID</label>
                <input type="text" class="form-control" name="lineid" aria-describedby="lineid">
            </div>
            <div class="col-md-6">
                <label for="payment" class="form-label">Payment</label>
                <input type="text" class="form-control" name="payment" aria-describedby="payment">
            </div>
            <div class="col-md-6">
                <label for="promptpay" class="form-label">Promptpay</label>
                <input type="text" class="form-control" name="promptpay" aria-describedby="promptpay">
            </div>
        </div>
            <!-- <button type="submit" name="beseller_next" class="btn btn-warning">Next</button> -->

            <h3 class="mt-4">Car's details</h3>
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

                <!-- Dropdown menu for color selection -->
                <div class="dropdown">
                    <button class="btn btn-warning dropdown-toggle" type="button" id="colorDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Select Color
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="colorDropdown">
                        <li>
                            <div class="form-check">
                                <input class="form-check-input ms-1" type="radio" name="car_color" id="black" value="Black">
                                <label class="form-check-label" for="black">Black</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input class="form-check-input ms-1" type="radio" name="car_color" id="white" value="White">
                                <label class="form-check-label" for="white">White</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input class="form-check-input ms-1" type="radio" name="car_color" id="grey" value="Grey">
                                <label class="form-check-label" for="grey">Grey</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input class="form-check-input ms-1" type="radio" name="car_color" id="silver" value="Silver">
                                <label class="form-check-label" for="silver">Silver</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input class="form-check-input ms-1" type="radio" name="car_color" id="blue" value="Blue">
                                <label class="form-check-label" for="blue">Blue</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input class="form-check-input ms-1" type="radio" name="car_color" id="red" value="Red">
                                <label class="form-check-label" for="red">Red</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input class="form-check-input ms-1" type="radio" name="car_color" id="green" value="Green">
                                <label class="form-check-label" for="green">Green</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input class="form-check-input ms-1" type="radio" name="car_color" id="beige" value="Beige">
                                <label class="form-check-label" for="beige">Beige</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input class="form-check-input ms-1" type="radio" name="car_color" id="orange" value="Orange">
                                <label class="form-check-label" for="orange">Orange</label>
                            </div>
                        </li>
                        <li>
                            <div class="col ms-1">
                                <label for="other" class="form-label">Other</label>
                                <input type="text" class="form-control" name="other" aria-describedby="other">
                            </div>
                        </li>
                    </ul>
                </div>
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

            <a href="user_index.php" class="btn btn-warning mb-3" role="button">Back</a>
            <button type="submit" class="btn btn-warning mb-3" name="post_car">Post</button>
        </form>
    </div>


    <script>
    // Get the dropdown button and selected color display element
        const dropdownButton = document.getElementById('colorDropdown');
        const selectedColorDisplay = document.getElementById('selectedColorDisplay');

        // Add event listener to the radio buttons
        const colorRadioButtons = document.querySelectorAll('input[name="car_color"]');
        colorRadioButtons.forEach((radioButton) => {
            radioButton.addEventListener('change', function() {
                // Update the dropdown button text
                dropdownButton.innerText = this.value;
                // Display the selected color
                selectedColorDisplay.innerText = `Selected Color: ${this.value}`;
            });
        });
    </script>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>