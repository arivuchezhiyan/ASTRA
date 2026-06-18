<?php
$admin_page_title = 'Add Gallery Media';
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
  <div class="card-header"><h5>Add Gallery Media</h5></div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" class="admin-form">
      <?php csrf_field(); ?>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"><label>Media Title</label><input type="text" class="form-control" name="image_title"></div>
          <div class="form-group"><label>Category *</label>
            <select class="form-control" name="category" required>
              <option value="">Select Category</option>
              <option value="Wedding">Wedding</option>
              <option value="Pre Wedding">Pre Wedding</option>
              <option value="Reception">Reception</option>
              <option value="Baby Shoots">Baby Shoots</option>
              <option value="Baby Shower">Baby Shower</option>
              <option value="Brahmin Wedding">Brahmin Wedding</option>
              <option value="Christian Wedding">Christian Wedding</option>
              <option value="Couple Shooting">Couple Shooting</option>
              <option value="Maternity">Maternity</option>
            </select>
          </div>
          <div class="form-group"><label>Alt Tag</label><input type="text" class="form-control" name="alt_tag"></div>
          <div class="form-group"><label>Status</label><select class="form-control" name="status"><option value="1">Active</option><option value="0">Inactive</option></select></div>
        </div>
        <div class="col-md-6">
          <div class="form-group"><label>Media File *</label><div class="upload-zone"><input type="file" name="image" accept="image/*,video/*" style="display:none" required><i class="fa fa-cloud-upload"></i><p>Click or drag to upload</p><img class="preview-img" style="display:none" src="" alt=""><video class="preview-video" style="display:none;max-width:100%;max-height:200px;border-radius:10px;margin-top:10px;" controls></video></div></div>
        </div>
      </div>
      <button type="submit" class="btn-admin btn-primary-admin"><i class="fa fa-save"></i> Add Media</button>
      <a href="list.php" class="btn-admin btn-outline-admin">Cancel</a>
    </form>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
