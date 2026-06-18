<?php
$admin_page_title = 'Edit Service';
include dirname(__DIR__) . '/includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$service = $pdo->prepare("SELECT * FROM services WHERE id = ?"); $service->execute([$id]); $service = $service->fetch();
if (!$service) { set_flash('danger', 'Service not found.'); redirect(BASE_URL . '/admin/services/list.php'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $name = sanitize($_POST['service_name']);
    $slug = generate_slug($_POST['slug'] ?: $name);
    $short = $_POST['short_description'] ?? '';
    $full = $_POST['full_description'] ?? '';
    $meta_t = sanitize($_POST['meta_title'] ?? '');
    $meta_d = sanitize($_POST['meta_description'] ?? '');
    $status = (int)($_POST['status'] ?? 1);
    $banner = $service['banner_image'];

    if (!empty($_FILES['banner_image']['name'])) {
        $result = upload_image($_FILES['banner_image'], 'services');
        if ($result['success']) {
            if ($banner) delete_image('services', $banner);
            $banner = $result['filename'];
        }
    }

    $stmt = $pdo->prepare("UPDATE services SET service_name=?, slug=?, banner_image=?, short_description=?, full_description=?, meta_title=?, meta_description=?, status=? WHERE id=?");
    $stmt->execute([$name, $slug, $banner, $short, $full, $meta_t, $meta_d, $status, $id]);

    if (!empty($_FILES['gallery_images']['name'][0])) {
        foreach ($_FILES['gallery_images']['name'] as $key => $gname) {
            if ($_FILES['gallery_images']['error'][$key] === 0) {
                $gfile = ['name' => $gname, 'tmp_name' => $_FILES['gallery_images']['tmp_name'][$key], 'size' => $_FILES['gallery_images']['size'][$key], 'error' => 0];
                $gr = upload_image($gfile, 'services');
                if ($gr['success']) {
                    $pdo->prepare("INSERT INTO service_gallery (service_id, image, alt_tag) VALUES (?,?,?)")->execute([$id, $gr['filename'], $name]);
                }
            }
        }
    }

    set_flash('success', 'Service updated successfully!');
    redirect(BASE_URL . '/admin/services/list.php');
}

$gallery = get_service_gallery($pdo, $id);
?>
<div class="admin-card">
  <div class="card-header"><h5>Edit: <?php echo sanitize($service['service_name']); ?></h5></div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" class="admin-form">
      <?php csrf_field(); ?>
      <div class="row">
        <div class="col-md-8">
          <div class="form-group"><label>Service Name *</label><input type="text" class="form-control" name="service_name" value="<?php echo sanitize($service['service_name']); ?>" required></div>
          <div class="form-group"><label>Slug</label><input type="text" class="form-control" name="slug" value="<?php echo $service['slug']; ?>"></div>
          <div class="form-group"><label>Short Description</label><textarea class="form-control" name="short_description" rows="3"><?php echo sanitize($service['short_description']); ?></textarea></div>
          <div class="form-group"><label>Full Description</label><textarea class="form-control" name="full_description" rows="8"><?php echo sanitize($service['full_description']); ?></textarea></div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Banner Image</label>
            <?php if ($service['banner_image']): ?><img class="preview-img" src="<?php echo upload_url('services', $service['banner_image']); ?>" alt="" style="display:block;margin-bottom:10px;"><?php endif; ?>
            <div class="upload-zone"><input type="file" name="banner_image" accept="image/*" style="display:none"><i class="fa fa-cloud-upload"></i><p>Click or drag to replace</p><img class="preview-img" style="display:none" src="" alt=""></div>
          </div>
          <div class="form-group"><label>Status</label><select class="form-control" name="status"><option value="1" <?php echo $service['status'] ? 'selected' : ''; ?>>Active</option><option value="0" <?php echo !$service['status'] ? 'selected' : ''; ?>>Inactive</option></select></div>
          <div class="form-group"><label>Meta Title</label><input type="text" class="form-control" name="meta_title" value="<?php echo sanitize($service['meta_title']); ?>"></div>
          <div class="form-group"><label>Meta Description</label><textarea class="form-control" name="meta_description" rows="2"><?php echo sanitize($service['meta_description']); ?></textarea></div>
          <div class="form-group"><label>Add More Gallery Images</label><input type="file" class="form-control" name="gallery_images[]" accept="image/*" multiple></div>
        </div>
      </div>
      <?php if (!empty($gallery)): ?>
      <h6>Current Gallery Images</h6>
      <div class="row">
        <?php foreach ($gallery as $gi): ?>
        <div class="col-md-2 col-4" style="margin-bottom:10px;text-align:center;">
          <img src="<?php echo upload_url('services', $gi['image']); ?>" style="width:100%;height:80px;object-fit:cover;border-radius:8px;" alt="">
          <a href="delete.php?gallery_id=<?php echo $gi['id']; ?>&service_id=<?php echo $id; ?>" class="btn-delete" style="color:var(--danger);font-size:0.75rem;">Remove</a>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
      <div style="margin-top:20px;">
        <button type="submit" class="btn-admin btn-primary-admin"><i class="fa fa-save"></i> Update Service</button>
        <a href="list.php" class="btn-admin btn-outline-admin">Cancel</a>
      </div>
    </form>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
