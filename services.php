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
