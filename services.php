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
    <div class="wrapper light-wrapper">
      <div class="container inner inner-page-padding">
        <h2 class="section-title text-center">Our Services</h2>
        <p class="lead larger text-center">We specialize in capturing your special moments with creativity and passion</p>
        <div class="space30"></div>
        <div class="tiles">
          <div class="items row boxed grid-view text-center">
            <?php foreach ($services as $service): ?>
            <div class="item col-md-4">
              <div class="box bg-white shadow p-30">
                <figure class="main polaroid" style="border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                  <a href="<?php echo BASE_URL; ?>/services/<?php echo $service['slug']; ?>">
                    <?php if ($service['slug'] === 'weddings'): ?>
                    <img src="<?php echo BASE_URL; ?>/assets/images/images/wedding/img_15.jpg" alt="<?php echo sanitize($service['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: center 35%;" loading="lazy" />
                    <?php elseif ($service['slug'] === 'pre-wedding'): ?>
                    <img src="<?php echo BASE_URL; ?>/assets/images/images/wedding/img_7.jpg" alt="<?php echo sanitize($service['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: center bottom;" loading="lazy" />
                    <?php elseif ($service['slug'] === 'reception'): ?>
                    <img src="<?php echo BASE_URL; ?>/assets/images/images/wedding/img_16.jpg" alt="<?php echo sanitize($service['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: center 55%;" loading="lazy" />
                    <?php elseif ($service['slug'] === 'baby-shoots'): ?>
                    <img src="<?php echo BASE_URL; ?>/assets/images/images/baby_shoots/img_5.jpg" alt="<?php echo sanitize($service['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: center 20%;" loading="lazy" />
                    <?php elseif ($service['slug'] === 'maternity'): ?>
                    <img src="<?php echo BASE_URL; ?>/assets/images/images/baby_shoots/img_12.jpg" alt="<?php echo sanitize($service['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: center;" loading="lazy" />
                    <?php elseif ($service['slug'] === 'birthdays'): ?>
                    <img src="<?php echo BASE_URL; ?>/assets/images/images/baby_shoots/img_3.jpg" alt="<?php echo sanitize($service['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: center 15%;" loading="lazy" />
                    <?php elseif ($service['slug'] === 'baby-shower'): ?>
                    <img src="<?php echo BASE_URL; ?>/assets/images/images/baby_shower/baby_shower_1.jpg" alt="<?php echo sanitize($service['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: center 25%;" loading="lazy" />
                    <?php elseif ($service['banner_image']): ?>
                    <img src="<?php echo upload_url('services', $service['banner_image']); ?>" alt="<?php echo sanitize($service['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: center;" loading="lazy" />
                    <?php else: ?>
                    <img src="<?php echo BASE_URL; ?>/style/images/art/bg16.jpg" alt="<?php echo sanitize($service['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: center;" loading="lazy" />
                    <?php endif; ?>
                  </a>
                </figure>
                <h4 class="text-uppercase mb-0"><a href="<?php echo BASE_URL; ?>/services/<?php echo $service['slug']; ?>"><?php echo sanitize($service['service_name']); ?></a></h4>
                <?php if ($service['short_description']): ?>
                <p class="mt-10"><?php echo sanitize(truncate($service['short_description'], 100)); ?></p>
                <?php endif; ?>
              </div>
              <!-- /.box -->
            </div>
            <!--/.item -->
            <?php endforeach; ?>
          </div>
          <!--/.row -->
        </div>
        <!-- /.tiles -->
      </div>
      <!-- /.container -->
    </div>
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
