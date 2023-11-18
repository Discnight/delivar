<?php 

    session_start();
    require_once 'config/db.php';

    

    if (isset($_POST['signin'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];


        if (empty($email)) {
            $_SESSION['error'] = 'please enter your email';
            header("location: login.php");
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'incorrect email type';
            header("location: login.php");
        } else if(empty($password)) {
            $_SESSION['error'] = 'Please enter your password';
            header("location: login.php");
        } else if(strlen($_POST['password']) >20 || strlen($_POST['password']) <5 ) {
            $_SESSION['error'] = 'Password does not match';
            header("location: login.php");
        } else {
            try{
                //prevent sql injection
                $check_data = $conn->prepare("SELECT * FROM users WHERE email = :email"); 
                $check_data->bindParam(":email", $email);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                if($check_data->rowCount() > 0) {

                    if($email == $row['email']) {
                        if(password_verify($password, $row['password'])) {
                            // if($row['urole'] == 'admin') {
                            //     $_SESSION['admin_login'] = $row['id'];
                            //     header("location: admin.php");
                            // } else {
                            //     $_SESSION['user_login'] = $row['id'];
                            //     header("location: user.php");
                            // }
                                $_SESSION['user_login'] = $row['id'];
                                header("location: user_index.php");
                        } else {
                            $_SESSION['error'] = 'Wrong password';
                            header("location: login.php");
                        }

                    } else {
                        $_SESSION['error'] = 'Wrong email';
                        header("location: login.php");
                    }   
                } else {
                    $_SESSION['error'] = 'No information';
                    header("location: login.php");
                }


            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        

        }  
}

?>