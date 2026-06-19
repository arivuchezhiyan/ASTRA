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

<style>
  /* Subtle light leak decoration background glows */
  .service-section-wrap {
    position: relative;
    overflow: hidden;
  }
  .service-section-wrap::after {
    content: "";
    position: absolute;
    top: -10%;
    left: -10%;
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, rgba(176, 87, 53, 0.04) 0%, rgba(255, 255, 255, 0) 70%);
    z-index: 0;
    pointer-events: none;
  }
  .service-section-wrap:nth-child(even)::after {
    left: auto;
    right: -10%;
    background: radial-gradient(circle, rgba(155, 75, 44, 0.04) 0%, rgba(255, 255, 255, 0) 70%);
  }

  /* Mosaic Collage Grid Layout */
  .service-collage {
    position: relative;
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    grid-template-rows: repeat(12, 1fr);
    width: 100%;
    aspect-ratio: 4/3;
    padding: 10px;
    box-sizing: border-box;
    z-index: 2;
  }

  /* Polaroid-style collage items with borders, shadows and rotations */
  .collage-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    border: 5px solid #fff;
    background: #fff;
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease, z-index 0.1s ease;
  }

  .collage-item img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Hover effect scale, lift, and rotate neutral */
  .collage-item:hover {
    transform: scale(1.06) translateY(-6px) rotate(0deg) !important;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.22);
    z-index: 10 !important;
  }

  /* ========================================== */
  /* Collage Decorations (Unique Per Service)  */
  /* ========================================== */

  /* --- STYLE 1: Weddings (Sticky Tape Overlay) --- */
  .collage-style-1 .collage-item::before {
    content: "";
    position: absolute;
    top: -12px;
    left: 50%;
    width: 70px;
    height: 24px;
    background: rgba(246, 247, 250, 0.45);
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
    border: 1px dashed rgba(0, 0, 0, 0.08);
    box-shadow: 0 2px 4px rgba(0,0,0,0.03);
    z-index: 5;
    pointer-events: none;
  }
  .collage-style-1 .collage-img-1::before { transform: translateX(-50%) rotate(-12deg); }
  .collage-style-1 .collage-img-2::before { transform: translateX(-50%) rotate(7deg); }
  .collage-style-1 .collage-img-3::before { transform: translateX(-50%) rotate(14deg); }
  .collage-style-1 .collage-img-4::before { transform: translateX(-50%) rotate(-8deg); }

  /* --- STYLE 2: Reception (Realistic Paperclip) --- */
  .collage-style-2 .collage-item::before {
    content: "";
    position: absolute;
    top: -8px;
    right: 25px;
    width: 14px;
    height: 38px;
    border: 2px solid #8e8e93;
    border-radius: 8px;
    background: transparent;
    z-index: 5;
    transform: rotate(15deg);
    box-shadow: -1px 2px 3px rgba(0,0,0,0.12);
  }
  .collage-style-2 .collage-item::after {
    content: "";
    position: absolute;
    top: 2px;
    right: 27px;
    width: 8px;
    height: 22px;
    border: 2px solid #8e8e93;
    border-top: none;
    border-radius: 0 0 5px 5px;
    z-index: 5;
    transform: rotate(15deg);
  }

  /* --- STYLE 3: Pre-Wedding (Colored Pushpin) --- */
  .collage-style-3 .collage-item::before {
    content: "";
    position: absolute;
    top: 6px;
    left: 50%;
    transform: translateX(-50%);
    width: 13px;
    height: 13px;
    background: #e15b5b;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.35), inset 0 2px 2px rgba(255,255,255,0.4);
    z-index: 5;
  }
  .collage-style-3 .collage-item::after {
    content: "";
    position: absolute;
    top: 12px;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 6px;
    background: #7a7a7a;
    z-index: 4;
    box-shadow: 1px 1px 2px rgba(0,0,0,0.25);
  }

  /* --- STYLE 4: Baby Shoots (Cute Heart Sticker) --- */
  .collage-style-4 .collage-item::before {
    content: "♥";
    position: absolute;
    top: 4px;
    left: 50%;
    transform: translateX(-50%);
    color: #f38181;
    font-size: 24px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.18);
    z-index: 5;
  }

  /* --- STYLE 5: Birthdays (Decorative Postage Stamp) --- */
  .collage-style-5 .collage-item::before {
    content: "Astra";
    position: absolute;
    top: 8px;
    right: 8px;
    background: #fdf6ec;
    border: 1px dashed #e6a23c;
    color: #e6a23c;
    font-size: 9px;
    font-weight: 700;
    padding: 2px 5px;
    text-transform: uppercase;
    transform: rotate(8deg);
    z-index: 5;
    box-shadow: 0 2px 5px rgba(0,0,0,0.08);
  }

  /* --- STYLE 6: Baby Shower (Corner Photo Mounts) --- */
  .collage-style-6 .collage-item::before {
    content: "";
    position: absolute;
    bottom: 5px;
    left: 5px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 16px 16px 0 0;
    border-color: #3f3f3f transparent transparent transparent;
    z-index: 5;
    opacity: 0.8;
  }
  .collage-style-6 .collage-item::after {
    content: "";
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 16px 16px 0;
    border-color: transparent #3f3f3f transparent transparent;
    z-index: 5;
    opacity: 0.8;
  }

  /* --- STYLE 7: Maternity (Luxury Gold Corner Clips) --- */
  .collage-style-7 .collage-item::before {
    content: "";
    position: absolute;
    top: 8px;
    left: 8px;
    width: 15px;
    height: 15px;
    border-top: 3px solid #d4af37;
    border-left: 3px solid #d4af37;
    z-index: 5;
    filter: drop-shadow(1px 1px 1px rgba(0,0,0,0.15));
  }
  .collage-style-7 .collage-item::after {
    content: "";
    position: absolute;
    top: 8px;
    right: 8px;
    width: 15px;
    height: 15px;
    border-top: 3px solid #d4af37;
    border-right: 3px solid #d4af37;
    z-index: 5;
    filter: drop-shadow(-1px 1px 1px rgba(0,0,0,0.15));
  }

  /* Layout 1: Classic Overlap */
  .collage-style-1 .collage-img-1 { grid-column: 1 / 8; grid-row: 1 / 9; z-index: 2; transform: rotate(-1.5deg); }
  .collage-style-1 .collage-img-2 { grid-column: 7 / 13; grid-row: 2 / 8; z-index: 1; transform: rotate(2deg); }
  .collage-style-1 .collage-img-3 { grid-column: 2 / 7; grid-row: 8 / 13; z-index: 3; transform: rotate(3deg); }
  .collage-style-1 .collage-img-4 { grid-column: 6 / 12; grid-row: 7 / 13; z-index: 4; transform: rotate(-2.5deg); }

  /* Layout 2: Triptych + Central Focus (Reception) */
  .collage-style-2 .collage-img-1 { grid-column: 4 / 10; grid-row: 1 / 13; z-index: 2; transform: rotate(0.5deg); }
  .collage-style-2 .collage-img-2 { grid-column: 1 / 5; grid-row: 2 / 7; z-index: 1; transform: rotate(-4deg); }
  .collage-style-2 .collage-img-3 { grid-column: 9 / 13; grid-row: 3 / 8; z-index: 3; transform: rotate(3.5deg); }
  .collage-style-2 .collage-img-4 { grid-column: 1 / 5; grid-row: 7 / 12; z-index: 4; transform: rotate(3deg); }

  /* Layout 3: Scattered Stream (Pre-Wedding) */
  .collage-style-3 .collage-img-1 { grid-column: 1 / 6; grid-row: 5 / 13; z-index: 2; transform: rotate(-3deg); }
  .collage-style-3 .collage-img-2 { grid-column: 4 / 9; grid-row: 1 / 9; z-index: 1; transform: rotate(2.5deg); }
  .collage-style-3 .collage-img-3 { grid-column: 7 / 12; grid-row: 6 / 13; z-index: 3; transform: rotate(-4deg); }
  .collage-style-3 .collage-img-4 { grid-column: 9 / 13; grid-row: 2 / 7; z-index: 4; transform: rotate(4.5deg); }

  /* Layout 4: Quad Pinwheel (Baby Shoots) */
  .collage-style-4 .collage-img-1 { grid-column: 1 / 7; grid-row: 1 / 7; z-index: 1; transform: rotate(-1deg); }
  .collage-style-4 .collage-img-2 { grid-column: 6 / 12; grid-row: 2 / 8; z-index: 2; transform: rotate(2.5deg); }
  .collage-style-4 .collage-img-3 { grid-column: 2 / 8; grid-row: 6 / 12; z-index: 3; transform: rotate(2deg); }
  .collage-style-4 .collage-img-4 { grid-column: 7 / 13; grid-row: 7 / 13; z-index: 4; transform: rotate(-1.5deg); }

  /* Layout 5: Cascade Deck (Birthdays) */
  .collage-style-5 .collage-img-1 { grid-column: 4 / 11; grid-row: 2 / 10; z-index: 1; transform: rotate(1.5deg); }
  .collage-style-5 .collage-img-2 { grid-column: 1 / 5; grid-row: 1 / 6; z-index: 2; transform: rotate(-4.5deg); }
  .collage-style-5 .collage-img-3 { grid-column: 9 / 13; grid-row: 7 / 12; z-index: 3; transform: rotate(4deg); }
  .collage-style-5 .collage-img-4 { grid-column: 2 / 6; grid-row: 8 / 13; z-index: 4; transform: rotate(-3.5deg); }

  /* Layout 6: Overlapping Cross (Baby Shower) */
  .collage-style-6 .collage-img-1 { grid-column: 3 / 10; grid-row: 1 / 8; z-index: 1; transform: rotate(-2deg); }
  .collage-style-6 .collage-img-2 { grid-column: 1 / 5; grid-row: 6 / 12; z-index: 2; transform: rotate(3.5deg); }
  .collage-style-6 .collage-img-3 { grid-column: 8 / 12; grid-row: 5 / 11; z-index: 3; transform: rotate(-4deg); }
  .collage-style-6 .collage-img-4 { grid-column: 4 / 9; grid-row: 7 / 13; z-index: 4; transform: rotate(1.5deg); }

  /* Layout 7: Vertical Split + Central Overlap (Maternity) */
  .collage-style-7 .collage-img-1 { grid-column: 1 / 7; grid-row: 2 / 12; z-index: 1; transform: rotate(-1.5deg); }
  .collage-style-7 .collage-img-2 { grid-column: 7 / 13; grid-row: 1 / 7; z-index: 2; transform: rotate(2deg); }
  .collage-style-7 .collage-img-3 { grid-column: 7 / 13; grid-row: 7 / 13; z-index: 3; transform: rotate(-2.5deg); }
  .collage-style-7 .collage-img-4 { grid-column: 5 / 9; grid-row: 5 / 9; z-index: 5; transform: rotate(4deg); }

  /* Reversed layout placements for desktop */
  .row-reverse .collage-style-1 .collage-img-1 { grid-column: 6 / 13; grid-row: 1 / 9; transform: rotate(1.5deg); }
  .row-reverse .collage-style-1 .collage-img-2 { grid-column: 1 / 7; grid-row: 2 / 8; transform: rotate(-2deg); }
  .row-reverse .collage-style-1 .collage-img-3 { grid-column: 7 / 12; grid-row: 8 / 13; transform: rotate(-3deg); }
  .row-reverse .collage-style-1 .collage-img-4 { grid-column: 2 / 8; grid-row: 7 / 13; transform: rotate(2.5deg); }

  .row-reverse .collage-style-2 .collage-img-1 { grid-column: 4 / 10; grid-row: 1 / 13; transform: rotate(-0.5deg); }
  .row-reverse .collage-style-2 .collage-img-2 { grid-column: 9 / 13; grid-row: 2 / 7; transform: rotate(4deg); }
  .row-reverse .collage-style-2 .collage-img-3 { grid-column: 1 / 5; grid-row: 3 / 8; transform: rotate(-3.5deg); }
  .row-reverse .collage-style-2 .collage-img-4 { grid-column: 9 / 13; grid-row: 7 / 12; transform: rotate(-3deg); }

  .row-reverse .collage-style-3 .collage-img-1 { grid-column: 8 / 13; grid-row: 5 / 13; transform: rotate(3deg); }
  .row-reverse .collage-style-3 .collage-img-2 { grid-column: 5 / 10; grid-row: 1 / 9; transform: rotate(-2.5deg); }
  .row-reverse .collage-style-3 .collage-img-3 { grid-column: 2 / 7; grid-row: 6 / 13; transform: rotate(4deg); }
  .row-reverse .collage-style-3 .collage-img-4 { grid-column: 1 / 5; grid-row: 2 / 7; transform: rotate(-4.5deg); }

  .row-reverse .collage-style-4 .collage-img-1 { grid-column: 7 / 13; grid-row: 1 / 7; transform: rotate(1deg); }
  .row-reverse .collage-style-4 .collage-img-2 { grid-column: 2 / 8; grid-row: 2 / 8; transform: rotate(-2.5deg); }
  .row-reverse .collage-style-4 .collage-img-3 { grid-column: 6 / 12; grid-row: 6 / 12; transform: rotate(-2deg); }
  .row-reverse .collage-style-4 .collage-img-4 { grid-column: 1 / 7; grid-row: 7 / 13; transform: rotate(1.5deg); }

  .row-reverse .collage-style-5 .collage-img-1 { grid-column: 3 / 10; grid-row: 2 / 10; transform: rotate(-1.5deg); }
  .row-reverse .collage-style-5 .collage-img-2 { grid-column: 9 / 13; grid-row: 1 / 6; transform: rotate(4.5deg); }
  .row-reverse .collage-style-5 .collage-img-3 { grid-column: 1 / 5; grid-row: 7 / 12; transform: rotate(-4deg); }
  .row-reverse .collage-style-5 .collage-img-4 { grid-column: 8 / 12; grid-row: 8 / 13; transform: rotate(3.5deg); }

  .row-reverse .collage-style-6 .collage-img-1 { grid-column: 4 / 11; grid-row: 1 / 8; transform: rotate(2deg); }
  .row-reverse .collage-style-6 .collage-img-2 { grid-column: 9 / 13; grid-row: 6 / 12; transform: rotate(-3.5deg); }
  .row-reverse .collage-style-6 .collage-img-3 { grid-column: 1 / 5; grid-row: 5 / 11; transform: rotate(4deg); }
  .row-reverse .collage-style-6 .collage-img-4 { grid-column: 5 / 10; grid-row: 7 / 13; transform: rotate(-1.5deg); }

  .row-reverse .collage-style-7 .collage-img-1 { grid-column: 7 / 13; grid-row: 2 / 12; transform: rotate(1.5deg); }
  .row-reverse .collage-style-7 .collage-img-2 { grid-column: 1 / 7; grid-row: 1 / 7; transform: rotate(-2deg); }
  .row-reverse .collage-style-7 .collage-img-3 { grid-column: 1 / 7; grid-row: 7 / 13; transform: rotate(2.5deg); }
  .row-reverse .collage-style-7 .collage-img-4 { grid-column: 5 / 9; grid-row: 5 / 9; transform: rotate(-4deg); }

  /* Full responsive fallback rules for small viewports */
  @media (max-width: 991.98px) {
    .service-collage {
      aspect-ratio: auto;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      padding: 10px 0;
    }
    .collage-item {
      width: calc(50% - 5px);
      height: 160px;
      grid-column: auto !important;
      grid-row: auto !important;
      transform: none !important;
      border-width: 3px;
    }
    .collage-item::before, .collage-item::after {
      display: none !important;
    }
    .collage-item:hover {
      transform: translateY(-3px) !important;
    }
  }

  @media (max-width: 575.98px) {
    .collage-item {
      height: 120px;
    }
  }
