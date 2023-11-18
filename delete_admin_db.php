<?php
    session_start();
    require_once('config/db.php');

    if (isset($_GET['a_id'])) {
        $adminID = $_GET['a_id'];

        try {
            // Prepare and execute the DELETE query
            $query = 'DELETE FROM admins WHERE a_id = :id';
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $adminID);
            $stmt->execute();

            $_SESSION['success'] = 'Admin deleted successfully.';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Error deleting admin: ' . $e->getMessage();
        }
    }

    // Redirect back to the page where you display admins
    header('location: manage_admin.php');
    exit();
?>
