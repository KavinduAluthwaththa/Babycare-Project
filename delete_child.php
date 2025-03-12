<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Mother') {
    header("Location: login.php");
    exit;
}
include 'DBcon.php';

if (isset($_GET['baby_id'])) {
    $baby_id = $_GET['baby_id'];
    $mother_id = $_SESSION['user_id'];

    // Check if the child belongs to the logged-in mother
    $check = $conn->query("SELECT * FROM Babies WHERE baby_id = $baby_id AND mother_id = $mother_id");

    if ($check->num_rows > 0) {
        // Delete vaccination records first (to maintain referential integrity)
        $conn->query("DELETE FROM VaccinationRecords WHERE baby_id = $baby_id");

        // Now delete the child
        $conn->query("DELETE FROM Babies WHERE baby_id = $baby_id");

        header("Location: dashboard_mother.php?success=child_deleted");
        exit;
    } else {
        echo "Error: Unauthorized action!";
    }
} else {
    echo "Error: Invalid request!";
}
?>
