<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION["username"];
$role = $_SESSION["role"];

/* Attendance statistics */

$stats_query = "SELECT
                    COUNT(*) AS total_records,
                    COALESCE(SUM(men), 0) AS total_men,
                    COALESCE(SUM(women), 0) AS total_women,
                    COALESCE(SUM(children), 0) AS total_children,
                    COALESCE(SUM(total_attendance), 0) AS total_attendance
                FROM attendance";

$stats_result = $conn->query($stats_query);
$stats = $stats_result->fetch_assoc();

$total_records = $stats["total_records"];
$total_men = $stats["total_men"];
$total_women = $stats["total_women"];
$total_children = $stats["total_children"];
$total_attendance = $stats["total_attendance"];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Church Attendance System</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="dashboard-container">

    <header class="topbar">

        <div>
            <h2>Chapel Church Attendance System</h2>
            <p>Worship Services Attendance Records and Analytics</p>
        </div>

        <a href="logout.php" class="logout-btn">
            Logout
        </a>

    </header>


    <main class="dashboard-content">

        <div class="welcome">

            <h1>
                Welcome, <?php echo htmlspecialchars($username); ?>
            </h1>

            <p>
                Role:
                <?php echo htmlspecialchars($role); ?>
            </p>

        </div>


        <h2 class="section-title">
            Attendance Summary
        </h2>


        <div class="statistics-grid">

            <div class="stat-card">

                <h3>Total Attendance</h3>

                <strong>
                    <?php echo $total_attendance; ?>
                </strong>

                <p>Total people recorded</p>

            </div>


            <div class="stat-card">

                <h3>Attendance Records</h3>

                <strong>
                    <?php echo $total_records; ?>
                </strong>

                <p>Services recorded</p>

            </div>


            <div class="stat-card">

                <h3>Men</h3>

                <strong>
                    <?php echo $total_men; ?>
                </strong>

                <p>Total men recorded</p>

            </div>


            <div class="stat-card">

                <h3>Women</h3>

                <strong>
                    <?php echo $total_women; ?>
                </strong>

                <p>Total women recorded</p>

            </div>


            <div class="stat-card">

                <h3>Children</h3>

                <strong>
                    <?php echo $total_children; ?>
                </strong>

                <p>Total children recorded</p>

            </div>

        </div>


        <h2 class="section-title">
            System Functions
        </h2>


        <div class="dashboard-cards">

            <?php if ($role == "secretary"): ?>

                <a href="attendance.php" class="dashboard-card">

                    <h3>Record Attendance</h3>

                    <p>
                        Enter attendance information for a worship service.
                    </p>

                </a>

            <?php endif; ?>


            <a href="records.php" class="dashboard-card">

                <h3>Attendance Records</h3>

                <p>
                    View previously recorded attendance information.
                </p>

            </a>

        </div>

    </main>

</div>

</body>

</html>