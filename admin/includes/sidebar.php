<?php
/**
 * Admin Sidebar Navigation
 */
$current_page = basename($_SERVER['SCRIPT_FILENAME'], '.php');
$current_dir = basename(dirname($_SERVER['SCRIPT_FILENAME']));
?>
<div class="admin-sidebar">
  <div class="sidebar-brand">
    <a href="<?php echo BASE_URL; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>/assets/images/icons/astra_clicks_logo.png" alt="AstraClicks" style="max-height: 40px; width: auto;"></a>
    <h5>Admin Panel</h5>
  </div>
  <div class="sidebar-nav">
    <div class="nav-section">Main</div>
    <a href="<?php echo BASE_URL; ?>/admin/dashboard.php" class="<?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">
      <i class="fa fa-th-large"></i> Dashboard
    </a>

    <div class="nav-section">Content</div>
    <a href="<?php echo BASE_URL; ?>/admin/services/list.php" class="<?php echo $current_dir === 'services' ? 'active' : ''; ?>">
      <i class="fa fa-camera"></i> Services
    </a>
    <a href="<?php echo BASE_URL; ?>/admin/blogs/list.php" class="<?php echo $current_dir === 'blogs' ? 'active' : ''; ?>">
      <i class="fa fa-pencil-square-o"></i> Blog Posts
    </a>
    <a href="<?php echo BASE_URL; ?>/admin/gallery/list.php" class="<?php echo $current_dir === 'gallery' ? 'active' : ''; ?>">
      <i class="fa fa-image"></i> Gallery
    </a>

    <div class="nav-section">Business</div>
    <a href="<?php echo BASE_URL; ?>/admin/branches/list.php" class="<?php echo $current_dir === 'branches' ? 'active' : ''; ?>">
      <i class="fa fa-map-marker"></i> Branches
    </a>
    <a href="<?php echo BASE_URL; ?>/admin/enquiries/list.php" class="<?php echo $current_dir === 'enquiries' ? 'active' : ''; ?>">
      <i class="fa fa-envelope"></i> Enquiries
    </a>

    <div class="nav-section">System</div>
    <a href="<?php echo BASE_URL; ?>" target="_blank">
      <i class="fa fa-external-link"></i> View Website
    </a>
    <a href="<?php echo BASE_URL; ?>/logout.php">
      <i class="fa fa-sign-out"></i> Logout
    </a>
  </div>
</div>
