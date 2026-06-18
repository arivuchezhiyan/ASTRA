<?php
/**
 * AstraClicks - Contact Page
 * Custom enquiry form: Name, WhatsApp, Event Details, Date of Event
 */
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/helpers/functions.php';

$page_type = 'inner';
$page_title = 'Contact Us | AstraClicks Photography';
$meta_description = 'Get in touch with AstraClicks Photography & Videography Studio in Chennai. Book your photography session today!';
$canonical_url = BASE_URL . '/contact';

$branches = get_branches($pdo);
$errors = [];
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid form submission. Please try again.';
    } else {
        $name = sanitize($_POST['name'] ?? '');
        $whatsapp = sanitize($_POST['whatsapp_number'] ?? '');
        $event_details = sanitize($_POST['event_details'] ?? '');
        $event_date = $_POST['event_date'] ?? '';

        // Validation
        if (empty($name)) $errors[] = 'Name is required.';
        if (empty($whatsapp)) $errors[] = 'WhatsApp number is required.';
        if (!preg_match('/^[0-9]{10}$/', $whatsapp)) $errors[] = 'Please enter a valid 10-digit WhatsApp number.';
        if (empty($event_details)) $errors[] = 'Event details are required.';
        if (empty($event_date)) $errors[] = 'Date of event is required.';

        if (empty($errors)) {
            $stmt = $pdo->prepare("INSERT INTO enquiries (name, whatsapp_number, event_details, event_date) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $whatsapp, $event_details, $event_date]);

            // Build WhatsApp message
            $wa_message = "Hi AstraClicks!\n\n";
            $wa_message .= "Name: $name\n";
            $wa_message .= "Event: $event_details\n";
            $wa_message .= "Date: $event_date\n";
            $wa_message .= "WhatsApp: $whatsapp\n\n";
            $wa_message .= "I'd like to know more about your photography services.";

            $wa_url = WHATSAPP_URL . '?text=' . urlencode($wa_message);

            // Redirect to WhatsApp
            echo '<script>window.location.href="' . $wa_url . '";</script>';
            $success = true;
        }
    }
}

include 'includes/header.php';
?>
<style>
  .address-map-contact-link {
    color: #505050;
    text-decoration: none;
    transition: color 0.2s ease;
  }
  .address-map-contact-link:hover {
    color: #a855f7 !important;
    text-decoration: underline !important;
  }
  .contact-branch-address {
    margin-bottom: 20px !important;
    font-size: 15px;
    line-height: 1.6;
    width: 100%;
  }
  @media (min-width: 768px) {
    .contact-branch-address {
      min-height: 170px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  }
  .contact-phone-link {
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
    border-radius: 50px !important;
    padding: 8px 22px !important;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
    color: #505050 !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    text-decoration: none !important;
  }
  .contact-phone-link:hover {
    background: #a855f7 !important;
    border-color: #a855f7 !important;
    color: #fff !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 15px rgba(168, 85, 247, 0.25) !important;
  }
  .contact-glass-wrapper {
    position: relative !important;
    width: 100% !important;
    margin-top: 20px !important;
    overflow: visible !important;
  }
  .glass-blob {
    position: absolute !important;
    border-radius: 50% !important;
    filter: blur(60px) !important;
    -webkit-filter: blur(60px) !important;
    opacity: 0.55 !important;
    z-index: 1 !important;
    pointer-events: none !important;
  }
  .blob-1 {
    width: 180px !important;
    height: 180px !important;
    background: #a855f7 !important; /* Brand purple */
    top: -25px !important;
    left: -20px !important;
  }
  .blob-2 {
    width: 210px !important;
    height: 210px !important;
    background: #6366f1 !important; /* Brand Indigo */
    bottom: -35px !important;
    right: -25px !important;
  }
  .contact-glass-card {
    position: relative !important;
    z-index: 2 !important;
    background: rgba(18, 18, 24, 0.76) !important;
    backdrop-filter: blur(25px) !important;
    -webkit-backdrop-filter: blur(25px) !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    border-radius: 24px !important;
    padding: 40px !important;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.28), inset 0 1px 0 rgba(255, 255, 255, 0.15) !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease !important;
  }
  .contact-glass-card:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.38), inset 0 1px 0 rgba(255, 255, 255, 0.25) !important;
    background: rgba(18, 18, 24, 0.82) !important;
  }
  .contact-glass-card .form-control {
    background: rgba(0, 0, 0, 0.3) !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    color: #ffffff !important;
    border-radius: 30px !important;
    padding: 12px 20px !important;
    height: auto !important;
    font-size: 14.5px !important;
    transition: all 0.2s ease !important;
  }
  .contact-glass-card .form-control::placeholder {
    color: rgba(255, 255, 255, 0.55) !important;
    opacity: 1 !important;
  }
  .contact-glass-card .form-control:-ms-input-placeholder {
    color: rgba(255, 255, 255, 0.55) !important;
  }
  .contact-glass-card .form-control::-ms-input-placeholder {
    color: rgba(255, 255, 255, 0.55) !important;
  }
  .contact-glass-card .form-control:focus {
    background: rgba(0, 0, 0, 0.45) !important;
    border-color: #a855f7 !important;
    box-shadow: 0 0 12px rgba(168, 85, 247, 0.4) !important;
    color: #ffffff !important;
  }
  .contact-glass-card input[type="date"] {
    color: rgba(255, 255, 255, 0.55) !important;
  }
  .contact-glass-card input[type="date"]:focus,
  .contact-glass-card input[type="date"]:valid {
    color: #ffffff !important;
  }
  .contact-glass-card input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1) !important;
    cursor: pointer !important;
  }
  .btn-purple-gradient {
    background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%) !important;
    border: none !important;
    color: #fff !important;
    border-radius: 30px !important;
    padding: 12px 30px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    box-shadow: 0 4px 15px rgba(168, 85, 247, 0.4) !important;
    transition: all 0.3s ease !important;
  }
  .btn-purple-gradient:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(168, 85, 247, 0.5) !important;
  }
  .btn-white-glass {
    background: rgba(255, 255, 255, 0.06) !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    color: #25D366 !important;
    border-radius: 30px !important;
    padding: 12px 30px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    transition: all 0.3s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
  }
  .btn-white-glass:hover {
    background: rgba(255, 255, 255, 0.12) !important;
    border-color: rgba(255, 255, 255, 0.2) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.25) !important;
  }
