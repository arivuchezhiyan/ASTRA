<?php
$admin_page_title = 'Blog Posts';
include dirname(__DIR__) . '/includes/header.php';
$blogs = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC")->fetchAll();
?>
<div class="admin-card">
  <div class="card-header"><h5>All Blog Posts (<?php echo count($blogs); ?>)</h5><a href="add.php" class="btn-admin btn-primary-admin"><i class="fa fa-plus"></i> Add Post</a></div>
  <div class="card-body" style="padding:0;">
    <table class="admin-table">
      <thead><tr><th>ID</th><th>Image</th><th>Title</th><th>Category</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($blogs as $b): ?>
        <tr>
          <td><?php echo $b['id']; ?></td>
          <td><?php if ($b['featured_image']): ?><img class="thumb" src="<?php echo upload_url('blogs', $b['featured_image']); ?>"><?php else: ?>-<?php endif; ?></td>
          <td><strong><?php echo sanitize(truncate($b['title'], 50)); ?></strong></td>
          <td><?php echo sanitize($b['category']); ?></td>
          <td><span class="status-badge <?php echo $b['status'] ? 'status-active' : 'status-inactive'; ?>"><?php echo $b['status'] ? 'Active' : 'Draft'; ?></span></td>
          <td><?php echo format_date($b['created_at']); ?></td>
          <td>
            <a href="edit.php?id=<?php echo $b['id']; ?>" class="btn-admin btn-sm-admin btn-outline-admin"><i class="fa fa-pencil"></i></a>
            <a href="delete.php?id=<?php echo $b['id']; ?>" class="btn-admin btn-sm-admin btn-danger-admin btn-delete"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
