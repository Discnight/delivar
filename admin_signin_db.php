<?php 

    session_start();
    require_once 'config/db.php'; 

    if (isset($_POST['admin_signup'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        // $urole = 'user';
        

        if(empty($firstname)) {
            $_SESSION['error'] = 'Please enter your firstname';
            header("location: admin_signin.php");
        } else if(empty($lastname)) {
            $_SESSION['error'] = 'Please enter your lastname';
            header("location: admin_signin.php");
        } else if(empty($email)) {
            $_SESSION['error'] = 'Please enter your email';
            header("location: admin_signin.php");
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Incorrect email type (for example: @gmail.com)';
            header("location: admin_signin.php");
        } else if(empty($password)) {
            $_SESSION['error'] = 'Please enter your password';
            header("location: admin_signin.php");
        } else if(strlen($_POST['password']) >20 || strlen($_POST['password']) <5 ) {
            $_SESSION['error'] = 'Password need to be 5 - 20 character only';
            header("location: admin_signin.php");
        } else if(empty($c_password)) {
            $_SESSION['error'] = 'Please confirm your password';
            header("location: admin_signin.php");
        } else if ($password != $c_password) {
            $_SESSION['error'] = 'Password not match';
            header("location: admin_signin.php");
        } else {
            try{
                //prevent sql injection
                $check_email = $conn->prepare("SELECT a_email FROM admins WHERE a_email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);

                if($row['email'] == $email) {
                    $_SESSION['warning'] = "this email already exist <a href='admin_signin.php'>click here</a> to sign in";
                    header("location: admin_login.php");
                } elseif (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO admins(a_firstname, a_lastname, a_email, a_password) 
                                            VALUES(:firstname, :lastname, :email, :password)"); //urole :urole
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    // $stmt->bindParam(":urole", $urole);
                    $stmt->execute();
                    $_SESSION['success'] = "Sign up successful! <a href='admin_login.php' class='alert-link'>click here</a> to sign in";
                    header("location: admin_login.php");
                } else {
                    $_SESSION['error'] = "There are some mistake";
                    header("location: admin_signin.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
        

    }

?>