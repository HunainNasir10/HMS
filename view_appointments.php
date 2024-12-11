<?php
require 'db.php'; // Include your database connection

try {
    $query = $conn->query('
        SELECT a.id, p.name AS patient_name, d.name AS doctor_name, a.appointment_date, a.reason, a.status
        FROM appointments a
        JOIN patients p ON a.patient_id = p.id
        JOIN doctors d ON a.doctor_id = d.id
        ORDER BY a.appointment_date ASC
    ');
    $appointments = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS -->
</head>
<body>
    <header>
        <h1>Appointments</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="register_patient.php">Register Patient</a></li>
                <li><a href="schedule_appointment.php">Schedule Appointment</a></li>
                <li><a href="view_appointments.php">View Appointments</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>List of Appointments</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Appointment Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($appointments)) : ?>
                    <?php foreach ($appointments as $appointment) : ?>
                        <tr>
                            <td><?= htmlspecialchars($appointment['id']); ?></td>
                            <td><?= htmlspecialchars($appointment['patient_name']); ?></td>
                            <td><?= htmlspecialchars($appointment['doctor_name']); ?></td>
                            <td><?= htmlspecialchars($appointment['appointment_date']); ?></td>
                            <td><?= htmlspecialchars($appointment['reason']); ?></td>
                            <td><?= htmlspecialchars($appointment['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">No appointments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Hospital Management System</p>
    </footer>
</body>
</html>
