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
// Curate premium non-redundant gallery images (no videos) for the Featured Shots carousel
$gallery_images = [
    [
        'image' => 'pre_wedding_1.jpg',
        'image_title' => 'Pre Wedding Moment 1',
        'alt_tag' => 'Pre Wedding Shoot'
    ],
    [
        'image' => 'wedding_img_1.jpg',
        'image_title' => 'Wedding Moment 1',
        'alt_tag' => 'Wedding Photography'
    ],
    [
        'image' => 'baby_shoot_img_1.jpg',
        'image_title' => 'Baby Shoot Moment 1',
        'alt_tag' => 'Baby Shoot'
    ],
    [
        'image' => 'baby_shower_1.jpg',
        'image_title' => 'Baby Shower 1',
        'alt_tag' => 'Baby Shower Photography'
    ],
    [
        'image' => 'maternity_3.jpg',
        'image_title' => 'Maternity 3',
        'alt_tag' => 'Maternity Shoot'
    ],
    [
        'image' => 'brahmin_1.jpg',
        'image_title' => 'Brahmin Wedding 1',
        'alt_tag' => 'Brahmin Wedding'
    ],
    [
        'image' => 'christian_1.jpg',
        'image_title' => 'Christian Wedding 1',
        'alt_tag' => 'Christian Wedding'
    ],
    [
        'image' => 'SaveClip.App_545409564_17998772714816562_5183963157245046212_n.jpg',
        'image_title' => 'Couple Shooting 1',
        'alt_tag' => 'Couple Shoot'
    ],
    [
        'image' => 'reception_3.jpg',
        'image_title' => 'Reception 3',
        'alt_tag' => 'Reception Coverage'
    ]
];
$branches = get_branches($pdo);

include 'includes/header.php';
?>

