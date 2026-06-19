<?php
/**
 * Frontend Footer Include
 * Preserves exact Missio footer design with dynamic content
 */
$footer_branches = get_branches($pdo);
?>
    <style>
      .footer-glass-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.03) 100%);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.12), 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), background 0.3s, border-color 0.3s, box-shadow 0.3s;
      }
      .footer-glass-card:hover {
        transform: translateY(-4px);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.04) 100%);
        border-color: rgba(255, 255, 255, 0.18);
        box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.2), 0 12px 40px rgba(0, 0, 0, 0.35);
      }
      .footer-glass-card h6 {
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 8px;
      }
      .footer-glass-card p {
        font-size: 14px;
        line-height: 1.5;
        color: rgba(255, 255, 255, 0.95);
        margin-bottom: 8px;
      }
      .footer-glass-card a.nocolor {
        color: rgba(255, 255, 255, 0.95);
        font-size: 14px;
      }
      .footer-glass-card a.nocolor:hover {
        color: #fff !important;
      }
      .footer-quick-links {
        list-style: none;
        padding: 0;
        margin: 0;
      }
      .footer-quick-links li {
        margin-bottom: 10px;
      }
      .footer-quick-links a {
        color: rgba(255, 255, 255, 0.95) !important;
        font-size: 15px;
        font-weight: 500;
        transition: color 0.2s ease;
      }
      .footer-quick-links a:hover {
        color: #fff !important;
        text-decoration: none;
      }
      @media (min-width: 768px) {
        .footer-contact-shift {
          transform: translateX(-80px);
        }
        .footer-brand-shift {
          transform: translate(25px, 20px);
        }
        .footer-links-shift {
          transform: translateY(20px);
        }
      }
      /* Fix sticky header on mobile viewports */
      @media (max-width: 991.98px) {
        body:not(.onepage) .banner--stick {
          display: block !important;
        }
      }
      .footer-glass-oval {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 50px;
        padding: 6px 16px;
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.95) !important;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.1), 0 4px 10px rgba(0, 0, 0, 0.1);
      }
      .footer-glass-oval:hover {
        background: rgba(255, 255, 255, 0.16);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        color: #fff !important;
        box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.2), 0 8px 16px rgba(0, 0, 0, 0.2);
        text-decoration: none !important;
      }
      .social-glass-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        color: rgba(255, 255, 255, 0.95) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.1), 0 4px 10px rgba(0, 0, 0, 0.1);
      }
      .social-glass-icon i {
        font-size: 15px;
      }
      .social-glass-icon:hover {
        background: rgba(255, 255, 255, 0.16);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        color: #fff !important;
        box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.2), 0 8px 16px rgba(0, 0, 0, 0.2);
        text-decoration: none !important;
      }
      .address-map-link {
        color: rgba(255, 255, 255, 0.95) !important;
        text-decoration: none;
        transition: color 0.2s ease;
      }
      .address-map-link:hover {
        color: #fff !important;
        text-decoration: underline !important;
      }
      .footer-contact-title {
        font-size: 18px;
      }
      .footer-logo-title {
        font-size: 44px;
      }
      .footer-links-title {
        font-size: 16px;
      }
      @media (max-width: 767.98px) {
        .footer-contact-title {
          font-size: 14px !important;
        }
        .footer-logo-title {
          font-size: 32px !important;
          margin-top: 10px;
          margin-bottom: 8px !important;
        }
        .footer-links-title {
          font-size: 13px !important;
          margin-top: 15px;
          margin-bottom: 8px !important;
        }
        .footer-glass-card {
          padding: 12px 15px !important;
        }
        .footer-glass-card h6 {
          font-size: 13.5px !important;
          margin-bottom: 5px !important;
        }
        .footer-glass-card p,
        .footer-glass-card a.nocolor {
          font-size: 12px !important;
          margin-bottom: 5px !important;
        }
        .footer-quick-links li {
          margin-bottom: 6px !important;
        }
        .footer-quick-links a {
          font-size: 12.5px !important;
        }
        .footer-glass-oval {
          padding: 4px 12px !important;
          font-size: 11.5px !important;
          margin-top: 4px !important;
        }
        .social-glass-icon {
          width: 32px !important;
          height: 32px !important;
          border-radius: 8px !important;
        }
        .social-glass-icon i {
          font-size: 13px !important;
        }
        .footer-quick-links {
          text-align: center !important;
        }
        .col-md-6.mb-20,
        .col-md-3.mb-20 {
          margin-bottom: 12px !important;
        }
        body {
          padding-bottom: 70px !important;
        }
        .mobile-fixed-cta {
          position: fixed;
          bottom: 0;
          left: 0;
          right: 0;
          z-index: 9999;
          background: rgba(12, 12, 12, 0.95) !important;
          backdrop-filter: blur(16px) !important;
          -webkit-backdrop-filter: blur(16px) !important;
          border-top: 1px solid rgba(255, 255, 255, 0.12) !important;
          padding: 10px 15px !important;
          box-shadow: 0 -5px 25px rgba(0, 0, 0, 0.5) !important;
        }
        .cta-btn-group {
          display: flex !important;
          gap: 8px !important;
          justify-content: space-between !important;
          align-items: center !important;
          width: 100% !important;
        }
        .cta-btn {
          flex: 1 !important;
          display: inline-flex !important;
          align-items: center !important;
          justify-content: center !important;
          gap: 5px !important;
          height: 44px !important;
          padding: 0 5px !important;
          border-radius: 30px !important;
          font-size: 11px !important;
          font-weight: 700 !important;
          text-transform: uppercase !important;
          letter-spacing: 0.3px !important;
          transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
          text-decoration: none !important;
          white-space: nowrap !important;
          line-height: 1 !important;
          box-sizing: border-box !important;
        }
        .cta-btn i {
          font-size: 13px !important;
          margin: 0 !important;
          line-height: 1 !important;
          display: inline-block !important;
        }
        .cta-btn.cta-whatsapp {
          background: rgba(37, 211, 102, 0.16) !important;
          border: 1px solid rgba(37, 211, 102, 0.35) !important;
          color: #25D366 !important;
        }
        .cta-btn.cta-whatsapp:active {
          background: rgba(37, 211, 102, 0.28) !important;
          transform: scale(0.96) !important;
        }
        .cta-btn.cta-call {
          background: rgba(255, 255, 255, 0.08) !important;
          border: 1px solid rgba(255, 255, 255, 0.18) !important;
          color: rgba(255, 255, 255, 0.95) !important;
        }
        .cta-btn.cta-call:active {
          background: rgba(255, 255, 255, 0.18) !important;
          transform: scale(0.96) !important;
        }
        .cta-btn.cta-book {
          background: linear-gradient(135deg, #b05735 0%, #9b4b2c 100%) !important;
          border: none !important;
          color: #ffffff !important;
          box-shadow: 0 4px 12px rgba(155, 75, 44, 0.3) !important;
        }
        .cta-btn.cta-book:active {
          background: linear-gradient(135deg, #9b4b2c 0%, #7d381d 100%) !important;
          transform: scale(0.96) !important;
          box-shadow: 0 2px 6px rgba(155, 75, 44, 0.2) !important;
        }
      }

      /* Social Popup Overlay */
      .social-popup-overlay {
        display: flex;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 100000;
        justify-content: center;
        align-items: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      }

      .social-popup-overlay.active {
        opacity: 1;
        pointer-events: auto;
      }

      /* Glassmorphism Popup Card */
      .social-popup-card {
        position: relative;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.03) 100%);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 24px;
        width: 90%;
        max-width: 480px;
        padding: 40px 30px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), inset 0 1px 1px rgba(255, 255, 255, 0.15);
        transform: scale(0.8) translateY(20px);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-align: center;
        color: #fff;
      }

      .social-popup-overlay.active .social-popup-card {
        transform: scale(1) translateY(0);
      }

      /* Close Button */
      .social-popup-close {
        position: absolute;
        top: 15px;
        right: 20px;
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.6);
        font-size: 28px;
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
        line-height: 1;
      }

      .social-popup-close:hover {
        color: #fff;
        transform: scale(1.1);
      }

      /* Header */
      .social-popup-header h3 {
        font-family: 'Great Vibes', 'Brush Script MT', cursive;
        font-size: 42px;
        margin-bottom: 8px;
        color: #fff;
        text-transform: none;
        font-weight: normal;
      }

      .social-popup-header p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
        margin-bottom: 30px;
      }

      /* Buttons Grid */
      .social-popup-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
      }

      /* Individual Social Button */
      .popup-social-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px 10px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        text-decoration: none !important;
        color: #fff !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      }

      .popup-social-btn .icon-wrap {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-bottom: 12px;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      }

      .popup-social-btn .icon-wrap i {
        font-size: 24px;
      }

      .popup-social-btn span {
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.5px;
      }

      /* Hover States with Custom Glows & Colors */
      /* WhatsApp */
      .popup-social-btn.whatsapp:hover {
        background: rgba(37, 211, 102, 0.15);
        border-color: rgba(37, 211, 102, 0.4);
        box-shadow: 0 10px 20px rgba(37, 211, 102, 0.25);
        transform: translateY(-5px);
      }
      .popup-social-btn.whatsapp:hover .icon-wrap {
        background: #25D366;
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(37, 211, 102, 0.6);
      }

      /* Facebook */
      .popup-social-btn.facebook:hover {
        background: rgba(24, 119, 242, 0.15);
        border-color: rgba(24, 119, 242, 0.4);
        box-shadow: 0 10px 20px rgba(24, 119, 242, 0.25);
        transform: translateY(-5px);
      }
      .popup-social-btn.facebook:hover .icon-wrap {
        background: #1877F2;
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(24, 119, 242, 0.6);
      }

      /* Instagram */
      .popup-social-btn.instagram:hover {
        background: rgba(225, 48, 108, 0.15);
        border-color: rgba(225, 48, 108, 0.4);
        box-shadow: 0 10px 20px rgba(225, 48, 108, 0.25);
        transform: translateY(-5px);
      }
      .popup-social-btn.instagram:hover .icon-wrap {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(225, 48, 108, 0.6);
      }

      /* YouTube */
      .popup-social-btn.youtube:hover {
        background: rgba(255, 0, 0, 0.15);
        border-color: rgba(255, 0, 0, 0.4);
        box-shadow: 0 10px 20px rgba(255, 0, 0, 0.25);
        transform: translateY(-5px);
      }
      .popup-social-btn.youtube:hover .icon-wrap {
        background: #FF0000;
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(255, 0, 0, 0.6);
      }

      @media (max-width: 480px) {
        .social-popup-card {
          padding: 30px 20px;
        }
        .social-popup-header h3 {
          font-size: 34px;
        }
        .social-popup-grid {
          gap: 12px;
        }
        .popup-social-btn {
          padding: 15px 8px;
        }
      }

      .social-popup-screen {
        width: 100%;
      }
      
      .social-popup-back-btn {
        position: absolute;
        top: 15px;
        left: 20px;
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.6);
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
      }

      .social-popup-back-btn:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.15);
        transform: translateX(-2px);
      }

      .social-popup-back-btn i {
        font-size: 12px;
      }
    </style>
    <footer class="dark-wrapper inverse-text">
      <div class="container inner" style="padding-top: 40px; padding-bottom: 25px;">
        <div class="row" style="margin-bottom: -35px !important;">
          <div class="col-md-6 mb-20 mb-md-0 footer-contact-shift">
            <div class="text-center mb-15">
              <h4 class="text-uppercase footer-contact-title" style="letter-spacing: 1.5px; color: #fff; font-weight: 700; margin-bottom: 0;">Contact Us</h4>
            </div>
            <div class="row">
              <?php foreach ($footer_branches as $branch): ?>
              <div class="col-md-6 mb-20 mb-md-0 d-flex flex-column">
                <div class="footer-glass-card">
                  <h6><?php echo sanitize($branch['branch_name']); ?></h6>
                  <p>
                    <a href="<?php echo sanitize($branch['google_map']); ?>" target="_blank" class="address-map-link">
                      <?php echo sanitize(get_compact_address($branch['address'])); ?>
                    </a>
                  </p>
                  <p class="mb-0">
                    <a href="tel:+91<?php echo sanitize($branch['phone']); ?>" class="footer-glass-oval"><i class="fa fa-phone"></i> +91 <?php echo sanitize($branch['phone']); ?></a>
                  </p>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <!--/column -->
          <div class="col-md-3 mb-20 mb-md-0 text-center d-flex flex-column footer-brand-shift">
            <h2 class="footer-logo-title" style="font-family: 'Great Vibes', 'Brush Script MT', cursive; color: #fff; font-weight: normal; text-transform: none; margin-bottom: 15px; line-height: 1;">AstraClicks</h2>
            <div class="footer-glass-card" style="flex: none; height: auto;">
              <p class="mb-15">Capturing your special moments with creativity, concept & passion.</p>
              <ul class="social-glass-list" style="display: flex; justify-content: center; gap: 12px; list-style: none; padding: 0; margin-top: 15px; margin-bottom: 0;">
                <li><a href="<?php echo WHATSAPP_URL; ?>" target="_blank" class="social-glass-icon"><i class="fa fa-whatsapp"></i></a></li>
                <li><a href="<?php echo get_setting($pdo, 'facebook_url', '#'); ?>" target="_blank" class="social-glass-icon"><i class="fa fa-facebook-f"></i></a></li>
                <li><a href="<?php echo get_setting($pdo, 'instagram_url', '#'); ?>" target="_blank" class="social-glass-icon"><i class="fa fa-instagram"></i></a></li>
                <li><a href="<?php echo get_setting($pdo, 'youtube_url', '#'); ?>" target="_blank" class="social-glass-icon"><i class="fa fa-youtube-play"></i></a></li>
              </ul>
            </div>
          </div>
          <!--/column -->
          <div class="col-md-3 mb-20 mb-md-0 text-center text-md-right d-none d-md-flex flex-column footer-links-shift">
            <h4 class="text-uppercase footer-links-title" style="letter-spacing: 1px; margin-bottom: 15px; color: #fff; font-weight: 700;">Quick Links</h4>
            <ul class="footer-quick-links">
              <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
              <li><a href="<?php echo BASE_URL; ?>/services">Services</a></li>
              <li><a href="<?php echo BASE_URL; ?>/gallery">Gallery</a></li>
              <li><a href="<?php echo BASE_URL; ?>/blogs">Blog</a></li>
              <li><a href="<?php echo BASE_URL; ?>/contact">Contact</a></li>
            </ul>
          </div>
          <!--/column -->
        </div>
        <!--/.row -->
        <hr class="mt-0 mb-15" style="margin-top: -25px !important;">
        <div class="row d-md-flex align-items-md-center">
          <div class="col-md-12 text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> AstraClicks. All rights reserved.</p>
          </div>
          <!--/column -->
        </div>
        <!--/.row -->
      </div>
      <!-- /.container -->
    </footer>
  </div>
  <!-- /.content-wrapper -->

  <!-- Floating WhatsApp Button (Hidden on Mobile) -->
  <a href="<?php echo WHATSAPP_URL; ?>?text=Hi%20AstraClicks!%20I'm%20interested%20in%20your%20photography%20services." target="_blank" id="whatsapp-float" class="d-none d-md-flex" style="position:fixed;bottom:25px;right:25px;width:60px;height:60px;background:#25D366;border-radius:50%;align-items:center;justify-content:center;z-index:9999;box-shadow:0 4px 15px rgba(37,211,102,0.4);transition:all 0.3s ease;">
    <i class="fa fa-whatsapp" style="color:#fff;font-size:32px;"></i>
  </a>
  <style>
    #whatsapp-float:hover { transform: scale(1.1); box-shadow: 0 6px 20px rgba(37,211,102,0.6); }
  </style>

  <!-- Mobile Fixed Footer CTA Bar -->
  <div class="mobile-fixed-cta d-md-none">
    <div class="cta-btn-group">
      <a href="<?php echo WHATSAPP_URL; ?>?text=Hi%20AstraClicks!%20I'm%20interested%20in%20booking%20a%20photography%20shoot." target="_blank" class="cta-btn cta-whatsapp">
        <i class="fa fa-whatsapp"></i> WhatsApp
      </a>
      <a href="tel:+918754114739" class="cta-btn cta-call">
        <i class="fa fa-phone"></i> Call
      </a>
      <a href="<?php echo BASE_URL; ?>/contact" class="cta-btn cta-book">
        <i class="fa fa-calendar"></i> Book Now
      </a>
    </div>
  </div>

  <!-- Social Popup Modal -->
  <div id="social-media-popup" class="social-popup-overlay">
    <div class="social-popup-card">
      <button class="social-popup-close" id="social-popup-close-btn">&times;</button>
      
      <!-- Screen 1: Main Menu -->
      <div class="social-popup-screen" id="social-popup-screen-main">
        <div class="social-popup-header">
          <h3>AstraClicks</h3>
          <p>Follow us on our social networks or text us directly</p>
        </div>
        <div class="social-popup-grid">
          <a href="<?php echo WHATSAPP_URL; ?>" target="_blank" class="popup-social-btn whatsapp">
            <div class="icon-wrap"><i class="fa fa-whatsapp"></i></div>
            <span>WhatsApp</span>
          </a>
          <a href="<?php echo get_setting($pdo, 'facebook_url', '#'); ?>" target="_blank" class="popup-social-btn facebook">
            <div class="icon-wrap"><i class="fa fa-facebook-f"></i></div>
            <span>Facebook</span>
          </a>
          <a href="#" class="popup-social-btn instagram" id="main-instagram-btn">
            <div class="icon-wrap"><i class="fa fa-instagram"></i></div>
            <span>Instagram</span>
          </a>
          <a href="<?php echo get_setting($pdo, 'youtube_url', '#'); ?>" target="_blank" class="popup-social-btn youtube">
            <div class="icon-wrap"><i class="fa fa-youtube-play"></i></div>
            <span>YouTube</span>
          </a>
        </div>
      </div>

      <!-- Screen 2: Instagram Sub-menu -->
      <div class="social-popup-screen" id="social-popup-screen-instagram" style="display: none;">
        <button class="social-popup-back-btn" id="social-popup-back-btn"><i class="fa fa-arrow-left"></i> Back</button>
        <div class="social-popup-header" style="margin-top: 15px;">
          <h3>Instagram Pages</h3>
          <p>Choose which of our Instagram pages you want to visit</p>
        </div>
        <div class="social-popup-grid">
          <a href="https://www.instagram.com/weddings_by_astra?igsh=MTJpbWgwYzFyNjUw" target="_blank" class="popup-social-btn instagram">
            <div class="icon-wrap"><i class="fa fa-instagram"></i></div>
            <span>Wedding Page</span>
          </a>
          <a href="https://www.instagram.com/astraclicks?igsh=NGNzY2RxczA4bW9v" target="_blank" class="popup-social-btn instagram">
            <div class="icon-wrap"><i class="fa fa-instagram"></i></div>
            <span>Baby Shoot Page</span>
          </a>
        </div>
      </div>
      
    </div>
  </div>

  <script src="<?php echo ASSETS_URL; ?>/js/jquery.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/js/popper.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/js/bootstrap.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/revolution/js/jquery.themepunch.tools.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/revolution/js/jquery.themepunch.revolution.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/revolution/js/extensions/revolution.extension.actions.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/revolution/js/extensions/revolution.extension.migration.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/revolution/js/extensions/revolution.extension.video.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/js/plugins.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/js/scripts.js?v=1.3"></script>
  <script>
    $(document).ready(function() {
      // Intercept clicks on the footer social glass icons
      $('.social-glass-icon').on('click', function(e) {
        e.preventDefault();
        $('#social-media-popup').addClass('active');
      });

      // Switch to Instagram screen
      $('#main-instagram-btn').on('click', function(e) {
        e.preventDefault();
        $('#social-popup-screen-main').fadeOut(200, function() {
          $('#social-popup-screen-instagram').fadeIn(200);
        });
      });

      // Switch back to Main screen
      $('#social-popup-back-btn').on('click', function() {
        $('#social-popup-screen-instagram').fadeOut(200, function() {
          $('#social-popup-screen-main').fadeIn(200);
        });
      });

      // Helper function to reset popup state
      function resetPopup() {
        $('#social-media-popup').removeClass('active');
        // Reset to main screen after modal transition finishes
        setTimeout(function() {
          $('#social-popup-screen-instagram').hide();
          $('#social-popup-screen-main').show();
        }, 400);
      }

      // Close button handler
      $('#social-popup-close-btn').on('click', function() {
        resetPopup();
      });

      // Overlay backdrop click handler
      $('#social-media-popup').on('click', function(e) {
        if (e.target === this) {
          resetPopup();
        }
      });

      // Esc key closes popup
      $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
          resetPopup();
        }
      });
    });
  </script>
</body>
</html>