</style>
    <div class="wrapper light-wrapper" style="background: transparent !important;">
      
      <!-- Top Section: Get in Touch & Addresses (Light Grey Background) -->
      <div class="contact-top-section" style="background: #f4f5f7; padding-top: 130px !important; padding-bottom: 70px; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 offset-lg-2">
              <h2 class="section-title text-center" style="margin-bottom: 15px; font-weight: 700; letter-spacing: -0.5px;">Get in Touch</h2>
              <p class="text-center" style="font-size: 16px; color: #606060; margin-bottom: 40px; line-height: 1.6;">Ready to capture your special moments? Fill in the details below and we'll get back to you via WhatsApp!</p>
              
              <div class="row text-center align-items-stretch">
                <?php foreach ($branches as $branch): ?>
                <div class="col-md-<?php echo count($branches) > 1 ? '6' : '12'; ?> mb-30 d-flex flex-column align-items-center">
                  <span class="icon icon-color color-default fs-48 mb-15"><i class="si-camping_map"></i></span>
                  <h6 class="mb-10" style="font-weight: 700; letter-spacing: 0.5px;"><?php echo sanitize($branch['branch_name']); ?></h6>
                  <div class="contact-branch-address">
                    <a href="<?php echo sanitize($branch['google_map']); ?>" target="_blank" class="address-map-contact-link">
                      <?php echo nl2br(sanitize($branch['address'])); ?>
                    </a>
                  </div>
                  <p class="mb-0 mt-auto">
                    <a href="tel:+91<?php echo $branch['phone']; ?>" class="contact-phone-link"><i class="fa fa-phone"></i> +91 <?php echo sanitize($branch['phone']); ?></a>
                  </p>
                </div>
                <!--/column -->
                <?php endforeach; ?>
              </div>
              <!--/.row -->
            </div>
            <!-- /column -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container -->
      </div>
      <!-- /.contact-top-section -->

      <!-- Bottom Section: Enquiry Form (White Background) -->
      <div class="contact-bottom-section" style="background: #ffffff; padding-top: 70px; padding-bottom: 90px;">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 offset-lg-2">
              
              <?php if ($success): ?>
              <div class="alert alert-success text-center">
                <strong>Thank you!</strong> Your enquiry has been submitted. Redirecting you to WhatsApp...
              </div>
              <?php endif; ?>

              <?php if (!empty($errors)): ?>
              <div class="alert alert-danger">
                <ul class="mb-0">
                  <?php foreach ($errors as $error): ?>
                  <li><?php echo $error; ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <?php endif; ?>

              <div class="contact-glass-wrapper">
                <div class="glass-blob blob-1"></div>
                <div class="glass-blob blob-2"></div>
                <div class="form-container contact-glass-card">
                  <form action="" method="post" class="vanilla vanilla-form" novalidate>
                    <?php csrf_field(); ?>
                    <div class="row text-center">
                      <div class="col-12">
                        <div class="form-group">
                          <input type="text" class="form-control" name="name" placeholder="Your Name *" required="required" value="<?php echo $_POST['name'] ?? ''; ?>">
                        </div>
                      </div>
                      <!--/column -->
                      <div class="col-12">
                        <div class="form-group">
                          <input type="tel" class="form-control" name="whatsapp_number" placeholder="WhatsApp Number *" required="required" pattern="[0-9]{10}" maxlength="10" value="<?php echo $_POST['whatsapp_number'] ?? ''; ?>">
                        </div>
                      </div>
                      <!--/column -->
                      <div class="col-12">
                        <div class="form-group">
                          <input type="date" class="form-control" name="event_date" placeholder="Date of Event *" required="required" value="<?php echo $_POST['event_date'] ?? ''; ?>">
                        </div>
                      </div>
                      <!--/column -->
                      <div class="col-12">
                        <div class="form-group">
                          <input type="text" class="form-control" name="event_details" placeholder="Event Details (e.g., Wedding, Birthday) *" required="required" value="<?php echo $_POST['event_details'] ?? ''; ?>">
                        </div>
                      </div>
                      <!--/column -->
                      <div class="col-12">
                        <div class="space20"></div>
                        <button type="submit" class="btn btn-purple-gradient">Submit Enquiry</button>
                        <a href="<?php echo WHATSAPP_URL; ?>?text=Hi%20AstraClicks!%20I'd%20like%20to%20enquire%20about%20your%20services." target="_blank" class="btn btn-white-glass shadow" style="margin-left:10px;"><i class="fa fa-whatsapp"></i> Direct WhatsApp</a>
                      </div>
                      <!--/column -->
                    </div>
                    <!--/.row -->
                  </form>
                  <!--/.vanilla-form -->
                </div>
                <!--/.form-container -->
              </div>
              <!--/.contact-glass-wrapper -->
              
            </div>
            <!-- /column -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container -->
      </div>
      <!-- /.contact-bottom-section -->

    </div>
    <!-- /.wrapper -->
<?php include 'includes/footer.php'; ?>
