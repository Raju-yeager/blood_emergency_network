<?php
require_once 'config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'error' => 'Missing donor ID']);
    exit;
}

$donor_id = (int)$data['id'];

$stmt = $pdo->prepare("SELECT is_available FROM donors WHERE id = ?");
$stmt->execute([$donor_id]);
$current = $stmt->fetchColumn();

if ($current === false) {
    echo json_encode(['success' => false, 'error' => 'Donor not found']);
    exit;
}

$new_status = $current == 1 ? 0 : 1;
$update = $pdo->prepare("UPDATE donors SET is_available = ? WHERE id = ?");
$update->execute([$new_status, $donor_id]);

echo json_encode(['success' => true, 'new_status' => $new_status]);