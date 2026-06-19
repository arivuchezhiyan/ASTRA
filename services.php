<?php
/**
 * AstraClicks - Services Listing Page
 * Based on services.html template
 */
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/helpers/functions.php';

$page_type = 'inner';
$page_title = 'Our Services | AstraClicks Photography';
$meta_description = 'Explore our photography and videography services including weddings, receptions, pre-wedding shoots, baby photography, birthdays, baby showers, and maternity shoots.';
$canonical_url = BASE_URL . '/services';

$services = get_services($pdo);

include 'includes/header.php';
?>
    <div class="wrapper bg-pastel-default">
      <div class="container inner inner-page-padding text-center">
        <h1 class="section-title section-title-upper larger">Our Services</h1>
        <p class="lead larger mb-0">We specialize in capturing your special moments with creativity, concept & passion.</p>
      </div>
      <!-- /.container -->
    </div>

    <?php foreach ($services as $idx => $service):
        $is_even = ($idx % 2 === 0);
        $bg_class = ($idx % 2 === 0) ? 'light-wrapper' : 'gray-wrapper';
        
        // Select image and layout settings based on service slug
        $img_path = '';
        $object_position = 'center';
        if ($service['slug'] === 'weddings') {
            $img_path = BASE_URL . '/assets/images/images/wedding/img_15.jpg';
            $object_position = 'center 35%';
        } elseif ($service['slug'] === 'reception') {
            $img_path = BASE_URL . '/assets/images/images/Reception/reception_1.jpg';
            $object_position = 'center 55%';
        } elseif ($service['slug'] === 'pre-wedding') {
            $img_path = BASE_URL . '/assets/images/images/pre_wedding/pre_wedding_1.jpg';
            $object_position = 'center bottom';
        } elseif ($service['slug'] === 'baby-shoots') {
            $img_path = BASE_URL . '/assets/images/images/baby_shoots/img_5.jpg';
            $object_position = 'center 20%';
        } elseif ($service['slug'] === 'maternity') {
            $img_path = BASE_URL . '/assets/images/images/maternity/maternity_3.jpg';
            $object_position = 'center';
        } elseif ($service['slug'] === 'birthdays') {
            $img_path = BASE_URL . '/assets/images/images/baby_shoots/img_3.jpg';
            $object_position = 'center 15%';
        } elseif ($service['slug'] === 'baby-shower') {
            $img_path = BASE_URL . '/assets/images/images/baby_shower/baby_shower_5.jpg';
            $object_position = 'center 25%';
        } elseif ($service['banner_image']) {
            $img_path = upload_url('services', $service['banner_image']);
            $object_position = 'center';
        } else {
            $img_path = BASE_URL . '/style/images/art/bg16.jpg';
            $object_position = 'center';
        }
    ?>
    <div class="wrapper <?php echo $bg_class; ?>">
      <div class="container inner">
        <div class="row d-flex align-items-center">
          <?php if ($is_even): ?>
            <!-- Text Left, Image Right -->
            <div class="col-lg-5 pr-35 pr-sm-15">
              <h2 class="section-title section-title-upper larger"><?php echo sanitize($service['service_name']); ?></h2>
              <?php if ($service['short_description']): ?>
              <p class="lead"><?php echo sanitize($service['short_description']); ?></p>
              <?php endif; ?>
              <?php if ($service['full_description']): ?>
              <p><?php echo sanitize($service['full_description']); ?></p>
              <?php endif; ?>
              <div class="space15"></div>
              <a href="<?php echo BASE_URL; ?>/contact?service=<?php echo $service['slug']; ?>" class="btn btn-white shadow">Book This Service</a>
            </div>
            <!--/column -->
            <div class="space30 d-block d-lg-none d-xl-none"></div>
            <div class="col-lg-7">
              <figure class="rounded" style="overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.08); margin-bottom: 0;"><img src="<?php echo $img_path; ?>" alt="<?php echo sanitize($service['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: <?php echo $object_position; ?>;" loading="lazy" /></figure>
            </div>
            <!--/column -->
          <?php else: ?>
            <!-- Image Left, Text Right -->
            <div class="col-lg-7 pr-35 pr-sm-15">
              <figure class="rounded" style="overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.08); margin-bottom: 0;"><img src="<?php echo $img_path; ?>" alt="<?php echo sanitize($service['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: <?php echo $object_position; ?>;" loading="lazy" /></figure>
            </div>
            <!--/column -->
            <div class="space30 d-block d-lg-none d-xl-none"></div>
            <div class="col-lg-5">
              <h2 class="section-title section-title-upper larger"><?php echo sanitize($service['service_name']); ?></h2>
              <?php if ($service['short_description']): ?>
              <p class="lead"><?php echo sanitize($service['short_description']); ?></p>
              <?php endif; ?>
              <?php if ($service['full_description']): ?>
              <p><?php echo sanitize($service['full_description']); ?></p>
              <?php endif; ?>
              <div class="space15"></div>
              <a href="<?php echo BASE_URL; ?>/contact?service=<?php echo $service['slug']; ?>" class="btn btn-white shadow">Book This Service</a>
            </div>
            <!--/column -->
          <?php endif; ?>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
    <?php endforeach; ?>
    <!-- Video Showcase (Behind the Scenes) -->
    <div class="wrapper dark-wrapper inverse-text">
      <div class="container inner">
        <h2 class="section-title text-center">Behind the Scenes</h2>
        <p class="lead larger text-center">We would like to give you a unique photography and video experience, built to serve you best and<br class="d-none d-xl-block" /> capture your special moments for you and your families creatively and beautifully.</p>
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

    <!-- Testimonials Slider (Notes from Love Bugs) -->
    <div class="wrapper image-wrapper bg-image inverse-text" data-image-src="<?php echo ASSETS_URL; ?>/images/art/bg16.jpg">
      <div class="container inner pt-120 pb-120">
        <h2 class="section-title mb-40 text-center" style="color: #fff;">Notes from Love Bugs</h2>
        <div class="row">
          <div class="col-md-10 offset-md-1">
            <div class="cube-slider cbp-slider-edge cbp">
              <div class="cbp-item pl-60 pr-60 pb-10">
                <div class="row d-flex">
                  <div class="col-md-6 pr-35 pr-sm-15">
                    <figure><img src="<?php echo BASE_URL; ?>/assets/images/images/wedding/img_1.jpg" alt="Priya & Karthik Wedding" style="width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);" /></figure>
                  </div>
                  <!--/column -->
                  <div class="col-md-6 align-self-center text-left">
                    <blockquote class="icon icon-left">
                      <p>AstraClicks captured our wedding day beautifully! Every moment, every emotion was perfectly preserved. We couldn't be happier with the photos and videos.</p>
                      <footer class="blockquote-footer" style="color: rgba(255, 255, 255, 0.8);">Priya & Karthik</footer>
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
                  <div class="col-md-6 align-self-center text-left">
                    <blockquote class="icon icon-left">
                      <p>The team at AstraClicks is incredibly creative and professional. Our pre-wedding shoot was a magical experience that we will cherish forever.</p>
                      <footer class="blockquote-footer" style="color: rgba(255, 255, 255, 0.8);">Deepa & Arun</footer>
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
                  <div class="col-md-6 align-self-center text-left">
                    <blockquote class="icon icon-left">
                      <p>AstraClicks did an amazing job with our baby's first birthday shoot. The photos are absolutely stunning and capture every precious moment perfectly.</p>
                      <footer class="blockquote-footer" style="color: rgba(255, 255, 255, 0.8);">Meena & Ravi</footer>
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

    <!-- Pricing Tables -->
    <div class="wrapper light-wrapper">
      <div class="container inner">
        <h2 class="section-title text-center">Pricing & Packages</h2>
        <p class="lead larger text-center">Transparent pricing with awesome deals. We offer high-quality editing, premium products, and creative coverage.</p>
        <div class="space30"></div>
        <div class="row">
          <!-- Event Shoot -->
          <div class="col-md-4">
            <div class="pricing panel box bg-white shadow">
              <div class="panel-heading">
                <h4 class="panel-title">Event Shoot</h4>
                <div class="price color-dark"> <span class="price-currency">₹</span><span class="price-value">15,000</span> <span class="price-duration">event</span></div>
              </div>
              <!--/.panel-heading -->
              <div class="panel-body">
                <table class="table">
                  <tr>
                    <td><strong>3-4 Hours</strong> Event Coverage</td>
                  </tr>
                  <tr>
                    <td><strong>1 Lead</strong> Photographer</td>
                  </tr>
                  <tr>
                    <td><strong>50</strong> Edited High-Res Photos</td>
                  </tr>
                  <tr>
                    <td>All Raw Images Delivered</td>
                  </tr>
                  <tr>
                    <td><strong>Online</strong> Gallery Delivery</td>
                  </tr>
                  <tr>
                    <td>Ideal for Birthdays & Baby Showers</td>
                  </tr>
                </table>
              </div>
              <!--/.panel-body -->
              <div class="panel-footer"> <a href="<?php echo BASE_URL; ?>/contact" class="btn shadow mb-10" role="button">Choose Plan</a></div>
            </div>
            <!--/.pricing -->
          </div>
          <!--/column -->
          
          <!-- Maternity & Baby Shoot -->
          <div class="col-md-4">
            <div class="pricing panel box bg-white shadow">
              <div class="panel-heading">
                <h4 class="panel-title">Maternity & Baby Shoot</h4>
                <div class="price color-dark"> <span class="price-currency">₹</span><span class="price-value">25,000</span> <span class="price-duration">session</span></div>
              </div>
              <!--/.panel-heading -->
              <div class="panel-body">
                <table class="table">
                  <tr>
                    <td><strong>4-6 Hours</strong> Shoot (Indoor/Outdoor)</td>
                  </tr>
                  <tr>
                    <td><strong>Creative Director</strong> & Lead Photographer</td>
                  </tr>
                  <tr>
                    <td><strong>80</strong> Edited High-Res Photos</td>
                  </tr>
                  <tr>
                    <td>All Raw Images Delivered</td>
                  </tr>
                  <tr>
                    <td><strong>Premium</strong> Leather-bound Album (20 Pages)</td>
                  </tr>
                  <tr>
                    <td>Custom Props & Styling Support Included</td>
                  </tr>
                </table>
              </div>
              <!--/.panel-body -->
              <div class="panel-footer"> <a href="<?php echo BASE_URL; ?>/contact" class="btn shadow mb-10" role="button">Choose Plan</a></div>
            </div>
            <!--/.pricing -->
          </div>
          <!--/column -->

          <!-- Wedding Luxury -->
          <div class="col-md-4">
            <div class="pricing panel box bg-white shadow">
              <div class="panel-heading">
                <h4 class="panel-title">Wedding Luxury</h4>
                <div class="price color-dark"> <span class="price-currency">₹</span><span class="price-value">75,000</span> <span class="price-duration">day</span></div>
              </div>
              <!--/.panel-heading -->
              <div class="panel-body">
                <table class="table">
                  <tr>
                    <td><strong>Full Day</strong> Coverage (Up to 10 Hours)</td>
                  </tr>
                  <tr>
                    <td><strong>2 Candid</strong> Photographers & <strong>1 Cinematographer</strong></td>
                  </tr>
                  <tr>
                    <td><strong>150+</strong> Edited High-Res Photos</td>
                  </tr>
                  <tr>
                    <td><strong>4K Cinematic</strong> Highlight Video (3-5 Mins)</td>
                  </tr>
                  <tr>
                    <td><strong>Premium Flush-Mount</strong> Album (40 Pages)</td>
                  </tr>
                  <tr>
                    <td>Complimentary Pre/Post-Wedding Shoot</td>
                  </tr>
                </table>
              </div>
              <!--/.panel-body -->
              <div class="panel-footer"> <a href="<?php echo BASE_URL; ?>/contact" class="btn shadow mb-10" role="button">Choose Plan</a></div>
            </div>
            <!--/.pricing -->
          </div>
          <!--/column -->
        </div>
        <!--/.row -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->

    <div class="wrapper bg-pastel-default">
      <div class="container inner text-center">
        <h2 class="sub-heading text-center">Let's capture something beautiful together.</h2>
        <div class="space10"></div>
        <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-white shadow">Get in Touch</a>
        <a href="<?php echo WHATSAPP_URL; ?>?text=Hi%20AstraClicks!%20I'm%20interested%20in%20your%20services." target="_blank" class="btn shadow" style="margin-left:10px;"><i class="fa fa-whatsapp"></i> WhatsApp Us</a>
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
<?php include 'includes/footer.php'; ?>
