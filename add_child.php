<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Mother') {
    header("Location: login.php");
    exit;
}
include 'DBcon.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $baby_name = mysqli_real_escape_string($conn, $_POST['baby_name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $mother_id = $_SESSION['user_id'];

    // Insert child into Babies table
    $sql = "INSERT INTO Babies (name, dob, gender, mother_id) VALUES ('$baby_name', '$dob', '$gender', '$mother_id')";

    if ($conn->query($sql) === TRUE) {
        $baby_id = $conn->insert_id; // Get the new baby's ID

        // Fetch all vaccines and schedule them based on DOB
        $vaccines = $conn->query("SELECT vaccine_id, recommended_age FROM Vaccinations");

        while ($vaccine = $vaccines->fetch_assoc()) {
            $vaccine_id = $vaccine['vaccine_id'];
            $recommended_age = $vaccine['recommended_age'];

            // Calculate due date (DOB + recommended months)
            $due_date = date('Y-m-d', strtotime("+$recommended_age months", strtotime($dob)));

            // Insert into VaccinationRecords
            $conn->query("INSERT INTO vaccinationrecords (baby_id, vaccine_id, vaccination_date, due_date, status) 
                          VALUES ('$baby_id', '$vaccine_id', NULL, '$due_date', 'Pending')");
        }

        header("Location: dashboard_mother.php?success=child_added");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Child</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="assets/fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="form-container">
        <h2>Add Child</h2>
        <form method="POST">
            <div class="form-group">
                <label for="baby_name"><i class="zmdi zmdi-account"></i></label>
                <input type="text" name="baby_name" id="baby_name" placeholder="Child's Name" required />
            </div>
            <div class="form-group">
                <label for="dob"><i class="zmdi zmdi-calendar"></i></label>
                <input type="date" name="dob" id="dob" required />
            </div>
            <div class="form-group">
                <label for="gender"><i class="zmdi zmdi-male-female"></i></label>
                <select name="gender" id="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group form-button">
                <button type="submit" class="form-submit">Add Child</button>
            </div>
        </form>
        <a href="dashboard_mother.php" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>
