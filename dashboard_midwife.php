<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Midwife') {
    header("Location: login.php");
    exit;
}
include 'DBcon.php';

// Fetch all mothers
$mothers = $conn->query("SELECT * FROM Users WHERE user_type='Mother'");

// Fetch upcoming vaccinations (within the next 7 days)
$vaccinations = $conn->query("
    SELECT VR.record_id, B.name AS baby_name, V.name AS vaccine_name, VR.due_date 
    FROM VaccinationRecords VR
    JOIN Babies B ON VR.baby_id = B.baby_id
    JOIN Vaccinations V ON VR.vaccine_id = V.vaccine_id
    WHERE VR.status = 'Pending' AND VR.due_date <= CURDATE() + INTERVAL 30 DAY
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Midwife Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Welcome, Midwife <?php echo $_SESSION['name']; ?>!</h2>
            <img src="<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Picture" class="profile-picture">
        </div>

        <div class="dashboard-section">
            <h3>Registered Mothers</h3>
            <div class="card-container">
                <?php while ($mother = $mothers->fetch_assoc()) { ?>
                    <div class="card">
                        <h4><?php echo $mother['name']; ?></h4>
                        <p>Email: <?php echo $mother['email']; ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="dashboard-section">
            <h3>Upcoming Vaccinations</h3>
            <div class="card-container">
                <?php while ($row = $vaccinations->fetch_assoc()) { ?>
                    <div class="card">
                        <h4><?php echo $row['baby_name']; ?></h4>
                        <p>Vaccine: <?php echo $row['vaccine_name']; ?></p>
                        <p>Date: <?php echo $row['due_date']; ?></p>
                        <a href="mark_administered.php?record_id=<?php echo $row['record_id']; ?>" class="administer-button" 
                           onclick="return confirm('Are you sure you want to mark this vaccine as administered?');">
                            Mark as Administered
                        </a>
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
