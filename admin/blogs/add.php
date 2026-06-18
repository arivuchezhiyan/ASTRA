<?php
$admin_page_title = 'Add Blog Post';
include dirname(__DIR__) . '/includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $title = sanitize($_POST['title']);
    $slug = generate_slug($_POST['slug'] ?: $title);
    $category = sanitize($_POST['category'] ?? '');
    $short = $_POST['short_description'] ?? '';
    $full = $_POST['full_description'] ?? '';
    $meta_t = sanitize($_POST['meta_title'] ?? '');
    $meta_d = sanitize($_POST['meta_description'] ?? '');
    $tags = sanitize($_POST['tags'] ?? '');
    $status = (int)($_POST['status'] ?? 1);
    $image = null;

    if (!empty($_FILES['featured_image']['name'])) {
        $r = upload_image($_FILES['featured_image'], 'blogs');
        if ($r['success']) $image = $r['filename'];
    }

    $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, category, short_description, full_description, featured_image, meta_title, meta_description, tags, status) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute([$title, $slug, $category, $short, $full, $image, $meta_t, $meta_d, $tags, $status]);

    set_flash('success', 'Blog post added!');
    redirect(BASE_URL . '/admin/blogs/list.php');
}
?>
<div class="admin-card">
  <div class="card-header"><h5>Add Blog Post</h5></div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" class="admin-form">
      <?php csrf_field(); ?>
      <div class="row">
        <div class="col-md-8">
          <div class="form-group"><label>Title *</label><input type="text" class="form-control" name="title" required></div>
          <div class="form-group"><label>Slug</label><input type="text" class="form-control" name="slug" placeholder="auto-generated"></div>
          <div class="form-group"><label>Category</label><input type="text" class="form-control" name="category" placeholder="e.g., Wedding Tips, Photography"></div>
          <div class="form-group"><label>Short Description</label><textarea class="form-control" name="short_description" rows="3"></textarea></div>
          <div class="form-group"><label>Full Description (HTML allowed)</label><textarea class="form-control" name="full_description" rows="12"></textarea></div>
          <div class="form-group"><label>Tags (comma separated)</label><input type="text" class="form-control" name="tags" placeholder="wedding, photography, tips"></div>
        </div>
        <div class="col-md-4">
          <div class="form-group"><label>Featured Image</label><div class="upload-zone"><input type="file" name="featured_image" accept="image/*" style="display:none"><i class="fa fa-cloud-upload"></i><p>Click or drag to upload</p><img class="preview-img" style="display:none" src="" alt=""></div></div>
          <div class="form-group"><label>Status</label><select class="form-control" name="status"><option value="1">Published</option><option value="0">Draft</option></select></div>
          <div class="form-group"><label>Meta Title</label><input type="text" class="form-control" name="meta_title"></div>
          <div class="form-group"><label>Meta Description</label><textarea class="form-control" name="meta_description" rows="2"></textarea></div>
        </div>
      </div>
      <button type="submit" class="btn-admin btn-primary-admin"><i class="fa fa-save"></i> Publish</button>
      <a href="list.php" class="btn-admin btn-outline-admin">Cancel</a>
    </form>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
