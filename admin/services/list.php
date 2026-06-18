<?php
$admin_page_title = 'Services';
include dirname(__DIR__) . '/includes/header.php';
$services = $pdo->query("SELECT * FROM services ORDER BY id ASC")->fetchAll();
?>
<div class="admin-card">
  <div class="card-header">
    <h5>All Services (<?php echo count($services); ?>)</h5>
    <a href="add.php" class="btn-admin btn-primary-admin"><i class="fa fa-plus"></i> Add Service</a>
  </div>
  <div class="card-body" style="padding:0;">
    <table class="admin-table">
      <thead><tr><th>ID</th><th>Image</th><th>Service Name</th><th>Slug</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($services as $s): ?>
        <tr>
          <td><?php echo $s['id']; ?></td>
          <td><?php if ($s['banner_image']): ?><img class="thumb" src="<?php echo upload_url('services', $s['banner_image']); ?>" alt=""><?php else: ?>-<?php endif; ?></td>
          <td><strong><?php echo sanitize($s['service_name']); ?></strong></td>
          <td><code><?php echo $s['slug']; ?></code></td>
          <td><span class="status-badge <?php echo $s['status'] ? 'status-active' : 'status-inactive'; ?>"><?php echo $s['status'] ? 'Active' : 'Inactive'; ?></span></td>
          <td>
            <a href="edit.php?id=<?php echo $s['id']; ?>" class="btn-admin btn-sm-admin btn-outline-admin"><i class="fa fa-pencil"></i></a>
            <a href="delete.php?id=<?php echo $s['id']; ?>" class="btn-admin btn-sm-admin btn-danger-admin btn-delete"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