<?php
// Dynamic Photo Harvester for Homepage Loader (80 Tiles)
$gallery_dir = __DIR__ . '/assets/images/images';
$all_images = [];
if (is_dir($gallery_dir)) {
    $dir_iter = new RecursiveDirectoryIterator($gallery_dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $iter = new RecursiveIteratorIterator($dir_iter);
    foreach ($iter as $fileinfo) {
        if ($fileinfo->isFile() && preg_match('/\.(jpg|jpeg|png|webp)$/i', $fileinfo->getFilename())) {
            $path = $fileinfo->getPathname();
            $path = str_replace('\\', '/', $path);
            if (preg_match('/assets\/images\/images\/.+/i', $path, $matches)) {
                $all_images[] = BASE_URL . '/' . $matches[0];
            }
        }
    }
}

if (empty($all_images)) {
    $all_images = [
        BASE_URL . '/assets/images/images/wedding/img_6.jpg',
        BASE_URL . '/assets/images/images/Reception/reception_1.jpg',
        BASE_URL . '/assets/images/images/pre_wedding/pre_wedding_1.jpg',
        BASE_URL . '/assets/images/images/baby_shoots/img_5.jpg',
    ];
}

// Pick a gorgeous wedding photo specifically for the special polaroid flyer
$flyer_img = BASE_URL . '/assets/images/images/wedding/img_6.jpg';
foreach ($all_images as $img) {
    if (stripos($img, 'wedding') !== false && stripos($img, 'pre_wedding') === false) {
        $flyer_img = $img;
        break;
    }
}

shuffle($all_images);

$grid_images = [];
$total_needed = 80;
$img_count = count($all_images);
for ($i = 0; $i < $total_needed; $i++) {
    $grid_images[] = $all_images[$i % $img_count];
}
?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Reenie+Beanie&display=swap');

  /* ======================================================= */
  /* HOME PAGE GRID REVEAL LOADER (80 TILES)                  */
  /* ======================================================= */
  .home-loader-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: #0d0d0d;
    z-index: 999999;
    overflow: hidden;
    transition: opacity 0.5s ease, visibility 0.5s ease;
  }
  .home-loader-overlay.done {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
  }

  .home-loader-scene {
    position: relative;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
  }

  /* --- Grid layout (absolute positioned tiles for custom split animation) --- */
  .home-tile {
    position: absolute;
    width: 10.1vw; /* slightly wider to prevent pixel gaps */
    height: 12.6vh; /* slightly taller to prevent pixel gaps */
    overflow: hidden;
    opacity: 0;
    z-index: 10;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    will-change: transform, opacity;
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.3s ease;
  }
  
  /* Initial offscreen directions (using translate3d for GPU layer promotion) */
  .home-tile.entry-top {
    transform: translate3d(0, -105vh, 0) scale(0.6);
    opacity: 0;
  }
  .home-tile.entry-bottom {
    transform: translate3d(0, 105vh, 0) scale(0.6);
    opacity: 0;
  }
  .home-tile.entry-left {
    transform: translate3d(-105vw, 0, 0) scale(0.6);
    opacity: 0;
  }
  .home-tile.entry-right {
    transform: translate3d(105vw, 0, 0) scale(0.6);
    opacity: 0;
  }

  .home-tile::after {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.15); /* subtle dark overlay on images */
    transition: background 0.2s ease;
  }
  .home-tile img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  /* --- Locked / Aligned State --- */
  .home-tile.aligned {
    opacity: 1;
    transform: translate3d(0, 0, 0) scale(1);
  }

  /* --- Live Drifting Grid Animations (using simple 3D translates, no scale redraws) --- */
  .home-tile.aligned.drift-A {
    animation: driftA 4.5s ease-in-out infinite alternate;
  }
  .home-tile.aligned.drift-B {
    animation: driftB 4.5s ease-in-out infinite alternate;
  }
  .home-tile.aligned.drift-C {
    animation: driftC 4.5s ease-in-out infinite alternate;
  }
  .home-tile.aligned.drift-D {
    animation: driftD 4.5s ease-in-out infinite alternate;
  }

  @keyframes driftA {
    0% { transform: translate3d(0, 0, 0); }
    100% { transform: translate3d(-12px, -10px, 0); }
  }
  @keyframes driftB {
    0% { transform: translate3d(0, 0, 0); }
    100% { transform: translate3d(12px, 10px, 0); }
  }
  @keyframes driftC {
    0% { transform: translate3d(0, 0, 0); }
    100% { transform: translate3d(12px, -10px, 0); }
  }
  @keyframes driftD {
    0% { transform: translate3d(0, 0, 0); }
    100% { transform: translate3d(-12px, 10px, 0); }
  }

  /* --- Splitting Animation CSS classes (using translate3d for hardware acceleration) --- */
  .home-tile.slide-up {
    transform: translate3d(0, -100%, 0) scale(1);
    opacity: 0;
    transition: transform 0.5s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.3s ease 0.2s;
  }
  .home-tile.slide-down {
    transform: translate3d(0, 100%, 0) scale(1);
    opacity: 0;
    transition: transform 0.5s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.3s ease 0.2s;
  }
  .home-tile.slide-left {
    transform: translate3d(-100%, 0, 0) scale(1);
    opacity: 0;
    transition: transform 0.5s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.3s ease 0.2s;
  }
  .home-tile.slide-right {
    transform: translate3d(100%, 0, 0) scale(1);
    opacity: 0;
    transition: transform 0.5s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.3s ease 0.2s;
  }

  /* --- Special signature flyer card with 3D Flip capability --- */
  .home-special-flyer {
    position: absolute;
    left: 0;
    bottom: 0;
    width: 280px;
    height: 350px;
    z-index: 100; /* stays on top of grid tiles */
    pointer-events: none;
    opacity: 0;
    perspective: 1000px; /* 3D depth perspective */
    transform: translate(-35vw, 35vh) scale(0.4) rotate(-15deg);
    will-change: transform, opacity;
  }

  .flyer-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transform-style: preserve-3d;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
  }

  .flyer-front, .flyer-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    background: #ffffff;
    padding: 15px 15px 45px 15px; /* polaroid style frame spacing */
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 4px;
  }

  .flyer-front img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    border-radius: 2px;
  }

  .flyer-front .flyer-label {
    position: absolute;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    font-family: 'Reenie Beanie', cursive, sans-serif;
    font-size: 26px;
    color: #222222;
    font-weight: 500;
    letter-spacing: 1px;
    white-space: nowrap;
  }

  /* Back side of Polaroid card */
  .flyer-back {
    transform: rotateY(180deg);
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff; /* pure classic polaroid card color */
    text-align: center;
  }

  .flyer-back-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .flyer-back-content h2 {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    font-weight: 700;
    color: #111111;
    margin: 0;
    letter-spacing: 2px;
    text-transform: uppercase;
  }

  .flyer-back-content p {
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    font-weight: 500;
    color: #b05735;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-top: 8px;
    margin-bottom: 0;
  }

  .home-special-flyer.active {
    animation: flyerMove 2.5s linear forwards;
  }

  /* Active flip animation trigger synchronized with travel */
  .home-special-flyer.active .flyer-inner {
    animation: flyerFlip 2.5s linear forwards;
  }

  @keyframes flyerMove {
    0% {
      transform: translate(-30vw, 30vh) scale(0.4) rotate(-15deg);
      opacity: 0;
      animation-timing-function: cubic-bezier(0.15, 0.85, 0.35, 1);
    }
    8% {
      opacity: 1; /* fade in complete, no transform anchor to avoid jerking */
    }
    25% {
      transform: translate(15vw, -15vh) scale(0.9) rotate(-6deg);
      animation-timing-function: cubic-bezier(0.35, 0.45, 0.65, 0.55);
    }
    75% {
      transform: translate(45vw, -45vh) scale(1.1) rotate(6deg);
      animation-timing-function: cubic-bezier(0.65, 0.05, 0.85, 0.1);
    }
    92% {
      opacity: 1; /* fade out starts */
    }
    100% {
      transform: translate(115vw, -115vh) scale(0.5) rotate(16deg);
      opacity: 0;
    }
  }

  @keyframes flyerFlip {
    0% {
      transform: rotateY(0deg);
    }
    35% {
      /* Mid-flight: start the flip slowly */
      transform: rotateY(0deg);
      animation-timing-function: cubic-bezier(0.25, 1, 0.5, 1);
    }
    60% {
      /* Complete the flip by 60% */
      transform: rotateY(180deg);
    }
    100% {
      /* Keep showing back-face showing AstraClicks logo till exit */
      transform: rotateY(180deg);
    }
  }

  /* --- Title coming from behind --- */
  .home-loader-title {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%) scale(0.6);
    z-index: 1;
    text-align: center;
    pointer-events: none;
    opacity: 0;
    width: 100%;
    transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.4s ease;
  }
  .home-loader-title.show {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
  }
  .loader-logo-img {
    max-width: 500px;
    width: 80vw;
    height: auto;
    display: block;
    margin: 0 auto;
    filter: drop-shadow(0 10px 30px rgba(255,255,255,0.25));
  }

  @media (max-width: 991.98px) {
    .home-tile {
      width: 10.2vw;
      height: 12.7vh;
    }
    .home-special-flyer {
      width: 200px;
      height: 250px;
    }
    .flyer-back-content h2 {
      font-size: 24px;
    }
    .loader-logo-img {
      max-width: 320px;
    }
  }
  @media (max-width: 575.98px) {
    .home-special-flyer {
      width: 150px;
      height: 188px;
    }
    .flyer-back-content h2 {
      font-size: 18px;
    }
    .loader-logo-img {
      max-width: 240px;
    }
  }
