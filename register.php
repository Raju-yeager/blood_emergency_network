<?php
require_once 'config/db.php';
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $blood_group = $_POST['blood_group'] ?? '';
    $city = trim($_POST['city'] ?? '');

    if ($name && $email && $phone && $blood_group && $city) {
        $stmt = $pdo->prepare("INSERT INTO donors (full_name, email, phone, blood_group, city) VALUES (?, ?, ?, ?, ?)");
        try {
            $stmt->execute([$name, $email, $phone, $blood_group, $city]);
            $msg = "Registration successful! You are now listed as an active donor.";
        } catch (PDOException $e) {
            $msg = "Error: " . $e->getMessage();
        }
    }
}

$filter_bg = $_GET['filter_bg'] ?? '';
if ($filter_bg) {
    $stmt = $pdo->prepare("SELECT * FROM donors WHERE blood_group = ? AND is_available = 1");
    $stmt->execute([$filter_bg]);
} else {
    $stmt = $pdo->query("SELECT * FROM donors WHERE is_available = 1 ORDER BY id DESC LIMIT 20");
}
$donors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donor Directory - Virtual Blood Network</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h2>Virtual Blood Emergency & Rare Donor Network</h2>
        <nav><a href="index.php">Dashboard</a> | <a href="request.php">Urgent Request</a> | <a href="register.php">Donors</a></nav>
    </header>
    <main class="container">
        <section class="form-card">
            <h3>Register as a Donor</h3>
            <?php if ($msg): ?><p class="alert"><?= htmlspecialchars($msg) ?></p><?php endif; ?>
            <form method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="tel" name="phone" placeholder="Phone Number" required>
                <input type="text" name="city" placeholder="City" required>
                <select name="blood_group" required>
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option><option value="A-">A-</option>
                    <option value="B+">B+</option><option value="B-">B-</option>
                    <option value="O+">O+</option><option value="O-">O-</option>
                    <option value="AB+">AB+</option><option value="AB-">AB-</option>
                    <option value="Bombay_Oh">Bombay Phenotype (Oh)</option>
                    <option value="Rh_null">Rh-null (Golden Blood)</option>
                </select>
                <button type="submit">Join Donor Network</button>
            </form>
        </section>
        <section class="list-card">
            <h3>Search Available Donors</h3>
            <form method="GET" class="filter-form">
                <select name="filter_bg">
                    <option value="">All Groups</option>
                    <option value="Bombay_Oh" <?= $filter_bg === 'Bombay_Oh' ? 'selected' : '' ?>>Bombay Phenotype (Oh)</option>
                    <option value="Rh_null" <?= $filter_bg === 'Rh_null' ? 'selected' : '' ?>>Rh-null</option>
                    <option value="O-" <?= $filter_bg === 'O-' ? 'selected' : '' ?>>O-</option>
                    <option value="AB-" <?= $filter_bg === 'AB-' ? 'selected' : '' ?>>AB-</option>
                </select>
                <button type="submit">Filter</button>
            </form>
            <table>
                <thead>
                    <tr><th>Name</th><th>Blood Group</th><th>City</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($donors as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['full_name']) ?></td>
                        <td><span class="badge"><?= htmlspecialchars($d['blood_group']) ?></span></td>
                        <td><?= htmlspecialchars($d['city']) ?></td>
                        <td><button onclick="toggleAvailability(<?= $d['id'] ?>, this)">Mark Inactive</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    <script src="js/main.js"></script>
</body>
</html>