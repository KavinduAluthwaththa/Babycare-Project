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
        $target_file = $user['profile_picture']; // Keep existing profile picture if no new one is uploaded
    }

    // Update user details
    $sql = "UPDATE Users SET name='$name', email='$email', contact_number='$contact', profile_picture='$target_file' WHERE user_id=$user_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['name'] = $name; // Update session name
        $_SESSION['profile_picture'] = $target_file; // Update session profile picture

        // Redirect to correct dashboard
        $redirect_page = ($user_type == "Midwife") ? "dashboard_midwife.php" : "dashboard_mother.php";
        header("Location: $redirect_page?success=updated");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Profile | Baby Care System</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="assets/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="main">

        <!-- Edit Profile Form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Edit Profile</h2>
                        <form method="POST" class="register-form" id="edit-profile-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required />
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required />
                            </div>
                            <div class="form-group">
                                <label for="contact"><i class="zmdi zmdi-phone"></i></label>
                                <input type="text" name="contact" id="contact" value="<?php echo !empty($user['contact_number']) ? htmlspecialchars($user['contact_number']) : ''; ?>" placeholder="Enter Mobile Number" required />
                            </div>
                            <div class="form-group">
                                <label for="profile_picture"><i class="zmdi zmdi-camera"></i></label>
                                <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="update_profile" id="update_profile" class="form-submit" value="Save Changes"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="assets/img/HomeAbout.png" alt="Sign up image"></figure>
                        <a href="<?php echo ($user_type == 'Midwife') ? 'dashboard_midwife.php' : 'dashboard_mother.php'; ?>" class="signup-image-link">Back</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
