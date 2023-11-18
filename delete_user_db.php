<?php
    session_start();
    require_once('config/db.php');

    if (isset($_GET['id'])) {
        $userID = $_GET['id'];

        try {
            // Prepare and execute the DELETE query
            $query = 'DELETE FROM users WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $userID);
            $stmt->execute();

            $_SESSION['success'] = 'User deleted successfully.';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Error deleting user: ' . $e->getMessage();
        }
    }

    // Redirect back to the page where you display users
    header('location: admin_edit_user.php'); 
    exit();
?>
