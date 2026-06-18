<?php
require_once dirname(dirname(__DIR__)) . '/app/config/database.php';
require_once dirname(dirname(__DIR__)) . '/app/helpers/functions.php';
require_admin_login();

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM branches WHERE id = ?");
    $stmt->execute([$id]);
    set_flash('success', 'Branch deleted successfully.');
}
redirect(BASE_URL . '/admin/branches/list.php');
