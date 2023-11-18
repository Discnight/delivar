<?php

session_start();
require_once 'config/db.php';

if (isset($_POST['admin_signin'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $_SESSION['error'] = 'Please enter your email';
        header("location: admin_login.php");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Incorrect email format';
        header("location: admin_login.php");
    } elseif (empty($password)) {
        $_SESSION['error'] = 'Please enter your password';
        header("location: admin_login.php");
    } else {
        try {
            // Prevent SQL injection
            $check_data = $conn->prepare("SELECT * FROM admins WHERE a_email = :email");
            $check_data->bindParam(":email", $email);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {
                if ($email == $row['a_email']) {
                    if (password_verify($password, $row['a_password'])) {
                        $_SESSION['admin_login'] = $row['a_id'];
                        header("location: admin_index.php");
                    } else {
                        $_SESSION['error'] = 'Wrong password';
                        header("location: admin_login.php");
                    }
                } else {
                    $_SESSION['error'] = 'Wrong email';
                    header("location: admin_login.php");
                }
            } else {
                $_SESSION['error'] = 'No information found for this email';
                header("location: admin_login.php");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>
