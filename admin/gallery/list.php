<?php
$admin_page_title = 'Gallery';
include dirname(__DIR__) . '/includes/header.php';
$images = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC")->fetchAll();
?>
<div class="admin-card">
  <div class="card-header"><h5>Gallery Images (<?php echo count($images); ?>)</h5><a href="add.php" class="btn-admin btn-primary-admin"><i class="fa fa-plus"></i> Add Image</a></div>
  <div class="card-body" style="padding:0;">
    <table class="admin-table">
      <thead><tr><th>ID</th><th>Image</th><th>Title</th><th>Category</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($images as $img): ?>
        <tr>
          <td><?php echo $img['id']; ?></td>
          <td><img class="thumb" src="<?php echo upload_url('gallery', $img['image']); ?>" alt=""></td>
          <td><?php echo sanitize($img['image_title']); ?></td>
          <td><?php echo sanitize($img['category']); ?></td>
          <td><span class="status-badge <?php echo $img['status'] ? 'status-active' : 'status-inactive'; ?>"><?php echo $img['status'] ? 'Active' : 'Inactive'; ?></span></td>
          <td>
            <a href="edit.php?id=<?php echo $img['id']; ?>" class="btn-admin btn-sm-admin btn-outline-admin"><i class="fa fa-pencil"></i></a>
            <a href="delete.php?id=<?php echo $img['id']; ?>" class="btn-admin btn-sm-admin btn-danger-admin btn-delete"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
