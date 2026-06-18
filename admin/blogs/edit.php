<?php
$admin_page_title = 'Edit Blog Post';
include dirname(__DIR__) . '/includes/header.php';
$id = (int)($_GET['id'] ?? 0);
$blog = $pdo->prepare("SELECT * FROM blogs WHERE id = ?"); $blog->execute([$id]); $blog = $blog->fetch();
if (!$blog) { set_flash('danger', 'Post not found.'); redirect(BASE_URL . '/admin/blogs/list.php'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $title = sanitize($_POST['title']); $slug = generate_slug($_POST['slug'] ?: $title);
    $category = sanitize($_POST['category'] ?? ''); $short = $_POST['short_description'] ?? '';
    $full = $_POST['full_description'] ?? ''; $meta_t = sanitize($_POST['meta_title'] ?? '');
    $meta_d = sanitize($_POST['meta_description'] ?? ''); $tags = sanitize($_POST['tags'] ?? '');
    $status = (int)($_POST['status'] ?? 1); $image = $blog['featured_image'];

    if (!empty($_FILES['featured_image']['name'])) {
        $r = upload_image($_FILES['featured_image'], 'blogs');
        if ($r['success']) { if ($image) delete_image('blogs', $image); $image = $r['filename']; }
    }

    $pdo->prepare("UPDATE blogs SET title=?, slug=?, category=?, short_description=?, full_description=?, featured_image=?, meta_title=?, meta_description=?, tags=?, status=? WHERE id=?")
        ->execute([$title, $slug, $category, $short, $full, $image, $meta_t, $meta_d, $tags, $status, $id]);
    set_flash('success', 'Blog post updated!');
    redirect(BASE_URL . '/admin/blogs/list.php');
}
?>
<div class="admin-card">
  <div class="card-header"><h5>Edit: <?php echo sanitize($blog['title']); ?></h5></div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" class="admin-form">
      <?php csrf_field(); ?>
      <div class="row">
        <div class="col-md-8">
          <div class="form-group"><label>Title *</label><input type="text" class="form-control" name="title" value="<?php echo sanitize($blog['title']); ?>" required></div>
          <div class="form-group"><label>Slug</label><input type="text" class="form-control" name="slug" value="<?php echo $blog['slug']; ?>"></div>
          <div class="form-group"><label>Category</label><input type="text" class="form-control" name="category" value="<?php echo sanitize($blog['category']); ?>"></div>
          <div class="form-group"><label>Short Description</label><textarea class="form-control" name="short_description" rows="3"><?php echo sanitize($blog['short_description']); ?></textarea></div>
          <div class="form-group"><label>Full Description</label><textarea class="form-control" name="full_description" rows="12"><?php echo sanitize($blog['full_description']); ?></textarea></div>
          <div class="form-group"><label>Tags</label><input type="text" class="form-control" name="tags" value="<?php echo sanitize($blog['tags']); ?>"></div>
        </div>
        <div class="col-md-4">
          <div class="form-group"><label>Featured Image</label>
            <?php if ($blog['featured_image']): ?><img class="preview-img" src="<?php echo upload_url('blogs', $blog['featured_image']); ?>" style="display:block;margin-bottom:10px;"><?php endif; ?>
            <div class="upload-zone"><input type="file" name="featured_image" accept="image/*" style="display:none"><i class="fa fa-cloud-upload"></i><p>Click or drag</p><img class="preview-img" style="display:none" src="" alt=""></div></div>
          <div class="form-group"><label>Status</label><select class="form-control" name="status"><option value="1" <?php echo $blog['status'] ? 'selected' : ''; ?>>Published</option><option value="0" <?php echo !$blog['status'] ? 'selected' : ''; ?>>Draft</option></select></div>
          <div class="form-group"><label>Meta Title</label><input type="text" class="form-control" name="meta_title" value="<?php echo sanitize($blog['meta_title']); ?>"></div>
          <div class="form-group"><label>Meta Description</label><textarea class="form-control" name="meta_description" rows="2"><?php echo sanitize($blog['meta_description']); ?></textarea></div>
        </div>
      </div>
      <button type="submit" class="btn-admin btn-primary-admin"><i class="fa fa-save"></i> Update</button>
      <a href="list.php" class="btn-admin btn-outline-admin">Cancel</a>
    </form>
  </div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
