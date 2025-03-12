<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Midwife') {
    header("Location: login.php");
    exit;
}
include 'DBcon.php';

// Fetch all mothers
$mothers = $conn->query("SELECT * FROM Users WHERE user_type='Mother'");

// Fetch upcoming vaccinations
$vaccinations = $conn->query("
    SELECT B.name AS baby_name, V.name AS vaccine_name, VR.vaccination_date 
    FROM VaccinationRecords VR
    JOIN Babies B ON VR.baby_id = B.baby_id
    JOIN Vaccinations V ON VR.vaccine_id = V.vaccine_id
    WHERE VR.status = 'Pending'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Midwife Dashboard</title>
</head>
<body>
    <h2>Welcome, Midwife <?php echo $_SESSION['name']; ?>!</h2>
    <img src="<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Picture" width="150" height="150"><br>

    <h3>Registered Mothers</h3>
    <ul>
        <?php while ($mother = $mothers->fetch_assoc()) { ?>
            <li><?php echo $mother['name']; ?> (<?php echo $mother['email']; ?>)</li>
        <?php } ?>
    </ul>

    <h3>Upcoming Vaccinations</h3>
    <ul>
        <?php while ($row = $vaccinations->fetch_assoc()) { ?>
            <li><?php echo $row['baby_name']; ?> - <?php echo $row['vaccine_name']; ?> (<?php echo $row['vaccination_date']; ?>)</li>
        <?php } ?>
    </ul>

    <a href="logout.php">Logout</a>
</body>
</html>
