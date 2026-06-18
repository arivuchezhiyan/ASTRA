<?php
$admin_page_title = 'Add Gallery Image';
include dirname(__DIR__) . '/includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $title = sanitize($_POST['image_title'] ?? '');
    $category = sanitize($_POST['category'] ?? '');
    $alt = sanitize($_POST['alt_tag'] ?? $title);
    $status = (int)($_POST['status'] ?? 1);

    if (!empty($_FILES['image']['name'])) {
        $r = upload_image($_FILES['image'], 'gallery');
        if ($r['success']) {
            $pdo->prepare("INSERT INTO gallery (image_title, category, alt_tag, image, status) VALUES (?,?,?,?,?)")
                ->execute([$title, $category, $alt, $r['filename'], $status]);
            set_flash('success', 'Image added!');
            redirect(BASE_URL . '/admin/gallery/list.php');
        } else {
            echo '<div class="admin-alert admin-alert-danger">' . $r['error'] . '</div>';
        }
    }
}
?>
<div class="admin-card">
  <div class="card-header"><h5>Add Gallery Image</h5></div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" class="admin-form">
      <?php csrf_field(); ?>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"><label>Image Title</label><input type="text" class="form-control" name="image_title"></div>
          <div class="form-group"><label>Category</label><input type="text" class="form-control" name="category" placeholder="e.g., Weddings, Birthdays"></div>
          <div class="form-group"><label>Alt Tag</label><input type="text" class="form-control" name="alt_tag"></div>
          <div class="form-group"><label>Status</label><select class="form-control" name="status"><option value="1">Active</option><option value="0">Inactive</option></select></div>
        </div>
        <div class="col-md-6">
          <div class="form-group"><label>Image *</label><div class="upload-zone"><input type="file" name="image" accept="image/*" style="display:none" required><i class="fa fa-cloud-upload"></i><p>Click or drag to upload</p><img class="preview-img" style="display:none" src="" alt=""></div></div>
        </div>
      </div>
      <button type="submit" class="btn-admin btn-primary-admin"><i class="fa fa-save"></i> Add Image</button>
      <a href="list.php" class="btn-admin btn-outline-admin">Cancel</a>
    </form>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
