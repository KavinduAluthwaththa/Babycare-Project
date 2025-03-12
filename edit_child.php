<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Mother') {
    header("Location: login.php");
    exit;
}
include 'DBcon.php';

$baby_id = $_GET['baby_id'];
$mother_id = $_SESSION['user_id'];

// Fetch child's details
$baby_result = $conn->query("SELECT * FROM Babies WHERE baby_id = $baby_id AND mother_id = $mother_id");
$baby = $baby_result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    // Update child's details
    $sql = "UPDATE Babies SET name='$name', dob='$dob', gender='$gender' WHERE baby_id=$baby_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard_mother.php?success=child_updated");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Child</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="assets/fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Child</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name"><i class="zmdi zmdi-account"></i></label>
                <input type="text" name="name" value="<?php echo $baby['name']; ?>" required />
            </div>
            <div class="form-group">
                <label for="dob"><i class="zmdi zmdi-calendar"></i></label>
                <input type="date" name="dob" value="<?php echo $baby['dob']; ?>" required />
            </div>
            <div class="form-group">
                <label for="gender"><i class="zmdi zmdi-male-female"></i></label>
                <select name="gender" required>
                    <option value="Male" <?php if($baby['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if($baby['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
            <div class="form-group form-button">
                <button type="submit" class="form-submit">Save Changes</button>
            </div>
        </form>

        <!-- Back Button Always Goes to Parent Dashboard -->
        <a href="dashboard_mother.php" class="back-button">Back</a>
    </div>
</body>
</html>