</style>

<div id="home-page-loader" class="home-loader-overlay">
  <div class="home-loader-scene">
    <?php for ($ti = 0; $ti < 80; $ti++): ?>
    <div class="home-tile" id="ht<?php echo $ti; ?>"><img src="<?php echo $grid_images[$ti]; ?>" alt="" loading="eager" /></div>
    <?php endfor; ?>

    <!-- Signature Corner-to-Corner Flyer Polaroid with 3D Flip -->
    <div class="home-special-flyer" id="homeSpecialFlyer">
      <div class="flyer-inner">
        <!-- Front side: Photo -->
        <div class="flyer-front">
          <img src="<?php echo $flyer_img; ?>" alt="Special Moment" />
          <div class="flyer-label">AstraClicks &hearts;</div>
        </div>
        <!-- Back side: AstraClicks Branding -->
        <div class="flyer-back">
          <div class="flyer-back-content">
            <h2>AstraClicks</h2>
            <p>Studio</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Logo revealed from behind -->
    <div class="home-loader-title" id="homeLoaderTitle">
      <img src="<?php echo BASE_URL; ?>/assets/images/icons/logo.png" alt="AstraClicks" class="loader-logo-img" />
    </div>
  </div>
</div>

<script>
(function() {
  var TILE_COUNT = 80;
  var COLUMNS = 10;
  var ROWS = 8;

  function runHomeLoader(ov) {
    var tiles = [];
    for (var i = 0; i < TILE_COUNT; i++) {
      var el = ov.querySelector('#ht' + i);
      if (el) {
        var r = Math.floor(i / COLUMNS);
        var c = i % COLUMNS;
        var topVal = r * 12.5;
        var leftVal = c * 10;
        
        el.style.top = topVal + 'vh';
        el.style.left = leftVal + 'vw';
        
        // Assign directional entry direction based on index
        var dirClass = '';
        if (i % 4 === 0) dirClass = 'entry-top';
        else if (i % 4 === 1) dirClass = 'entry-bottom';
        else if (i % 4 === 2) dirClass = 'entry-left';
        else dirClass = 'entry-right';
        
        el.className = 'home-tile ' + dirClass;
        tiles.push(el);
      }
    }

    var title = ov.querySelector('#homeLoaderTitle');
    if (title) {
      title.className = 'home-loader-title';
    }

    // Trigger signature flyer
    var flyer = ov.querySelector('#homeSpecialFlyer');
    if (flyer) {
      flyer.classList.remove('active');
      void flyer.offsetWidth; // Force reflow
      flyer.classList.add('active');
    }

    // Step 1: Staggered Aligning
    // Ultra-fast 6ms stagger delay
    tiles.forEach(function(el, idx) {
      setTimeout(function() {
        el.classList.remove('entry-top', 'entry-bottom', 'entry-left', 'entry-right');
        el.classList.add('aligned');
        
        // Add dynamic drift class based on index modulo 4
        var driftClass = '';
        if (idx % 4 === 0) driftClass = 'drift-A';
        else if (idx % 4 === 1) driftClass = 'drift-B';
        else if (idx % 4 === 2) driftClass = 'drift-C';
        else driftClass = 'drift-D';
        
        el.classList.add(driftClass);
      }, idx * 6);
    });

    // Step 2: Split apart and reveal title
    // Wait until the flyer exits the viewport (2.4s)
    setTimeout(function() {
      tiles.forEach(function(el, idx) {
        var r = Math.floor(idx / COLUMNS);
        var c = idx % COLUMNS;
        
        // Remove the drift classes so the slide transitions take over
        el.classList.remove('drift-A', 'drift-B', 'drift-C', 'drift-D');
        
        if (r <= 2) {
          // Upper 3 rows slide UP
          el.classList.add('slide-up');
        } else if (r >= 5) {
          // Lower 3 rows slide DOWN
          el.classList.add('slide-down');
        } else {
          // Middle 2 rows split Left / Right
          if (c <= 4) {
            el.classList.add('slide-left');
          } else {
            el.classList.add('slide-right');
          }
        }
      });

      // Reveal title from behind
      if (title) {
        title.classList.add('show');
      }
    }, 2400);

    // Step 3: Fade out overlay and reveal page
    setTimeout(function() {
      ov.classList.add('done');
      setTimeout(function() {
        ov.style.display = 'none';
      }, 500);
    }, 3300);
  }

  document.addEventListener("DOMContentLoaded", function() {
    var ov = document.getElementById("home-page-loader");
    if (!ov) return;
    runHomeLoader(ov);

    // Re-trigger on Home navigation clicks
    var homeLinks = document.querySelectorAll('a');
    homeLinks.forEach(function(link) {
      var href = link.getAttribute('href');
      if (href === '<?php echo BASE_URL; ?>' || href === '<?php echo BASE_URL; ?>/' || href === './' || href === 'index.php') {
        link.addEventListener("click", function(e) {
          var path = window.location.pathname;
          var basePath = '<?php echo parse_url(BASE_URL, PHP_URL_PATH); ?>';
          if (path.endsWith("index.php") || path === basePath || path === basePath + '/') {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: "smooth" });
            
            var fresh = ov.cloneNode(true);
            ov.parentNode.replaceChild(fresh, ov);
            ov = fresh;
            ov.style.display = "block";
            ov.style.opacity = "1";
            ov.style.visibility = "visible";
            ov.classList.remove("done");
            
            runHomeLoader(ov);
          }
        });
      }
    });
  });
})();
</script>
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
            <div class="item mr-15"><img src="assets/images/images/pre_wedding/pre_wedding_1.jpg" alt="Pre Wedding Shoot" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/wedding/img_4.jpg" alt="Wedding Photography" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/baby_shoots/img_2.jpg" alt="Baby Shoot" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/baby_shower/baby_shower_5.jpg" alt="Baby Shower Photography" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/maternity/maternity_3.jpg" alt="Maternity Shoot" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/Reception/reception_1.jpg" alt="Reception Coverage" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/brahmin_wedding/brahmin_1.jpg" alt="Brahmin Wedding" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/christian_wedding/christian_1.jpg" alt="Christian Wedding" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/wedding/img_10.jpg" alt="Wedding Shoot" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/pre_wedding/pre_wedding_3.jpg" alt="Pre Wedding Portrait" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/wedding/img_8.jpg" alt="Wedding Portrait" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/baby_shoots/img_6.jpg" alt="Baby Shoot Portrait" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/baby_shower/baby_shower_7.jpg" alt="Baby Shower Portrait" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/maternity/maternity_5.jpg" alt="Maternity Portrait" loading="lazy" /></div>
            <div class="item mr-15"><img src="assets/images/images/Reception/reception_3.jpg" alt="Reception Moment" loading="lazy" /></div>
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
              $object_position = 'center';
              if ($svc['slug'] === 'weddings') {
                  $img = BASE_URL . '/assets/images/images/wedding/img_15.jpg';
                  $object_position = 'center 35%';
              } elseif ($svc['slug'] === 'reception') {
                  $img = BASE_URL . '/assets/images/images/wedding/img_16.jpg';
                  $object_position = 'center 55%';
              } elseif ($svc['slug'] === 'pre-wedding') {
                  $img = BASE_URL . '/assets/images/images/wedding/img_7.jpg';
                  $object_position = 'center bottom';
              } else {
                  $img = $svc['banner_image'] ? upload_url('services', $svc['banner_image']) : ($service_images[$idx] ?? $service_images[0]);
              }
            ?>
            <div class="item col-md-4">
              <div class="box bg-pastel-default p-30">
                <figure class="main mb-20" style="border-radius: 8px; overflow: hidden;"><a href="<?php echo BASE_URL; ?>/services/<?php echo $svc['slug']; ?>"><img src="<?php echo $img; ?>" alt="<?php echo sanitize($svc['service_name']); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; object-position: <?php echo $object_position; ?>;" loading="lazy" /></a></figure>
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
