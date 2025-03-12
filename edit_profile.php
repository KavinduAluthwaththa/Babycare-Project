<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'DBcon.php';

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type']; // Get user type

// Fetch current user details
$user_result = $conn->query("SELECT * FROM Users WHERE user_id = $user_id");
$user = $user_result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // Handle Profile Picture Upload
    if (!empty($_FILES["profile_picture"]["name"])) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . $file_name;
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);
    } else {
        $target_file = $user['profile_picture'];
    }

    // Update user details
    $sql = "UPDATE Users SET name='$name', email='$email', contact_number='$contact', profile_picture='$target_file' WHERE user_id=$user_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['name'] = $name; // Update session name
        $_SESSION['profile_picture'] = $target_file; // Update session profile picture

        // Redirect to correct dashboard
        if ($user_type == "Midwife") {
            header("Location: dashboard_midwife.php?success=updated");
        } else {
            header("Location: dashboard_mother.php?success=updated");
        }
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="assets/fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Profile</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name"><i class="zmdi zmdi-account"></i></label>
                <input type="text" name="name" value="<?php echo $user['name']; ?>" required />
            </div>
            <div class="form-group">
                <label for="email"><i class="zmdi zmdi-email"></i></label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required />
            </div>
            <div class="form-group">
                <label for="contact"><i class="zmdi zmdi-phone"></i></label>
                <input type="text" name="contact" value="<?php echo $user['contact_number']; ?>" required />
            </div>
            <div class="form-group">
                <label for="profile_picture"><i class="zmdi zmdi-camera"></i></label>
                <input type="file" name="profile_picture" accept="image/*">
            </div>
            <div class="form-group form-button">
                <button type="submit" class="form-submit">Save Changes</button>
            </div>
        </form>
        
        <!-- Back Button Redirects Based on User Type -->
        <a href="<?php echo ($user_type == 'Midwife') ? 'dashboard_midwife.php' : 'dashboard_mother.php'; ?>" class="back-button">Back</a>
    </div>
</body>
</html>
