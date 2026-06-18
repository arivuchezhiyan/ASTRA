<?php
$admin_page_title = 'Add Branch';
include dirname(__DIR__) . '/includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $branch_name = sanitize($_POST['branch_name'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $google_map = $_POST['google_map'] ?? ''; // Don't sanitise with htmlspecialchars as it could be an iframe or raw link, but filter if necessary. Or keep it as text. We will sanitize when outputting or strip tags appropriately. Let's sanitize properly on output or store cleanly.
    $status = (int)($_POST['status'] ?? 1);

    if (empty($branch_name) || empty($phone) || empty($address)) {
        echo '<div class="admin-alert admin-alert-danger">Branch name, phone, and address are required.</div>';
    } else {
        $stmt = $pdo->prepare("INSERT INTO branches (branch_name, address, phone, google_map, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$branch_name, $address, $phone, $google_map, $status]);
        
        set_flash('success', 'Branch added successfully!');
        redirect(BASE_URL . '/admin/branches/list.php');
    }
}
?>
<div class="admin-card">
  <div class="card-header"><h5>Add Branch</h5></div>
  <div class="card-body">
    <form method="post" class="admin-form">
      <?php csrf_field(); ?>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Branch Name *</label>
            <input type="text" class="form-control" name="branch_name" required>
          </div>
          <div class="form-group">
            <label>Phone Number *</label>
            <input type="text" class="form-control" name="phone" required>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="status">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Address *</label>
            <textarea class="form-control" name="address" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label>Google Map Link or Embed Code</label>
            <textarea class="form-control" name="google_map" rows="3" placeholder="https://maps.google.com/?q=... or <iframe>"></textarea>
          </div>
        </div>
      </div>
      <button type="submit" class="btn-admin btn-primary-admin"><i class="fa fa-save"></i> Add Branch</button>
      <a href="list.php" class="btn-admin btn-outline-admin">Cancel</a>
    </form>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
