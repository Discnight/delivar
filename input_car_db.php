<?php
    session_start();
    require_once 'config/db.php';

    $seller_firstname = $_POST['firstname'];
    $seller_lastname = $_POST['lastname'];
    $seller_telnum = $_POST['telnum'];
    $seller_lineid = $_POST['lineid'];
    $seller_payment = $_POST['payment'];
    $seller_promptpay = $_POST['promptpay'];

    // Insert seller information into the sellers table
    $sql = "INSERT INTO sellers (s_firstname, s_lastname, s_telnum, s_lineid, s_payment, s_promptpay) VALUES (:seller_firstname, :seller_lastname, :seller_telnum, :seller_lineid, :seller_payment, :seller_promptpay)";
    $stmt = $conn->prepare($sql);
    $sellerStmt->bindParam(':seller_firstname', $seller_firstname);
    $sellerStmt->bindParam(':seller_lastname', $seller_lastname);
    $sellerStmt->bindParam(':seller_telnum', $seller_telnum);
    $sellerStmt->bindParam(':seller_lineid', $seller_lineid);
    $sellerStmt->bindParam(':seller_payment', $seller_payment);
    $sellerStmt->bindParam(':seller_promptpay', $seller_promptpay);
    $stmt->execute();

    // Get the seller ID of the inserted seller
    $seller_id = $conn->insert_id;

    // Insert car information into the cars table
    $car_title = $_POST['title'];
    $car_brand = $_POST['car_brand'];
    $car_color = $_POST['car_color'];
    $car_type = $_POST['car_type'];
    $car_milerange = $_POST['milerange'];
    $car_year = $_POST['year'];
    $car_condition = $_POST['condition'];
    $car_description = $_POST['description'];
    $car_price = $_POST['price'];

    $sql = "INSERT INTO cars (c_title, c_brand, c_color, c_type, c_milerange, c_year, c_condition, c_description, c_price, s_id) VALUES (:car_title, :car_brand, :car_color, :car_type, :car_milerange, :car_year, :car_condition, :car_description, :car_price, :car_sellerId)";
    $stmt = $conn->prepare($sql);
    $carStmt->bindParam(':title', $car_title);
    $carStmt->bindParam(':carBrand', $car_brand);
    $carStmt->bindParam(':carColor', $car_color);
    $carStmt->bindParam(':carType', $car_type);
    $carStmt->bindParam(':milerange', $car_milerange);
    $carStmt->bindParam(':year', $car_year);
    $carStmt->bindParam(':condition', $car_condition);
    $carStmt->bindParam(':description', $car_description);
    $carStmt->bindParam(':price', $car_price);
    $carStmt->bindParam(':sellerId', $sellerId);
    $stmt->execute();

    // Get the car ID of the inserted car
    $car_id = $conn->insert_id;

    // Upload multiple images for the car
    foreach ($_FILES['image']['name'] as $key => $image) {
        $image_name = $image;
        $image_path = 'upload_carimages/' . $image_name;

        move_uploaded_file($_FILES['image']['tmp_name'][$key], $image_path);

        // Insert car image information into the car_images table
        $sql = "INSERT INTO car_images (c_id, image_path) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $car_id, $image_path);
        $stmt->execute();
    }

    // Close the database connection
    $conn->close();

    // Redirect to the car list page
    header("Location: car_list.php");

?>