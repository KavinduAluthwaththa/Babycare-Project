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
    <title>Mother Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
    <img src="<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Picture" width="150" height="150"><br>

    <h3>Your Babies</h3>
    <ul>
        <?php while ($baby = $babies->fetch_assoc()) { ?>
            <li>
                <?php echo $baby['name']; ?> (<?php echo $baby['gender']; ?>, DOB: <?php echo $baby['dob']; ?>)
                - <a href="vaccination_history.php?baby_id=<?php echo $baby['baby_id']; ?>">View Vaccination History</a>
            </li>
        <?php } ?>
    </ul>

    <a href="logout.php">Logout</a>
</body>
</html>