</style>

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
        
        // Define collage images for each service folder
        $collage_images = [];
        if ($service['slug'] === 'weddings') {
            $collage_images = [
                BASE_URL . '/assets/images/images/wedding/img_15.jpg',
                BASE_URL . '/assets/images/images/wedding/img_1.jpg',
                BASE_URL . '/assets/images/images/wedding/img_4.jpg',
                BASE_URL . '/assets/images/images/wedding/img_8.jpg'
            ];
        } elseif ($service['slug'] === 'reception') {
            $collage_images = [
                BASE_URL . '/assets/images/images/Reception/reception_1.jpg',
                BASE_URL . '/assets/images/images/Reception/reception_3.jpg',
                BASE_URL . '/assets/images/images/Reception/reception_5.jpg',
                BASE_URL . '/assets/images/images/Reception/reception_7.jpg'
            ];
        } elseif ($service['slug'] === 'pre-wedding') {
            $collage_images = [
                BASE_URL . '/assets/images/images/pre_wedding/pre_wedding_1.jpg',
                BASE_URL . '/assets/images/images/pre_wedding/pre_wedding_3.jpg',
                BASE_URL . '/assets/images/images/pre_wedding/pre_wedding_5.jpg',
                BASE_URL . '/assets/images/images/pre_wedding/pre_wedding_7.jpg'
            ];
        } elseif ($service['slug'] === 'baby-shoots') {
            $collage_images = [
                BASE_URL . '/assets/images/images/baby_shoots/img_5.jpg',
                BASE_URL . '/assets/images/images/baby_shoots/img_2.jpg',
                BASE_URL . '/assets/images/images/baby_shoots/img_6.jpg',
                BASE_URL . '/assets/images/images/baby_shoots/img_10.jpg'
            ];
        } elseif ($service['slug'] === 'maternity') {
            $collage_images = [
                BASE_URL . '/assets/images/images/maternity/maternity_3.jpg',
                BASE_URL . '/assets/images/images/maternity/maternity_1.jpg',
                BASE_URL . '/assets/images/images/maternity/maternity_5.jpg',
                BASE_URL . '/assets/images/images/maternity/maternity_7.jpg'
            ];
        } elseif ($service['slug'] === 'birthdays') {
            $collage_images = [
                BASE_URL . '/assets/images/images/baby_shoots/img_3.jpg',
                BASE_URL . '/assets/images/images/baby_shoots/img_1.jpg',
                BASE_URL . '/assets/images/images/baby_shoots/img_4.jpg',
                BASE_URL . '/assets/images/images/baby_shoots/img_8.jpg'
            ];
        } elseif ($service['slug'] === 'baby-shower') {
            $collage_images = [
                BASE_URL . '/assets/images/images/baby_shower/baby_shower_5.jpg',
                BASE_URL . '/assets/images/images/baby_shower/baby_shower_1.jpg',
                BASE_URL . '/assets/images/images/baby_shower/baby_shower_7.jpg',
                BASE_URL . '/assets/images/images/baby_shower/baby_shower_8.jpg'
            ];
        } else {
            // Fallback to defaults
            $collage_images = [
                BASE_URL . '/style/images/art/bg16.jpg',
                BASE_URL . '/style/images/art/bg16.jpg',
                BASE_URL . '/style/images/art/bg16.jpg',
                BASE_URL . '/style/images/art/bg16.jpg'
            ];
        }

        // Determine unique collage style layout based on index (1 to 7)
        $style_num = ($idx % 7) + 1;
        $collage_class = 'collage-style-' . $style_num;
    ?>
    <div class="wrapper <?php echo $bg_class; ?> service-section-wrap">
      <div class="container inner">
        <div class="row d-flex align-items-center <?php echo $is_even ? '' : 'row-reverse flex-row-reverse'; ?>">
          <!-- Text Column -->
          <div class="col-lg-5 pr-35 pr-sm-15" style="position: relative; z-index: 2;">
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
          <!-- Collage Column -->
          <div class="col-lg-7">
            <div class="service-collage <?php echo $collage_class; ?>">
              <div class="collage-item collage-img-1">
                <img src="<?php echo $collage_images[0]; ?>" alt="<?php echo sanitize($service['service_name']); ?> 1" loading="lazy" />
              </div>
              <div class="collage-item collage-img-2">
                <img src="<?php echo $collage_images[1]; ?>" alt="<?php echo sanitize($service['service_name']); ?> 2" loading="lazy" />
              </div>
              <div class="collage-item collage-img-3">
                <img src="<?php echo $collage_images[2]; ?>" alt="<?php echo sanitize($service['service_name']); ?> 3" loading="lazy" />
              </div>
              <div class="collage-item collage-img-4">
                <img src="<?php echo $collage_images[3]; ?>" alt="<?php echo sanitize($service['service_name']); ?> 4" loading="lazy" />
              </div>
            </div>
          </div>
          <!--/column -->
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
