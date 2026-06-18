<?php
$admin_page_title = 'Branches';
include dirname(__DIR__) . '/includes/header.php';
$branches = $pdo->query("SELECT * FROM branches ORDER BY id ASC")->fetchAll();
?>
<div class="admin-card">
  <div class="card-header">
    <h5>All Branches (<?php echo count($branches); ?>)</h5>
    <a href="add.php" class="btn-admin btn-primary-admin"><i class="fa fa-plus"></i> Add Branch</a>
  </div>
  <div class="card-body" style="padding:0;">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Branch Name</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($branches)): ?>
        <tr><td colspan="6" style="text-align:center;padding:30px;color:#999;">No branches added yet.</td></tr>
        <?php else: ?>
        <?php foreach ($branches as $branch): ?>
        <tr>
          <td><?php echo $branch['id']; ?></td>
          <td><strong><?php echo sanitize($branch['branch_name']); ?></strong></td>
          <td><?php echo sanitize($branch['phone']); ?></td>
          <td><?php echo nl2br(sanitize($branch['address'])); ?></td>
          <td><span class="status-badge <?php echo $branch['status'] ? 'status-active' : 'status-inactive'; ?>"><?php echo $branch['status'] ? 'Active' : 'Inactive'; ?></span></td>
          <td>
            <a href="edit.php?id=<?php echo $branch['id']; ?>" class="btn-admin btn-sm-admin btn-outline-admin"><i class="fa fa-pencil"></i></a>
            <a href="delete.php?id=<?php echo $branch['id']; ?>" class="btn-admin btn-sm-admin btn-danger-admin btn-delete"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
