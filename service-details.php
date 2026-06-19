<?php
/**
 * AstraClicks - Service Detail Page
 * Dynamic service page with gallery
 */
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/helpers/functions.php';

$slug = $_GET['slug'] ?? '';
$service = get_service_by_slug($pdo, $slug);

if (!$service) {
    header('HTTP/1.0 404 Not Found');
    $page_title = 'Service Not Found | AstraClicks';
    $meta_description = 'The requested service was not found.';
    include 'includes/header.php';
    echo '<div class="wrapper light-wrapper"><div class="container inner inner-page-padding text-center"><h2>Service Not Found</h2><p>The service you are looking for does not exist.</p><a href="' . BASE_URL . '/services" class="btn shadow">View All Services</a></div></div>';
    include 'includes/footer.php';
    exit;
}

$page_type = 'inner';
$page_title = ($service['meta_title'] ?: $service['service_name'] . ' Photography') . ' | AstraClicks';
$meta_description = $service['meta_description'] ?: $service['short_description'];
$canonical_url = BASE_URL . '/services/' . $service['slug'];
if ($service['banner_image']) {
    $og_image = upload_url('services', $service['banner_image']);
}

$gallery = get_service_gallery($pdo, $service['id']);

include 'includes/header.php';
?>
    <?php
    $default_banner = ASSETS_URL . '/images/art/bg16.jpg';
    if ($service['slug'] === 'baby-shower') {
        $default_banner = BASE_URL . '/assets/images/images/baby_shower/baby_shower_1.jpg';
    }
    ?>
    <div class="wrapper image-wrapper bg-image inverse-text" data-image-src="<?php echo $service['banner_image'] ? upload_url('services', $service['banner_image']) : $default_banner; ?>">
      <div class="container inner inner-banner-padding pb-150">
        <h1 class="heading text-center"><?php echo sanitize($service['service_name']); ?></h1>
        <p class="lead larger text-center"><?php echo sanitize($service['short_description']); ?></p>
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
    <div class="wrapper light-wrapper">
      <div class="container inner">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="blog single-post">
              <div class="post-content">
                <?php echo $service['full_description']; ?>
              </div>
            </div>
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
        <?php if (!empty($gallery)): ?>
        <div class="space30"></div>
        <h2 class="section-title text-center"><?php echo sanitize($service['service_name']); ?> Gallery</h2>
        <div class="space20"></div>
        <div id="cube-grid" class="cbp light-gallery">
          <?php foreach ($gallery as $img): ?>
          <div class="cbp-item">
            <figure class="overlay overlay3 rounded"><a href="<?php echo upload_url('services', $img['image']); ?>"><img src="<?php echo upload_url('services', $img['image']); ?>" alt="<?php echo sanitize($img['alt_tag'] ?? $service['service_name']); ?>" loading="lazy" /></a></figure>
          </div>
          <!--/.cbp-item -->
          <?php endforeach; ?>
        </div>
        <!--/.cbp -->
        <?php endif; ?>
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
    <div class="wrapper bg-pastel-default">
      <div class="container inner text-center">
        <h2 class="sub-heading text-center">Interested in <?php echo sanitize($service['service_name']); ?> Photography?</h2>
        <div class="space10"></div>
        <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-white shadow">Book Now</a>
        <a href="<?php echo WHATSAPP_URL; ?>?text=Hi%20AstraClicks!%20I'm%20interested%20in%20your%20<?php echo urlencode($service['service_name']); ?>%20photography%20service." target="_blank" class="btn shadow" style="margin-left:10px;"><i class="fa fa-whatsapp"></i> WhatsApp Us</a>
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
<?php include 'includes/footer.php'; ?>
