<?php
require_once dirname(dirname(__DIR__)) . '/app/config/database.php';
require_once dirname(dirname(__DIR__)) . '/app/helpers/functions.php';
require_admin_login();
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $b = $pdo->prepare("SELECT featured_image FROM blogs WHERE id = ?"); $b->execute([$id]); $b = $b->fetch();
    if ($b && $b['featured_image']) delete_image('blogs', $b['featured_image']);
    $pdo->prepare("DELETE FROM blogs WHERE id = ?")->execute([$id]);
    set_flash('success', 'Blog post deleted.');
}
redirect(BASE_URL . '/admin/blogs/list.php');
