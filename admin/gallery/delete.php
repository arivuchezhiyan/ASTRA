<?php
require_once dirname(dirname(__DIR__)) . '/app/config/database.php';
require_once dirname(dirname(__DIR__)) . '/app/helpers/functions.php';
require_admin_login();
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $i = $pdo->prepare("SELECT image FROM gallery WHERE id = ?"); $i->execute([$id]); $i = $i->fetchColumn();
    if ($i) delete_image('gallery', $i);
    $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
    set_flash('success', 'Image deleted.');
}
redirect(BASE_URL . '/admin/gallery/list.php');
