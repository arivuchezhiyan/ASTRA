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
    color: #db8159 !important;
    text-decoration: underline !important;
  }
  .contact-branch-card {
    background: rgba(255, 255, 255, 0.9) !important;
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
    border-radius: 14px !important;
    padding: 18px 20px !important;
    width: 100%;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    margin-bottom: 20px;
  }
  .contact-branch-card:hover {
    background: #ffffff !important;
    border-color: rgba(219, 129, 89, 0.3) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 18px rgba(219, 129, 89, 0.08) !important;
  }
  .contact-branch-address {
    margin-bottom: 12px !important;
    font-size: 13px;
    line-height: 1.4;
    color: #555;
    width: 100%;
  }
  @media (min-width: 768px) and (max-width: 991px) {
    .contact-branch-address {
      min-height: auto;
      display: block;
    }
  }
  .contact-phone-link {
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
    border-radius: 50px !important;
    padding: 6px 18px !important;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
    color: #505050 !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    text-decoration: none !important;
  }
  .contact-phone-link:hover {
    background: #db8159 !important;
    border-color: #db8159 !important;
    color: #fff !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 15px rgba(219, 129, 89, 0.25) !important;
  }
  .contact-glass-wrapper {
    position: relative !important;
    width: 100% !important;
    margin-top: 0px !important;
    overflow: visible !important;
  }
  .contact-glass-card {
    position: relative !important;
    z-index: 2 !important;
    background: transparent !important;
    border: none !important;
    border-radius: 0 !important;
    padding: 0 !important;
    box-shadow: none !important;
    transition: none !important;
  }
  .contact-glass-card:hover {
    transform: none !important;
    box-shadow: none !important;
    background: transparent !important;
  }
  .contact-glass-card .form-control {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.12) !important;
    color: #333333 !important;
    border-radius: 30px !important;
    padding: 12px 22px !important;
    height: auto !important;
    font-size: 14.5px !important;
    transition: all 0.2s ease !important;
  }
  .contact-glass-card .form-control::placeholder {
    color: #888888 !important;
    opacity: 1 !important;
  }
  .contact-glass-card .form-control:-ms-input-placeholder {
    color: #888888 !important;
  }
  .contact-glass-card .form-control::-ms-input-placeholder {
    color: #888888 !important;
  }
  .contact-glass-card .form-control:focus {
    background: #ffffff !important;
    border-color: #db8159 !important;
    box-shadow: 0 0 8px rgba(219, 129, 89, 0.25) !important;
    color: #333333 !important;
  }
  .contact-glass-card input[type="date"] {
    color: #888888 !important;
  }
  .contact-glass-card input[type="date"]:focus,
  .contact-glass-card input[type="date"]:valid {
    color: #333333 !important;
  }
  .contact-glass-card input[type="date"]::-webkit-calendar-picker-indicator {
    filter: none !important;
    cursor: pointer !important;
  }
  .btn-purple-gradient {
    background: linear-gradient(135deg, #db8159 0%, #b05735 100%) !important;
    border: none !important;
    color: #fff !important;
    border-radius: 30px !important;
    padding: 12px 30px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    box-shadow: 0 4px 15px rgba(219, 129, 89, 0.3) !important;
    transition: all 0.3s ease !important;
  }
  .btn-purple-gradient:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(219, 129, 89, 0.45) !important;
    background: linear-gradient(135deg, #e3926e 0%, #9e4624 100%) !important;
  }
  .btn-white-glass {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
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
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
  }
  .btn-white-glass:hover {
    background: #25D366 !important;
    border-color: #25D366 !important;
    color: #ffffff !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.25) !important;
  }
</style>
</style>
    <div class="wrapper light-wrapper" style="background: #f4f5f7; padding-top: 130px !important; padding-bottom: 95px;">
      <div class="container">
        
        <!-- Heading -->
        <div class="row">
          <div class="col-lg-12">
            <h2 class="section-title text-center" style="margin-bottom: 15px; font-weight: 700; letter-spacing: -0.5px;">Get in Touch</h2>
            <p class="text-center" style="font-size: 16px; color: #606060; margin-bottom: 50px; line-height: 1.6;">Ready to capture your special moments? Fill in the details below and we'll get back to you via WhatsApp!</p>
          </div>
        </div>

        <div class="row align-items-start">
          
          <!-- Left Column: Addresses -->
          <div class="col-lg-5 mb-50 mb-lg-0">
            <div class="row text-center text-lg-left">
              <?php foreach ($branches as $branch): ?>
              <div class="col-md-6 col-lg-12">
                <div class="contact-branch-card d-flex flex-column align-items-center align-items-lg-start">
                  <span class="icon icon-color color-default fs-40 mb-10" style="color: #db8159 !important;"><i class="si-camping_map"></i></span>
                  <h6 class="mb-10" style="font-weight: 700; letter-spacing: 0.5px; font-size: 15px;"><?php echo sanitize($branch['branch_name']); ?></h6>
                  <div class="contact-branch-address">
                    <a href="<?php echo sanitize($branch['google_map']); ?>" target="_blank" class="address-map-contact-link">
                      <?php echo sanitize(get_compact_address($branch['address'])); ?>
                    </a>
                  </div>
                  <p class="mb-0 mt-auto">
                    <a href="tel:+91<?php echo $branch['phone']; ?>" class="contact-phone-link"><i class="fa fa-phone"></i> +91 <?php echo sanitize($branch['phone']); ?></a>
                  </p>
                </div>
              </div>
              <!--/column -->
              <?php endforeach; ?>
            </div>
            <!--/.row -->
          </div>
          
          <!-- Right Column: Enquiry Form -->
          <div class="col-lg-7">
            
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

            <div class="contact-glass-wrapper" style="margin-top: 0 !important;">
              <div class="form-container contact-glass-card">
                <form action="" method="post" class="vanilla vanilla-form" novalidate>
                  <?php csrf_field(); ?>
                  <div class="row text-center text-lg-left">
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
                    <div class="col-12 text-center">
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
          <!--/column -->
        </div>
        <!--/.row -->

      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
<?php include 'includes/footer.php'; ?>
