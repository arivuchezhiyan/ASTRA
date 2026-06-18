<?php
require_once dirname(dirname(__DIR__)) . '/app/config/database.php';
require_once dirname(dirname(__DIR__)) . '/app/helpers/functions.php';
require_admin_login();

// Delete gallery image
if (isset($_GET['gallery_id'])) {
    $gid = (int)$_GET['gallery_id'];
    $sid = (int)$_GET['service_id'];
    $img = $pdo->prepare("SELECT image FROM service_gallery WHERE id = ?"); $img->execute([$gid]); $img = $img->fetchColumn();
    if ($img) delete_image('services', $img);
    $pdo->prepare("DELETE FROM service_gallery WHERE id = ?")->execute([$gid]);
    set_flash('success', 'Gallery image removed.');
    redirect(BASE_URL . "/admin/services/edit.php?id=$sid");
}

// Delete service
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $s = $pdo->prepare("SELECT banner_image FROM services WHERE id = ?"); $s->execute([$id]); $s = $s->fetch();
    if ($s) {
        if ($s['banner_image']) delete_image('services', $s['banner_image']);
        $gallery = $pdo->prepare("SELECT image FROM service_gallery WHERE service_id = ?"); $gallery->execute([$id]);
        foreach ($gallery->fetchAll() as $gi) delete_image('services', $gi['image']);
        $pdo->prepare("DELETE FROM services WHERE id = ?")->execute([$id]);
        set_flash('success', 'Service deleted.');
    }
}
redirect(BASE_URL . '/admin/services/list.php');
