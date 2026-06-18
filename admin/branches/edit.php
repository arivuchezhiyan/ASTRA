<?php
$admin_page_title = 'Edit Branch';
include dirname(__DIR__) . '/includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$branch = $pdo->prepare("SELECT * FROM branches WHERE id = ?");
$branch->execute([$id]);
$branch = $branch->fetch();

if (!$branch) {
    set_flash('danger', 'Branch not found.');
    redirect(BASE_URL . '/admin/branches/list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $branch_name = sanitize($_POST['branch_name'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $google_map = $_POST['google_map'] ?? '';
    $status = (int)($_POST['status'] ?? 1);

    if (empty($branch_name) || empty($phone) || empty($address)) {
        echo '<div class="admin-alert admin-alert-danger">Branch name, phone, and address are required.</div>';
    } else {
        $stmt = $pdo->prepare("UPDATE branches SET branch_name = ?, address = ?, phone = ?, google_map = ?, status = ? WHERE id = ?");
        $stmt->execute([$branch_name, $address, $phone, $google_map, $status, $id]);
        
        set_flash('success', 'Branch updated successfully!');
        redirect(BASE_URL . '/admin/branches/list.php');
    }
}
?>
<div class="admin-card">
  <div class="card-header"><h5>Edit Branch</h5></div>
  <div class="card-body">
    <form method="post" class="admin-form">
      <?php csrf_field(); ?>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Branch Name *</label>
            <input type="text" class="form-control" name="branch_name" value="<?php echo sanitize($branch['branch_name']); ?>" required>
          </div>
          <div class="form-group">
            <label>Phone Number *</label>
            <input type="text" class="form-control" name="phone" value="<?php echo sanitize($branch['phone']); ?>" required>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="status">
              <option value="1" <?php echo $branch['status'] ? 'selected' : ''; ?>>Active</option>
              <option value="0" <?php echo !$branch['status'] ? 'selected' : ''; ?>>Inactive</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Address *</label>
            <textarea class="form-control" name="address" rows="3" required><?php echo sanitize($branch['address']); ?></textarea>
          </div>
          <div class="form-group">
            <label>Google Map Link or Embed Code</label>
            <textarea class="form-control" name="google_map" rows="3" placeholder="https://maps.google.com/?q=... or <iframe>"><?php echo sanitize($branch['google_map']); ?></textarea>
          </div>
        </div>
      </div>
      <button type="submit" class="btn-admin btn-primary-admin"><i class="fa fa-save"></i> Update Branch</button>
      <a href="list.php" class="btn-admin btn-outline-admin">Cancel</a>
    </form>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
