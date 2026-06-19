<?php
/**
 * Frontend Header Include
 * Supports 'home' and 'inner' page types
 */
if (!isset($page_type)) $page_type = 'inner';
if (!isset($page_title)) $page_title = SITE_NAME . ' - ' . SITE_TAGLINE;
if (!isset($meta_description)) $meta_description = get_setting($pdo, 'meta_description', 'AstraClicks - Professional Photography & Videography Studio in Chennai');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$site_url = $protocol . $host;

if (!isset($canonical_url)) {
    $canonical_url = $site_url . $_SERVER['REQUEST_URI'];
} else {
    if (strpos($canonical_url, 'http') !== 0) {
        $canonical_url = $site_url . $canonical_url;
    }
}

if (!isset($og_image)) {
    $og_image = BASE_URL . '/assets/images/images/pre_wedding/pre_wedding_1.jpg';
}
if (strpos($og_image, 'http') !== 0) {
    $og_image = $site_url . $og_image;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/assets/images/icons/astra_clicks_fav_icon.png">
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>/assets/images/icons/astra_clicks_fav_icon.png">
  <title><?php echo sanitize($page_title); ?></title>
  <meta name="description" content="<?php echo sanitize($meta_description); ?>">
  <link rel="canonical" href="<?php echo $canonical_url; ?>">
  <!-- Open Graph -->
  <meta property="og:title" content="<?php echo sanitize($page_title); ?>">
  <meta property="og:description" content="<?php echo sanitize($meta_description); ?>">
  <meta property="og:image" content="<?php echo $og_image; ?>">
  <meta property="og:url" content="<?php echo $canonical_url; ?>">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="AstraClicks">
  <!-- Schema.org -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "AstraClicks",
    "description": "<?php echo sanitize($meta_description); ?>",
    "url": "<?php echo BASE_URL; ?>",
    "telephone": "+918754114739",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "1st Floor, No 71, Ponniamman Koil St, Ram Nagar, Puzhuthivakkam",
      "addressLocality": "Chennai",
      "addressRegion": "Tamil Nadu",
      "postalCode": "600091",
      "addressCountry": "IN"
    },
    "image": "<?php echo $og_image; ?>",
    "priceRange": "$$"
  }
  </script>
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL; ?>/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL; ?>/css/plugins.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL; ?>/revolution/css/settings.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL; ?>/revolution/css/layers.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL; ?>/revolution/css/navigation.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/style/type/icons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL; ?>/css/color/purple.css">
  <!-- <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL; ?>/css/font/font5.css">
  <style>
    /* Fixed Navigation Bar Style */
    .navbar.fixed-top {
      background: #f6f7fa !important;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
      border-bottom: 1px solid rgba(0, 0, 0, 0.06) !important;
      position: fixed !important;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1030;
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }
    
    /* Remove padding in navbar brand */
    .navbar-brand {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
      margin-top: 0 !important;
      margin-bottom: 0 !important;
    }

    /* Minimize spacing in header content wrapper */
    .navbar:not(.fixed) .navbar-header,
    .navbar.fixed-top .navbar-header {
      padding-top: 3px !important;
      padding-bottom: 3px !important;
    }

    /* Minimize spacing for nav links */
    .navbar.wide:not(.transparent) .navbar-nav .nav-link,
    .navbar.fixed-top.wide .navbar-nav .nav-link,
    .navbar.fixed-top .navbar-nav .nav-link {
      padding-top: 10px !important;
      padding-bottom: 10px !important;
    }
    
    /* Reduce logo size and align it cleanly */
    .navbar-brand img {
      max-height: 58px !important;
      margin-top: 0 !important;
      display: block;
    }
    
    /* Push home page content down to clear the fixed header */
    .home-page {
      padding-top: 64px !important;
    }
    
    /* Custom Header Spacing for Inner Pages to clear the new compact header */
    .inner-page-padding {
      padding-top: 145px !important;
    }
    
    .inner-banner-padding {
      padding-top: 124px !important;
    }
    
    /* Responsive Logo & Padding for Mobile */
    @media (max-width: 991.98px) {
      .navbar-brand img {
        max-height: 44px !important;
        margin-top: 0 !important;
      }
      .navbar:not(.fixed) .navbar-header,
      .navbar.fixed-top .navbar-header {
        padding-top: 3px !important;
        padding-bottom: 3px !important;
      }
      .home-page {
        padding-top: 50px !important;
      }
      .inner-page-padding {
        padding-top: 110px !important;
      }
      .inner-banner-padding {
        padding-top: 100px !important;
      }
    }
    
    /* Enquiry Header Button Style */
    .btn-enquiry-header {
      background: linear-gradient(135deg, #b05735 0%, #9b4b2c 100%) !important;
      border: none !important;
      color: #ffffff !important;
      border-radius: 50px !important;
      padding: 8px 24px !important;
      font-weight: 600 !important;
      font-size: 14px !important;
      letter-spacing: 0.5px !important;
      box-shadow: 0 4px 15px rgba(155, 75, 44, 0.25) !important;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
      text-decoration: none !important;
      display: inline-block;
      line-height: 1.2 !important;
      white-space: nowrap !important;
    }
    
    .btn-enquiry-header:hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 6px 20px rgba(155, 75, 44, 0.4) !important;
      color: #ffffff !important;
      filter: brightness(1.05) !important;
      text-decoration: none !important;
    }

    /* Mobile specific adjustments */
    @media (max-width: 991.98px) {
      .btn-enquiry-header {
        padding: 6px 16px !important;
        font-size: 12.5px !important;
      }
    }
    @media (max-width: 760px) {
      .btn-enquiry-header {
        display: none;
      }
    }
  </style>
</head>
<body class="<?php echo $page_type; ?>-page">
  <div class="content-wrapper">
    <nav class="navbar wide navbar-expand-lg fixed-top bg-light">
      <div class="container-fluid flex-row justify-content-center">
        <div class="navbar-header">
          <div class="navbar-brand"><a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>/assets/images/icons/astra_clicks_logo.png" alt="AstraClicks" style="max-height: 95px; width: auto;" /></a></div>
          <div class="navbar-hamburger ml-auto d-lg-none d-xl-none d-flex align-items-center">
            <a href="<?php echo BASE_URL; ?>/contact" class="btn-enquiry-header" style="margin-right: 15px !important;">Enquiry Now</a>
            <button class="hamburger animate" data-toggle="collapse" data-target=".navbar-collapse"><span></span></button>
          </div>
        </div>
        <!-- /.navbar-header -->
        <div class="navbar-collapse collapse justify-content-between align-items-center">
          <ul class="navbar-nav plain mx-auto text-center">
            <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/services">Services</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/gallery">Gallery</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/blogs">Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/contact">Contact</a></li>
          </ul>
          <div class="navbar-enquiry-btn d-none d-lg-block">
            <a href="<?php echo BASE_URL; ?>/contact" class="btn-enquiry-header">Enquiry Now</a>
          </div>
        </div>
      </div>
    </nav>
