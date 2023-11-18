<?php

session_start();
require_once 'config/db.php';

if (isset($_POST['admin_signup'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($c_password)) {
        $_SESSION['error'] = 'All fields are required';
        header("location: admin_signin.php");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Incorrect email type (for example: @gmail.com)';
        header("location: admin_signin.php");
    } elseif (strlen($password) > 20 || strlen($password) < 5) {
        $_SESSION['error'] = 'Password needs to be 5 - 20 characters only';
        header("location: admin_signin.php");
    } elseif ($password != $c_password) {
        $_SESSION['error'] = 'Password does not match';
        header("location: admin_signin.php");
    } else {
        try {
            // Prevent SQL injection
            $check_email = $conn->prepare("SELECT a_email FROM admins WHERE a_email = :email");
            $check_email->bindParam(":email", $email);
            $check_email->execute();
            $row = $check_email->fetch(PDO::FETCH_ASSOC);

            if ($row['a_email'] == $email) {
                $_SESSION['warning'] = "This email already exists. <a href='admin_login.php'>Click here</a> to sign in";
                header("location: admin_login.php");
            } elseif (!isset($_SESSION['error'])) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO admin(a_firstname, a_lastname, a_email, a_password) 
                                        VALUES(:firstname, :lastname, :email, :password)");
                $stmt->bindParam(":firstname", $firstname);
                $stmt->bindParam(":lastname", $lastname);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":password", $passwordHash);
                $stmt->execute();
                $_SESSION['success'] = "Sign up successful! <a href='admin_login.php' class='alert-link'>Click here</a> to sign in";
                header("location: admin_login.php");
            } else {
                $_SESSION['error'] = "There are some mistakes";
                header("location: admin_admin_signin.php");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>
