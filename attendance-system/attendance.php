<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $service_date = $_POST["service_date"];
    $men = (int) $_POST["men"];
    $women = (int) $_POST["women"];
    $children = (int) $_POST["children"];

    $total_attendance = $men + $women + $children;

    $recorded_by = $_SESSION["user_id"];

    $stmt = $conn->prepare(
        "INSERT INTO attendance
        (service_date, men, women, children, total_attendance, recorded_by)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "siiiii",
        $service_date,
        $men,
        $women,
        $children,
        $total_attendance,
        $recorded_by
    );

    if ($stmt->execute()) {
        $message = "Attendance recorded successfully.";
    } else {
        $message = "Error recording attendance.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Record Attendance</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="page-container">

    <header class="topbar">

        <div>
            <h2>Chapel Church Attendance System</h2>
            <p>Record Worship Service Attendance</p>
        </div>

        <a href="dashboard.php" class="logout-btn">Dashboard</a>

    </header>

    <main class="form-container">

        <div class="form-box">

            <h1>Record Attendance</h1>

            <p class="form-description">
                Enter the attendance information provided by the ushers.
            </p>

            <?php if ($message != ""): ?>

                <div class="success-message">
                    <?php echo $message; ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <label>Service Date</label>

                <input
                    type="date"
                    name="service_date"
                    required
                >

                <label>Men</label>

                <input
                    type="number"
                    name="men"
                    min="0"
                    required
                >

                <label>Women</label>

                <input
                    type="number"
                    name="women"
                    min="0"
                    required
                >

                <label>Children</label>

                <input
                    type="number"
                    name="children"
                    min="0"
                    required
                >

                <button type="submit">
                    Save Attendance
                </button>

            </form>

        </div>

    </main>

</div>

</body>
</html>