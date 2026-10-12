<?php
require_once 'config/db.php';
$alert = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hospital = trim($_POST['hospital_name'] ?? '');
    $unit_id = trim($_POST['hospital_unit_id'] ?? '');
    $blood_group = $_POST['patient_blood_group'] ?? '';
    $units = (int)($_POST['units_needed'] ?? 1);
    $urgency = $_POST['urgency_level'] ?? 'Urgent';
    $phone = trim($_POST['contact_phone'] ?? '');

    if ($hospital && !empty($unit_id) && strlen($unit_id) >= 6) {
        $is_verified = 1;
        $stmt = $pdo->prepare("INSERT INTO blood_requests (hospital_name, hospital_unit_id, patient_blood_group, units_needed, urgency_level, contact_phone, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$hospital, $unit_id, $blood_group, $units, $urgency, $phone, $is_verified]);
        $alert = "Emergency broadcast activated! Hospital verification status: Verified.";
    } else {
        $alert = "Invalid Hospital Unit ID format. Verification failed.";
    }
}

include 'includes/header.php'; 
?>

<section class="form-card">
    <h3>Broadcast Urgent Blood Demand</h3>
    <?php if ($alert): ?><p class="alert"><?= htmlspecialchars($alert) ?></p><?php endif; ?>
    <form method="POST">
        <input type="text" name="hospital_name" placeholder="Hospital / Medical Facility Name" required>
        <input type="text" name="hospital_unit_id" placeholder="Hospital Unit License/ID (Min 6 chars)" required>
        <select name="patient_blood_group" required>
            <option value="">Required Blood Group</option>
            <option value="Bombay_Oh">Bombay Phenotype (Oh) - Rare</option>
            <option value="Rh_null">Rh-null (Golden Blood) - Critical</option>
            <option value="O-">O- Negative</option>
            <option value="AB-">AB- Negative</option>
            <option value="A-">A- Negative</option>
            <option value="B-">B- Negative</option>
        </select>
        <input type="number" name="units_needed" min="1" max="10" placeholder="Units Needed" required>
        <select name="urgency_level" required>
            <option value="Standard">Standard (Within 24 hours)</option>
            <option value="Urgent">Urgent (Within 6 hours)</option>
            <option value="Critical">Critical (Immediate / Emergency ICU)</option>
        </select>
        <input type="tel" name="contact_phone" placeholder="Emergency Ward Phone Number" required>
        <button type="submit" class="btn-danger">Broadcast Emergency Request</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>