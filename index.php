<?php
/**
 * AstraClicks - Homepage
 * Pixel-perfect conversion of index2.html
 */
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/helpers/functions.php';

$page_type = 'home';
$page_title = 'AstraClicks - Professional Photography & Videography Studio in Chennai';
$meta_description = get_setting($pdo, 'meta_description');
$canonical_url = BASE_URL;

// Fetch dynamic data
// Fetch dynamic data from assets/images/banner folder
$banners = [];
$banner_dir = __DIR__ . '/assets/images/banner';
if (is_dir($banner_dir)) {
    $files = scandir($banner_dir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
            $banners[] = [
                'image' => 'assets/images/banner/' . $file,
                'alt_text' => 'AstraClicks Photography'
            ];
        }
    }
}
// Sort banners to ensure consistent numeric/alphabetical order
usort($banners, function($a, $b) {
    return strnatcmp($a['image'], $b['image']);
});
$services = get_services($pdo);
$gallery_images = get_gallery($pdo, 1, 12);
$branches = get_branches($pdo);

include 'includes/header.php';
?>
    <div class="rev_slider_wrapper fullscreen-container">
      <div id="slider10" class="rev_slider fullscreenbanner" data-version="5.4.8">
        <ul>
          <?php if (!empty($banners)): ?>
            <?php foreach ($banners as $banner): ?>
          <li data-transition="fade" data-thumb="<?php echo BASE_URL . '/' . $banner['image']; ?>"><img src="<?php echo BASE_URL . '/' . $banner['image']; ?>" alt="<?php echo sanitize($banner['alt_text']); ?>" /></li>
            <?php endforeach; ?>
          <?php else: ?>
          <li data-transition="fade" data-thumb="<?php echo BASE_URL; ?>/assets/images/banner/home_banner_1.jpg"><img src="<?php echo BASE_URL; ?>/assets/images/banner/home_banner_1.jpg" alt="AstraClicks Photography" /></li>
          <li data-transition="fade" data-thumb="<?php echo BASE_URL; ?>/assets/images/banner/home_banner_2.jpg"><img src="<?php echo BASE_URL; ?>/assets/images/banner/home_banner_2.jpg" alt="AstraClicks Photography" /></li>
          <li data-transition="fade" data-thumb="<?php echo BASE_URL; ?>/assets/images/banner/home_banner_3.jpg"><img src="<?php echo BASE_URL; ?>/assets/images/banner/home_banner_3.jpg" alt="AstraClicks Photography" /></li>
          <?php endif; ?>
        </ul>
        <div class="tp-bannertimer tp-bottom"></div>
      </div>
      <!-- /.rev_slider -->
    </div>
    <!-- /.rev_slider_wrapper -->
    <div class="wrapper light-wrapper">
      <div class="container inner">
        <h1 class="heading text-center">AstraClicks Photography</h1>
        <p class="lead larger text-center">Hi! We are AstraClicks, a professional photography & videography studio based in Chennai.<br class="d-none d-lg-block" /> We absolutely love capturing your special moments with creativity, concept & passion.</p>
        <div class="space30"></div>
        <div class="tiles grid">
          <div class="items row align-items-start isotope boxed grid-view text-center">
            <div class="item grid-sizer col-md-6">
              <div class="box bg-pastel-default p-30">
                <figure class="main mb-20 overlay overlay1 rounded"><a href="<?php echo BASE_URL; ?>/services"><img src="<?php echo BASE_URL; ?>/assets/images/home_img/img_1.jpg" alt="Our Services" style="width: 100%; aspect-ratio: 650/755; object-fit: cover;" loading="lazy" /></a>
                  <figcaption>
                    <h5 class="text-uppercase from-top mb-0">Learn More</h5>
                  </figcaption>
                </figure>
                <h5 class="mb-0">Services</h5>
              </div>
              <!-- /.box -->
            </div>
            <!--/.item -->
            <div class="item grid-sizer col-md-6">
              <div class="box bg-pastel-default p-30">
                <figure class="main mb-20 overlay overlay1 rounded"><a href="<?php echo BASE_URL; ?>/gallery"><img src="<?php echo BASE_URL; ?>/assets/images/home_img/img_2.jpg" alt="Our Gallery" style="width: 100%; aspect-ratio: 600/400; object-fit: cover; object-position: top;" loading="lazy" /></a>
                  <figcaption>
                    <h5 class="text-uppercase from-top mb-0">Featured Shots</h5>
                  </figcaption>
                </figure>
                <h5 class="mb-0">Gallery</h5>
              </div>
              <!-- /.box -->
            </div>
            <!--/.item -->
            <div class="item grid-sizer col-md-3">
              <div class="box bg-pastel-default p-30">
                <figure class="main mb-20 overlay overlay1 rounded"><a href="<?php echo BASE_URL; ?>/blogs"><img src="<?php echo BASE_URL; ?>/assets/images/home_img/img_3.jpg" alt="Our Blog" style="width: 100%; aspect-ratio: 600/400; object-fit: cover;" loading="lazy" /></a>
                  <figcaption>
                    <h5 class="text-uppercase from-top mb-0">Read Entries</h5>
                  </figcaption>
                </figure>
                <h5 class="mb-0">Blog</h5>
              </div>
              <!-- /.box -->
            </div>
            <!--/.item -->
            <div class="item grid-sizer col-md-3">
              <div class="box bg-pastel-default p-30">
                <figure class="main mb-20 overlay overlay1 rounded"><a href="<?php echo BASE_URL; ?>/contact"><img src="<?php echo BASE_URL; ?>/assets/images/home_img/img_4.jpg" alt="Contact Us" style="width: 100%; aspect-ratio: 500/333; object-fit: cover;" loading="lazy" /></a>
                  <figcaption>
                    <h5 class="text-uppercase from-top mb-0">Get in Touch</h5>
                  </figcaption>
                </figure>
                <h5 class="mb-0">Contact</h5>
              </div>
              <!-- /.box -->
            </div>
            <!--/.item -->
          </div>
          <!--/.row -->
        </div>
        <!-- /.tiles -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
    <div class="wrapper bg-pastel-default">
      <div class="container inner">
        <h2 class="section-title text-center">Featured Shots</h2>
        <p class="lead larger text-center">Photography is our passion and we love to turn ideas into beautiful memories.</p>
        <div class="space30"></div>
        <div class="flickity-carousel-container fullscreen">
          <div class="flickity flickity-carousel">
            <?php if (!empty($gallery_images)): ?>
              <?php foreach ($gallery_images as $gi): ?>
            <div class="item mr-15"><img src="<?php echo upload_url('gallery', $gi['image']); ?>" alt="<?php echo sanitize($gi['alt_tag'] ?? $gi['image_title']); ?>" loading="lazy" /></div>
              <?php endforeach; ?>
            <?php else: ?>
            <div class="item mr-15"><img src="<?php echo ASSETS_URL; ?>/images/art/cw10.jpg" alt="" /></div>
            <div class="item mr-15"><img src="<?php echo ASSETS_URL; ?>/images/art/cw11.jpg" alt="" /></div>
            <div class="item mr-15"><img src="<?php echo ASSETS_URL; ?>/images/art/cw12.jpg" alt="" /></div>
            <div class="item mr-15"><img src="<?php echo ASSETS_URL; ?>/images/art/cw13.jpg" alt="" /></div>
            <div class="item mr-15"><img src="<?php echo ASSETS_URL; ?>/images/art/cw14.jpg" alt="" /></div>
            <div class="item mr-15"><img src="<?php echo ASSETS_URL; ?>/images/art/cw15.jpg" alt="" /></div>
            <div class="item mr-15"><img src="<?php echo ASSETS_URL; ?>/images/art/cw16.jpg" alt="" /></div>
            <div class="item mr-15"><img src="<?php echo ASSETS_URL; ?>/images/art/cw17.jpg" alt="" /></div>
            <div class="item mr-15"><img src="<?php echo ASSETS_URL; ?>/images/art/cw18.jpg" alt="" /></div>
            <?php endif; ?>
          </div>
          <!-- /.flickity-carousel -->
          <p class="flickity-status"></p>
        </div>
        <!-- /.flickity-carousel-container -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
    <div class="wrapper image-wrapper bg-image inverse-text" data-image-src="<?php echo ASSETS_URL; ?>/images/art/bg16.jpg">
      <div class="container inner pt-150 pb-150">
        <h1 class="heading text-center">We capture photographs with<br class="d-none d-lg-block" /> creativity, concept & passion</h1>
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
    <div class="wrapper light-wrapper">
      <div class="container inner">
        <h2 class="section-title text-center">Our Specialties</h2>
        <p class="lead larger text-center">We specialize in wedding photography, but we also love photographing pre-weddings, receptions and baby shoots.</p>
        <div class="space30"></div>
        <div class="tiles">
          <div class="items row boxed grid-view text-center">
            <?php
            $display_services = array_slice($services, 0, 3);
            $service_images = [
                ASSETS_URL . '/images/art/si35.jpg',
                ASSETS_URL . '/images/art/si36.jpg',
                ASSETS_URL . '/images/art/si10.jpg',
            ];
            foreach ($display_services as $idx => $svc):
              if ($svc['slug'] === 'weddings') {
                  $img = BASE_URL . '/assets/images/images/wedding/img_13.jpg';
              } elseif ($svc['slug'] === 'reception') {
                  $img = BASE_URL . '/assets/images/images/wedding/img_15.jpg';
              } elseif ($svc['slug'] === 'pre-wedding') {
                  $img = BASE_URL . '/assets/images/images/wedding/img_1.jpg';
              } else {
                  $img = $svc['banner_image'] ? upload_url('services', $svc['banner_image']) : ($service_images[$idx] ?? $service_images[0]);
              }
            ?>
            <div class="item col-md-4">
              <div class="box bg-pastel-default p-30">
                <figure class="main mb-20" style="border-radius: 8px; overflow: hidden;"><a href="<?php echo BASE_URL; ?>/services/<?php echo $svc['slug']; ?>"><img src="<?php echo $img; ?>" alt="<?php echo sanitize($svc['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover;" loading="lazy" /></a></figure>
                <h5 class="mb-0"><a href="<?php echo BASE_URL; ?>/services/<?php echo $svc['slug']; ?>"><?php echo sanitize($svc['service_name']); ?></a></h5>
              </div>
              <!-- /.box -->
            </div>
            <!--/.item -->
            <?php endforeach; ?>
          </div>
          <!--/.row -->
        </div>
        <!--/.tiles -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
    <div class="wrapper dark-wrapper inverse-text">
      <div class="container inner">
        <h2 class="section-title text-center">Behind the Scenes</h2>
        <p class="lead larger text-center">We would like to give you a unique photography and video experience, built to serve you best and<br class="d-none d-xl-block" /> capture your special moments for you and your families creatively and
          beautifully</p>
        <div class="space30"></div>
        <style>
          .custom-video-wrapper .plyr__video-wrapper {
            overflow: hidden !important;
            position: relative !important;
            aspect-ratio: 16/9 !important;
          }
          .custom-video-wrapper video {
            width: 177.78% !important;
            height: 177.78% !important;
            left: 50% !important;
            top: 50% !important;
            position: absolute !important;
            transform: translate(-50%, -50%) rotate(-90deg) !important;
            object-fit: cover !important;
          }
        </style>
        <div class="row">
          <div class="col-md-10 offset-md-1">
            <div class="custom-video-wrapper" style="width: 100%; max-width: 640px; margin: 0 auto; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45); background: #000; position: relative;">
              <video class="player" playsinline controls loop muted autoplay>
                <source src="<?php echo BASE_URL; ?>/assets/videos/home_vid.mp4" type="video/mp4" />
              </video>
            </div>
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
    <div class="wrapper light-wrapper">
      <div class="container inner">
        <h2 class="section-title mb-40 text-center">Notes from Love Bugs</h2>
        <div class="row">
          <div class="col-md-10 offset-md-1">
            <div class="cube-slider cbp-slider-edge cbp">
              <div class="cbp-item pl-60 pr-60 pb-10">
                <div class="row d-flex">
                  <div class="col-md-6 pr-35 pr-sm-15">
                    <figure><img src="<?php echo BASE_URL; ?>/assets/images/images/wedding/img_1.jpg" alt="Priya & Karthik Wedding" style="width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);" /></figure>
                  </div>
                  <!--/column -->
                  <div class="col-md-6 align-self-center">
                    <blockquote class="icon icon-left">
                      <p>AstraClicks captured our wedding day beautifully! Every moment, every emotion was perfectly preserved. We couldn't be happier with the photos and videos.</p>
                      <footer class="blockquote-footer">Priya & Karthik</footer>
                    </blockquote>
                  </div>
                  <!--/column -->
                </div>
                <!--/.row -->
              </div>
              <!-- /.cbp-item -->
              <div class="cbp-item pl-60 pr-60 pb-10">
                <div class="row d-flex">
                  <div class="col-md-6 pr-35 pr-sm-15">
                    <figure><img src="<?php echo BASE_URL; ?>/assets/images/images/wedding/img_2.jpg" alt="Deepa & Arun Wedding" style="width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);" /></figure>
                  </div>
                  <!--/column -->
                  <div class="col-md-6 align-self-center">
                    <blockquote class="icon icon-left">
                      <p>The team at AstroClicks is incredibly creative and professional. Our pre-wedding shoot was a magical experience that we will cherish forever.</p>
                      <footer class="blockquote-footer">Deepa & Arun</footer>
                    </blockquote>
                  </div>
                  <!--/column -->
                </div>
                <!--/.row -->
              </div>
              <!-- /.cbp-item -->
              <div class="cbp-item pl-60 pr-60 pb-10">
                <div class="row d-flex">
                  <div class="col-md-6 pr-35 pr-sm-15">
                    <figure><img src="<?php echo BASE_URL; ?>/assets/images/images/wedding/img_3.jpg" alt="Meena & Ravi Wedding" style="width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);" /></figure>
                  </div>
                  <!--/column -->
                  <div class="col-md-6 align-self-center">
                    <blockquote class="icon icon-left">
                      <p>AstraClicks did an amazing job with our baby's first birthday shoot. The photos are absolutely stunning and capture every precious moment perfectly.</p>
                      <footer class="blockquote-footer">Meena & Ravi</footer>
                    </blockquote>
                  </div>
                  <!--/column -->
                </div>
                <!--/.row -->
              </div>
              <!-- /.cbp-item -->
            </div>
            <!-- /.cbp -->
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
<?php include 'includes/footer.php'; ?>
