<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Mother') {
    header("Location: login.php");
    exit;
}
include 'DBcon.php';

$baby_id = $_GET['baby_id'];

// Fetch baby details
$baby_result = $conn->query("SELECT * FROM babies WHERE baby_id = $baby_id");
$baby = $baby_result->fetch_assoc();

// Fetch vaccination history
$vaccinations = $conn->query("
    SELECT V.name AS vaccine_name, VR.vaccination_date, VR.due_date, VR.status 
    FROM vaccinationrecords VR
    JOIN vaccinations V ON VR.vaccine_id = V.vaccine_id
    WHERE VR.baby_id = $baby_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination History</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Vaccination History for <?php echo $baby['name']; ?></h2>
        </div>

        <div class="dashboard-section">
            <h3>Vaccine Records</h3>
            <div class="card-container">
                <?php while ($row = $vaccinations->fetch_assoc()) { ?>
                    <div class="card">
                        <h4><?php echo $row['vaccine_name']; ?></h4>
                        <p>Due Date: <?php echo $row['due_date']; ?></p>
                        <p>Status: <span class="<?php echo ($row['status'] == 'Completed') ? 'status-completed' : 'status-pending'; ?>">
                            <?php echo $row['status']; ?>
                        </span></p>
                        <?php if ($row['vaccination_date']) { ?>
                            <p>Vaccination Date: <?php echo $row['vaccination_date']; ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="dashboard-footer">
            <a href="dashboard_mother.php" class="back-button">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
