<?php
require 'db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $reason = $_POST['reason'];

    try {
        $stmt = $conn->prepare('
            INSERT INTO appointments (patient_id, doctor_id, appointment_date, reason)
            VALUES (:patient_id, :doctor_id, :appointment_date, :reason)
        ');

        $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
        $stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);
        $stmt->bindParam(':appointment_date', $appointment_date);
        $stmt->bindParam(':reason', $reason);

        $stmt->execute();

        echo "Appointment scheduled successfully!";
    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS -->
</head>
<body>
    <header>
        <h1>Schedule Appointment</h1>
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
        <h2>Fill the details to schedule an appointment</h2>
        <form action="schedule_appointment.php" method="POST">
            <label for="patient_id">Patient:</label>
            <select id="patient_id" name="patient_id" required>
                <?php
                // Fetch patients for dropdown
                $patients = $conn->query('SELECT id, name FROM patients')->fetchAll(PDO::FETCH_ASSOC);
                foreach ($patients as $patient) {
                    echo '<option value="' . $patient['id'] . '">' . htmlspecialchars($patient['name']) . '</option>';
                }
                ?>
            </select>

            <label for="doctor_id">Doctor:</label>
            <select id="doctor_id" name="doctor_id" required>
                <?php
                // Fetch doctors for dropdown
                $doctors = $conn->query('SELECT id, name FROM doctors')->fetchAll(PDO::FETCH_ASSOC);
                foreach ($doctors as $doctor) {
                    echo '<option value="' . $doctor['id'] . '">' . htmlspecialchars($doctor['name']) . '</option>';
                }
                ?>
            </select>

            <label for="appointment_date">Appointment Date:</label>
            <input type="datetime-local" id="appointment_date" name="appointment_date" required>

            <label for="reason">Reason:</label>
            <textarea id="reason" name="reason" rows="4" required></textarea>

            <button type="submit">Schedule Appointment</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Hospital Management System</p>
    </footer>
</body>
</html>
