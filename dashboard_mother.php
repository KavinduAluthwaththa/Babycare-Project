<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Mother') {
    header("Location: login.php");
    exit;
}
include 'DBcon.php';

$user_id = $_SESSION['user_id'];

// Get mother’s babies
$babies = $conn->query("SELECT * FROM Babies WHERE mother_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mother Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Styles/dashboard.css">
</head>
<body>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
        <img src="<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Picture" class="profile-picture">
    </div>

    <div class="dashboard-section">
        <h3>Your Babies</h3>
        <div class="card-container">
            <?php while ($baby = $babies->fetch_assoc()) { ?>
                <div class="card">
                    <h4><?php echo $baby['name']; ?></h4>
                    <p><?php echo $baby['gender']; ?> | DOB: <?php echo $baby['dob']; ?></p>
                    <a href="vaccination_history.php?baby_id=<?php echo $baby['baby_id']; ?>">View Vaccination History</a>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="dashboard-footer">
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</div>

</body>
</html>
