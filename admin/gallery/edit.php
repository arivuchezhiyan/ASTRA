<?php
$admin_page_title = 'Edit Gallery Media';
include dirname(__DIR__) . '/includes/header.php';
$id = (int)($_GET['id'] ?? 0);
$img = $pdo->prepare("SELECT * FROM gallery WHERE id = ?"); $img->execute([$id]); $img = $img->fetch();
if (!$img) { set_flash('danger', 'Media not found.'); redirect(BASE_URL . '/admin/gallery/list.php'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $title = sanitize($_POST['image_title'] ?? ''); $category = sanitize($_POST['category'] ?? '');
    $alt = sanitize($_POST['alt_tag'] ?? ''); $status = (int)($_POST['status'] ?? 1); $image = $img['image'];
    if (!empty($_FILES['image']['name'])) {
        $r = upload_image($_FILES['image'], 'gallery');
        if ($r['success']) { delete_image('gallery', $image); $image = $r['filename']; }
    }
    $pdo->prepare("UPDATE gallery SET image_title=?, category=?, alt_tag=?, image=?, status=? WHERE id=?")->execute([$title, $category, $alt, $image, $status, $id]);
    set_flash('success', 'Media updated!'); redirect(BASE_URL . '/admin/gallery/list.php');
}
?>
<div class="admin-card">
  <div class="card-header"><h5>Edit Media</h5></div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" class="admin-form">
      <?php csrf_field(); ?>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"><label>Media Title</label><input type="text" class="form-control" name="image_title" value="<?php echo sanitize($img['image_title']); ?>"></div>
          <div class="form-group"><label>Category *</label>
            <select class="form-control" name="category" required>
              <option value="">Select Category</option>
              <?php
              $cats = ['Wedding', 'Pre Wedding', 'Reception', 'Baby Shoots', 'Baby Shower', 'Brahmin Wedding', 'Christian Wedding', 'Couple Shooting', 'Maternity'];
              foreach ($cats as $cat) {
                  $selected = (strcasecmp($img['category'], $cat) === 0) ? 'selected' : '';
                  echo '<option value="' . $cat . '" ' . $selected . '>' . $cat . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group"><label>Alt Tag</label><input type="text" class="form-control" name="alt_tag" value="<?php echo sanitize($img['alt_tag']); ?>"></div>
          <div class="form-group"><label>Status</label><select class="form-control" name="status"><option value="1" <?php echo $img['status'] ? 'selected' : ''; ?>>Active</option><option value="0" <?php echo !$img['status'] ? 'selected' : ''; ?>>Inactive</option></select></div>
        </div>
        <div class="col-md-6">
          <?php
          $ext = strtolower(pathinfo($img['image'], PATHINFO_EXTENSION));
          $is_video = in_array($ext, ['mp4', 'webm', 'ogg', 'mov']);
          ?>
          <div class="form-group"><label>Current Media</label><br>
            <?php if ($is_video): ?>
              <video src="<?php echo upload_url('gallery', $img['image']); ?>" style="max-width:100%;max-height:200px;border-radius:10px;margin-bottom:10px;" controls muted></video>
            <?php else: ?>
              <img src="<?php echo upload_url('gallery', $img['image']); ?>" style="max-width:100%;max-height:200px;border-radius:10px;margin-bottom:10px;">
            <?php endif; ?>
          </div>
          <div class="form-group"><label>Replace Media File</label><div class="upload-zone"><input type="file" name="image" accept="image/*,video/*" style="display:none"><i class="fa fa-cloud-upload"></i><p>Click or drag</p><img class="preview-img" style="display:none" src="" alt=""><video class="preview-video" style="display:none;max-width:100%;max-height:200px;border-radius:10px;margin-top:10px;" controls></video></div></div>
        </div>
      </div>
      <button type="submit" class="btn-admin btn-primary-admin"><i class="fa fa-save"></i> Update</button>
      <a href="list.php" class="btn-admin btn-outline-admin">Cancel</a>
    </form>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
