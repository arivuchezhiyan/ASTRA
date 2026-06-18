<?php
$admin_page_title = 'Add Service';
include dirname(__DIR__) . '/includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $name = sanitize($_POST['service_name']);
    $slug = generate_slug($_POST['slug'] ?: $name);
    $short = $_POST['short_description'] ?? '';
    $full = $_POST['full_description'] ?? '';
    $meta_t = sanitize($_POST['meta_title'] ?? '');
    $meta_d = sanitize($_POST['meta_description'] ?? '');
    $status = (int)($_POST['status'] ?? 1);
    $banner = null;

    if (!empty($_FILES['banner_image']['name'])) {
        $result = upload_image($_FILES['banner_image'], 'services');
        if ($result['success']) $banner = $result['filename'];
    }

    $stmt = $pdo->prepare("INSERT INTO services (service_name, slug, banner_image, short_description, full_description, meta_title, meta_description, status) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->execute([$name, $slug, $banner, $short, $full, $meta_t, $meta_d, $status]);

    // Handle gallery images
    $service_id = $pdo->lastInsertId();
    if (!empty($_FILES['gallery_images']['name'][0])) {
        foreach ($_FILES['gallery_images']['name'] as $key => $gname) {
            if ($_FILES['gallery_images']['error'][$key] === 0) {
                $gfile = ['name' => $gname, 'tmp_name' => $_FILES['gallery_images']['tmp_name'][$key], 'size' => $_FILES['gallery_images']['size'][$key], 'error' => 0];
                $gr = upload_image($gfile, 'services');
                if ($gr['success']) {
                    $pdo->prepare("INSERT INTO service_gallery (service_id, image, alt_tag) VALUES (?,?,?)")->execute([$service_id, $gr['filename'], $name]);
                }
            }
        }
    }

    set_flash('success', 'Service added successfully!');
    redirect(BASE_URL . '/admin/services/list.php');
}
?>
<div class="admin-card">
  <div class="card-header"><h5>Add New Service</h5></div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" class="admin-form">
      <?php csrf_field(); ?>
      <div class="row">
        <div class="col-md-8">
          <div class="form-group"><label>Service Name *</label><input type="text" class="form-control" name="service_name" required></div>
          <div class="form-group"><label>Slug</label><input type="text" class="form-control" name="slug" placeholder="auto-generated"></div>
          <div class="form-group"><label>Short Description</label><textarea class="form-control" name="short_description" rows="3"></textarea></div>
          <div class="form-group"><label>Full Description</label><textarea class="form-control" name="full_description" rows="8"></textarea></div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Banner Image</label>
            <div class="upload-zone"><input type="file" name="banner_image" accept="image/*" style="display:none"><i class="fa fa-cloud-upload"></i><p>Click or drag to upload</p><img class="preview-img" style="display:none" src="" alt=""></div>
          </div>
          <div class="form-group"><label>Status</label><select class="form-control" name="status"><option value="1">Active</option><option value="0">Inactive</option></select></div>
          <div class="form-group"><label>Meta Title</label><input type="text" class="form-control" name="meta_title"></div>
          <div class="form-group"><label>Meta Description</label><textarea class="form-control" name="meta_description" rows="2"></textarea></div>
          <div class="form-group">
            <label>Gallery Images (Multiple)</label>
            <input type="file" class="form-control" name="gallery_images[]" accept="image/*" multiple>
          </div>
        </div>
      </div>
      <button type="submit" class="btn-admin btn-primary-admin"><i class="fa fa-save"></i> Save Service</button>
      <a href="list.php" class="btn-admin btn-outline-admin">Cancel</a>
    </form>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
