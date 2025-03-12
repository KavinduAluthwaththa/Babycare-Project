<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Midwife') {
    header("Location: login.php");
    exit;
}
include 'DBcon.php';

if (isset($_GET['record_id'])) {
    $record_id = $_GET['record_id'];

    // Update vaccination record status and set vaccination date to today
    $sql = "UPDATE VaccinationRecords SET status = 'Completed', vaccination_date = CURDATE() WHERE record_id = $record_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard_midwife.php?success=marked");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Error: Invalid request!";
}
?>
