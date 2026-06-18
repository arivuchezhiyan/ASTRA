<?php
/**
 * AstraClicks - Blog Listing Page
 * Based on blog3.html (Grid View I)
 */
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/helpers/functions.php';

$page_type = 'inner';
$page_title = 'Blog | AstraClicks Photography';
$meta_description = 'Read our latest blog posts about photography tips, behind-the-scenes stories, and more from AstraClicks.';
$canonical_url = BASE_URL . '/blogs';

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$blogs = get_blogs($pdo, $page);
$total = get_blog_count($pdo);
$total_pages = ceil($total / ITEMS_PER_PAGE);

include 'includes/header.php';
?>
    <div class="wrapper light-wrapper">
      <div class="container inner inner-page-padding">
        <h2 class="section-title text-center">Our Blog</h2>
        <p class="lead larger text-center">Stories, tips, and behind-the-scenes from AstraClicks</p>
        <div class="space30"></div>
        <?php if (!empty($blogs)): ?>
        <div class="blog grid grid-view boxed">
          <div class="row isotope">
            <?php foreach ($blogs as $blog): ?>
            <div class="item post grid-sizer col-md-6 col-lg-4">
              <div class="box bg-white shadow p-30">
                <figure class="main mb-30 overlay overlay1 rounded"><a href="<?php echo BASE_URL; ?>/blog/<?php echo $blog['slug']; ?>">
                  <?php if ($blog['featured_image']): ?>
                  <img src="<?php echo upload_url('blogs', $blog['featured_image']); ?>" alt="<?php echo sanitize($blog['title']); ?>" loading="lazy" />
                  <?php else: ?>
                  <img src="<?php echo ASSETS_URL; ?>/images/art/gb1.jpg" alt="<?php echo sanitize($blog['title']); ?>" loading="lazy" />
                  <?php endif; ?>
                  </a>
                  <figcaption>
                    <h5 class="text-uppercase from-top mb-0">Read More</h5>
                  </figcaption>
                </figure>
                <?php if ($blog['category']): ?>
                <div class="meta mb-10"><span class="category"><a href="#" class="hover color"><?php echo sanitize($blog['category']); ?></a></span></div>
                <?php endif; ?>
                <h2 class="post-title"><a href="<?php echo BASE_URL; ?>/blog/<?php echo $blog['slug']; ?>"><?php echo sanitize($blog['title']); ?></a></h2>
                <div class="post-content">
                  <p><?php echo sanitize(truncate($blog['short_description'], 120)); ?></p>
                </div>
                <!-- /.post-content -->
                <hr />
                <div class="meta meta-footer d-flex justify-content-between mb-0"><span class="date"><?php echo format_date($blog['created_at']); ?></span></div>
              </div>
              <!-- /.box -->
            </div>
            <!-- /.post -->
            <?php endforeach; ?>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.blog -->
        <div class="space30 d-block d-md-none"></div>
        <?php echo render_pagination($page, $total_pages, BASE_URL . '/blogs'); ?>
        <?php else: ?>
        <div class="text-center">
          <h4>No blog posts yet.</h4>
          <p>Check back soon for stories and tips from AstraClicks!</p>
        </div>
        <?php endif; ?>
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
<?php include 'includes/footer.php'; ?>
