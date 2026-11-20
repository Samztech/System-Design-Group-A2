<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT 
            attendance.attendance_id,
            attendance.service_date,
            attendance.men,
            attendance.women,
            attendance.children,
            attendance.total_attendance,
            users.username
        FROM attendance
        INNER JOIN users
        ON attendance.recorded_by = users.user_id
        ORDER BY attendance.service_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Attendance Records</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="page-container">

    <header class="topbar">

        <div>
            <h2>Chapel Church Attendance System</h2>
            <p>Attendance Records</p>
        </div>

        <a href="dashboard.php" class="logout-btn">
            Dashboard
        </a>

    </header>


    <main class="records-container">

        <div class="records-box">

            <div class="records-heading">

                <div>
                    <h1>Attendance Records</h1>

                    <p>
                        Previously recorded worship service attendance.
                    </p>
                </div>

                <?php if ($_SESSION["role"] == "secretary"): ?>

                    <a href="attendance.php" class="add-button">
                        Record Attendance
                    </a>

                <?php endif; ?>

            </div>


            <?php if ($result->num_rows > 0): ?>

                <div class="table-container">

                    <table>

                        <thead>

                            <tr>
                                <th>Date</th>
                                <th>Men</th>
                                <th>Women</th>
                                <th>Children</th>
                                <th>Total</th>
                                <th>Recorded By</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php while ($row = $result->fetch_assoc()): ?>

                                <tr>

                                    <td>
                                        <?php echo htmlspecialchars($row["service_date"]); ?>
                                    </td>

                                    <td>
                                        <?php echo $row["men"]; ?>
                                    </td>

                                    <td>
                                        <?php echo $row["women"]; ?>
                                    </td>

                                    <td>
                                        <?php echo $row["children"]; ?>
                                    </td>

                                    <td class="total-cell">
                                        <?php echo $row["total_attendance"]; ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row["username"]); ?>
                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="no-records">

                    <h3>No Attendance Records</h3>

                    <p>
                        No attendance information has been recorded yet.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </main>

</div>

</body>

</html>