<?php
/**
 * Admin Header
 */
require_once dirname(dirname(__DIR__)) . '/app/config/database.php';
require_once dirname(dirname(__DIR__)) . '/app/helpers/functions.php';
require_admin_login();

if (!isset($admin_page_title)) $admin_page_title = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $admin_page_title; ?> | AstraClicks Admin</title>
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/assets/images/icons/astra_clicks_fav_icon.png">
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>/assets/images/icons/astra_clicks_fav_icon.png">
  <!-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"> -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/style/type/icons.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/admin/assets/css/admin.css">
</head>
<body>
<?php include __DIR__ . '/sidebar.php'; ?>
<div class="admin-main">
  <div class="admin-topbar">
    <div>
      <button class="sidebar-toggle btn-outline-admin btn-sm-admin d-lg-none"><i class="fa fa-bars"></i></button>
      <h4 style="display:inline-block;margin-left:10px;"><?php echo $admin_page_title; ?></h4>
    </div>
    <div class="user-info">
      <span>Welcome, <strong><?php echo sanitize($_SESSION['admin_username'] ?? 'Admin'); ?></strong></span>
      <a href="<?php echo BASE_URL; ?>/logout.php" class="btn-admin btn-sm-admin btn-outline-admin">Logout</a>
    </div>
  </div>
  <div class="admin-content">
    <?php
    $flash = get_flash();
    if ($flash): ?>
    <div class="admin-alert admin-alert-<?php echo $flash['type']; ?>"><?php echo $flash['message']; ?></div>
    <?php endif; ?>
