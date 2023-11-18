<?php
session_start();
require_once 'config/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post_car"])) {
    try {
    // Retrieve seller information
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $telnum = $_POST["telnum"];
    $lineid = $_POST["lineid"];
    $payment = $_POST["payment"];
    $promptpay = $_POST["promptpay"];

    // Insert seller information into the sellers table
    $insertSellerQuery = "INSERT INTO sellers (s_firstname, s_lastname, s_telnum, s_lineid, s_payment, s_promptpay) 
                          VALUES (?, ?, ?, ?, ?, ?)";

    $stmtSeller = $conn->prepare($insertSellerQuery);
    $stmtSeller->bindParam(1, $firstname, PDO::PARAM_STR);
    $stmtSeller->bindParam(2, $lastname, PDO::PARAM_STR);
    $stmtSeller->bindParam(3, $telnum, PDO::PARAM_INT);
    $stmtSeller->bindParam(4, $lineid, PDO::PARAM_STR);
    $stmtSeller->bindParam(5, $payment, PDO::PARAM_STR);
    $stmtSeller->bindParam(6, $promptpay, PDO::PARAM_STR);
    $stmtSeller->execute();
    $sellerId = $conn->lastInsertId();
    

    // Retrieve car information
    $title = $_POST["title"];
    $carBrand = $_POST["car_brand"];
    $carColor = isset($_POST["car_color"]) ? $_POST["car_color"] : (isset($_POST["other"]) ? $_POST["other"] : null);
    $carType = $_POST["car_type"];
    $mileRange = $_POST["milerange"];
    $year = $_POST["year"];
    $condition = $_POST["condition"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    // Insert car information into the cars table
    $insertCarQuery = "INSERT INTO cars (c_title, c_brand, c_color, c_type, c_milerange, c_year, c_condition, c_description, c_price, s_id) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmtCar = $conn->prepare($insertCarQuery);
    $stmtCar->bindParam(1, $title, PDO::PARAM_STR);
    $stmtCar->bindParam(2, $carBrand, PDO::PARAM_STR);
    $stmtCar->bindParam(3, $carColor, PDO::PARAM_STR);
    $stmtCar->bindParam(4, $carType, PDO::PARAM_STR);
    $stmtCar->bindParam(5, $mileRange, PDO::PARAM_INT);
    $stmtCar->bindParam(6, $year, PDO::PARAM_INT);
    $stmtCar->bindParam(7, $condition, PDO::PARAM_STR);
    $stmtCar->bindParam(8, $description, PDO::PARAM_STR);
    $stmtCar->bindParam(9, $price, PDO::PARAM_INT);
    $stmtCar->bindParam(10, $sellerId, PDO::PARAM_INT);
    $stmtCar->execute();
    $carId = $conn->lastInsertId();
    
        // Handle multiple image uploads
        if (isset($_FILES['image'])) {
            $uploadedImages = $_FILES['image'];

            // Loop through each uploaded file
            foreach ($uploadedImages['tmp_name'] as $key => $tmpName) {
                // Check for upload errors
                if ($_FILES['image']['error'][$key] !== UPLOAD_ERR_OK) {
                    throw new Exception("Error uploading image.");
                }

                // Check if the file is an actual image
                if (getimagesize($tmpName)) {
                    $imageName = $uploadedImages['name'][$key];
                    $imagePath = 'upload_carimages/' . $imageName;

                    // Move the uploaded file to the desired directory
                    if (move_uploaded_file($tmpName, $imagePath)) {
                        // Insert image data into the 'car_images' table
                        $imageSql = "INSERT INTO car_images (c_id, image_path) VALUES (:carId, :imagePath)";
                        $imageStmt = $conn->prepare($imageSql);
                        $imageStmt->bindParam(':carId', $carId, PDO::PARAM_INT);
                        $imageStmt->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);
                        $imageStmt->execute();
                    } else {
                        throw new Exception("Error moving uploaded image to the destination directory.");
                    }
                } else {
                    throw new Exception("Invalid file type.");
                }
            }
        }

        // Redirect to a success page or do further processing if needed
        header("Location: user_index.php");
        exit();
    } catch (Exception $e) {
        // Handle exceptions and display error messages
        $_SESSION['error'] = $e->getMessage();
        header("Location: beseller.php");
        exit();
    }
} else {
    // Handle invalid requests or redirect to an error page
    $_SESSION['error'] = "Invalid request.";
    header("Location: beseller.php");
    exit();
}
?>
