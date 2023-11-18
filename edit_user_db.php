<?php
    session_start();
    require_once('config/db.php');

    error_reporting(E_ALL);
    ini_set('display_errors', 1);


    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_changes'])) {
        // Retrieve user input
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Note: You should handle password hashing securely.

        // Assuming you have a 'user_id' in your session
        $userId = $_SESSION['user_login'];

        // Validate input (Add your validation logic here)

        // Update user information in the database
        $stmt = $conn->prepare("UPDATE users SET firstname=?, lastname=?, email=?, password=? WHERE id=?");
        $stmt->execute([$firstname, $lastname, $email, $password, $userId]);

        // Redirect the user back to the profile page or another appropriate page
        header('location: user_index.php');
        exit();
    } else {
        // Handle invalid request (optional)
        header('location: login.php');
        exit();
}
