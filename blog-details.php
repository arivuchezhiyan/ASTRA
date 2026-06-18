<?php
/**
 * AstraClicks - Blog Detail Page
 * Based on blog-post.html
 */
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/helpers/functions.php';

$slug = $_GET['slug'] ?? '';
$blog = get_blog_by_slug($pdo, $slug);

if (!$blog) {
    header('HTTP/1.0 404 Not Found');
    $page_title = 'Blog Post Not Found | AstraClicks';
    include 'includes/header.php';
    echo '<div class="wrapper light-wrapper"><div class="container inner inner-page-padding text-center"><h2>Blog Post Not Found</h2><p>The blog post you are looking for does not exist.</p><a href="' . BASE_URL . '/blogs" class="btn shadow">View All Posts</a></div></div>';
    include 'includes/footer.php';
    exit;
}

$page_type = 'inner';
$page_title = ($blog['meta_title'] ?: $blog['title']) . ' | AstraClicks Blog';
$meta_description = $blog['meta_description'] ?: $blog['short_description'];
$canonical_url = BASE_URL . '/blog/' . $blog['slug'];
if ($blog['featured_image']) {
    $og_image = upload_url('blogs', $blog['featured_image']);
}

include 'includes/header.php';
?>
    <div class="wrapper light-wrapper">
      <div class="container inner inner-page-padding">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="blog single-post">
              <?php if ($blog['featured_image']): ?>
              <figure class="main mb-40 rounded"><img src="<?php echo upload_url('blogs', $blog['featured_image']); ?>" alt="<?php echo sanitize($blog['title']); ?>" /></figure>
              <?php endif; ?>
              <div class="meta mb-20">
                <?php if ($blog['category']): ?>
                <span class="category"><a href="#" class="hover color"><?php echo sanitize($blog['category']); ?></a></span>
                <?php endif; ?>
                <span class="date"><?php echo format_date($blog['created_at']); ?></span>
              </div>
              <h1 class="post-title"><?php echo sanitize($blog['title']); ?></h1>
              <div class="post-content">
                <?php echo $blog['full_description']; ?>
              </div>
              <!-- /.post-content -->
              <?php if ($blog['tags']): ?>
              <div class="post-footer mt-30">
                <p><strong>Tags:</strong>
                  <?php
                  $tags = explode(',', $blog['tags']);
                  foreach ($tags as $tag) {
                      echo '<span class="badge badge-secondary mr-5">' . sanitize(trim($tag)) . '</span>';
                  }
                  ?>
                </p>
              </div>
              <?php endif; ?>
              <hr />
              <div class="text-center mt-20">
                <a href="<?php echo BASE_URL; ?>/blogs" class="btn btn-white shadow"><i class="mi-arrow-left"></i> Back to Blog</a>
              </div>
            </div>
            <!-- /.blog -->
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
<?php include 'includes/footer.php'; ?>
