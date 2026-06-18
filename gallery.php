<?php
/**
 * AstraClicks - Gallery Page
 * Based on gallery5.html (Lightbox - Three Column Grid)
 */
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/helpers/functions.php';

$page_type = 'inner';
$page_title = 'Gallery | AstraClicks Photography';
$meta_description = 'Browse our photography gallery featuring stunning wedding, pre-wedding, baby, birthday, and maternity photography by AstraClicks.';
$canonical_url = BASE_URL . '/gallery';

$categories = get_gallery_categories($pdo);
$gallery_images = get_gallery($pdo, 1, 50);

include 'includes/header.php';
?>
<style>
  /* Responsive Masonry Sizing for Cube Portfolio */
  #cube-grid-mosaic {
    width: 100% !important;
  }
  #cube-grid-mosaic .cbp-item {
    width: 50% !important; /* 2 columns on mobile by default */
    padding: 4px !important; /* smaller padding for mobile */
    box-sizing: border-box !important;
  }
  #cube-grid-mosaic .cbp-item.size-short {
    height: 120px !important; /* mobile heights */
  }
  #cube-grid-mosaic .cbp-item.size-medium {
    height: 170px !important;
  }
  #cube-grid-mosaic .cbp-item.size-tall {
    height: 240px !important;
  }

  /* Mobile Landscape & Small Tablets (cols: 2 with slightly more height) */
  @media (min-width: 576px) {
    #cube-grid-mosaic .cbp-item {
      width: 50% !important;
      padding: 6px !important;
    }
    #cube-grid-mosaic .cbp-item.size-short {
      height: 180px !important;
    }
    #cube-grid-mosaic .cbp-item.size-medium {
      height: 240px !important;
    }
    #cube-grid-mosaic .cbp-item.size-tall {
      height: 340px !important;
    }
  }

  /* Tablet & Desktop (3 Columns) */
  @media (min-width: 768px) {
    #cube-grid-mosaic .cbp-item {
      width: 33.333% !important;
      padding: 8px !important;
    }
    #cube-grid-mosaic .cbp-item.size-short {
      height: 200px !important;
    }
    #cube-grid-mosaic .cbp-item.size-medium {
      height: 280px !important;
    }
    #cube-grid-mosaic .cbp-item.size-tall {
      height: 420px !important;
    }
  }

  /* Keyframes for the impressive spin and entry animation */
  @keyframes rotateInPlace {
    0% {
      opacity: 0;
      transform: scale(0.6) rotate(-25deg);
    }
    100% {
      opacity: 1;
      transform: scale(1) rotate(0deg);
    }
  }

  /* Apply staggered delay keyframe animation to the figures inside loaded cbp-items */
  #cube-grid-mosaic.cbp-ready .cbp-item figure {
    animation: rotateInPlace 1.0s cubic-bezier(0.19, 1, 0.22, 1) both;
  }

  /* Cascading delays for up to 30 items */
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(1) figure { animation-delay: 0.05s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(2) figure { animation-delay: 0.1s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(3) figure { animation-delay: 0.15s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(4) figure { animation-delay: 0.2s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(5) figure { animation-delay: 0.25s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(6) figure { animation-delay: 0.3s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(7) figure { animation-delay: 0.35s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(8) figure { animation-delay: 0.4s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(9) figure { animation-delay: 0.45s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(10) figure { animation-delay: 0.5s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(11) figure { animation-delay: 0.55s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(12) figure { animation-delay: 0.6s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(13) figure { animation-delay: 0.65s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(14) figure { animation-delay: 0.7s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(15) figure { animation-delay: 0.75s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(16) figure { animation-delay: 0.8s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(17) figure { animation-delay: 0.85s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(18) figure { animation-delay: 0.9s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(19) figure { animation-delay: 0.95s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(20) figure { animation-delay: 1.0s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(21) figure { animation-delay: 1.05s; }
  #cube-grid-mosaic.cbp-ready .cbp-item:nth-child(n+22) figure { animation-delay: 1.1s; }

  /* Cover fit images inside custom sizes */
  #cube-grid-mosaic .cbp-item figure {
    width: 100% !important;
    height: 100% !important;
    margin: 0 !important;
    overflow: hidden !important;
    opacity: 0; /* Starts hidden and animates in */
    transition: box-shadow 0.4s ease, transform 0.4s ease !important;
  }
  #cube-grid-mosaic .cbp-item figure a {
    display: block !important;
    width: 100% !important;
    height: 100% !important;
  }
  #cube-grid-mosaic .cbp-item img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
  }
  #cube-grid-mosaic .cbp-item:hover figure {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.22) !important;
    transform: translateY(-2px) !important;
  }
  #cube-grid-mosaic .cbp-item:hover img {
    transform: scale(1.08) rotate(1deg) !important;
  }
</style>
    <div class="wrapper light-wrapper">
      <div class="container inner inner-page-padding">
        <h1 class="heading text-center">Our Gallery</h1>
        <h2 class="sub-heading2 text-center">Photography & Videography</h2>
        <div class="space50"></div>
        <?php if (!empty($categories)): ?>
        <div id="cube-grid-mosaic-filter" class="cbp-filter-container text-center">
          <div data-filter="*" class="cbp-filter-item-active cbp-filter-item">All</div>
          <?php foreach ($categories as $cat): ?>
          <div data-filter=".<?php echo generate_slug($cat); ?>" class="cbp-filter-item"><?php echo sanitize($cat); ?></div>
          <?php endforeach; ?>
        </div>
        <div class="clearfix"></div>
        <div class="space20"></div>
        <?php endif; ?>
        <?php if (!empty($gallery_images)): ?>
        <div id="cube-grid-mosaic" class="cbp light-gallery">
          <?php 
          $size_classes = ['size-medium', 'size-tall', 'size-short', 'size-medium', 'size-tall', 'size-short', 'size-medium', 'size-tall', 'size-short'];
          foreach ($gallery_images as $idx => $img): 
            $size_class = $size_classes[$idx % count($size_classes)];
          ?>
          <div class="cbp-item <?php echo $img['category'] ? generate_slug($img['category']) : ''; ?> <?php echo $size_class; ?>">
            <figure class="overlay overlay3 rounded"><a href="<?php echo upload_url('gallery', $img['image']); ?>"><img src="<?php echo upload_url('gallery', $img['image']); ?>" alt="<?php echo sanitize($img['alt_tag'] ?? $img['image_title']); ?>" loading="lazy" /></a></figure>
          </div>
          <!--/.cbp-item -->
          <?php endforeach; ?>
        </div>
        <!--/.cbp -->
        <?php else: ?>
        <div class="text-center">
          <h4>Gallery coming soon!</h4>
          <p>We're curating our best shots for you. Check back soon!</p>
          <div class="space20"></div>
          <!-- Show placeholder gallery with template images -->
          <div id="cube-grid-mosaic" class="cbp light-gallery">
            <div class="cbp-item size-medium"><figure class="overlay overlay3 rounded"><a href="<?php echo ASSETS_URL; ?>/images/art/jp1-full.jpg"><img src="<?php echo ASSETS_URL; ?>/images/art/jp1.jpg" alt="" /></a></figure></div>
            <div class="cbp-item size-tall"><figure class="overlay overlay3 rounded"><a href="<?php echo ASSETS_URL; ?>/images/art/jp2-full.jpg"><img src="<?php echo ASSETS_URL; ?>/images/art/jp2.jpg" alt="" /></a></figure></div>
            <div class="cbp-item size-short"><figure class="overlay overlay3 rounded"><a href="<?php echo ASSETS_URL; ?>/images/art/jp3-full.jpg"><img src="<?php echo ASSETS_URL; ?>/images/art/jp3.jpg" alt="" /></a></figure></div>
            <div class="cbp-item size-medium"><figure class="overlay overlay3 rounded"><a href="<?php echo ASSETS_URL; ?>/images/art/jp4-full.jpg"><img src="<?php echo ASSETS_URL; ?>/images/art/jp4.jpg" alt="" /></a></figure></div>
            <div class="cbp-item size-tall"><figure class="overlay overlay3 rounded"><a href="<?php echo ASSETS_URL; ?>/images/art/jp5-full.jpg"><img src="<?php echo ASSETS_URL; ?>/images/art/jp5.jpg" alt="" /></a></figure></div>
            <div class="cbp-item size-short"><figure class="overlay overlay3 rounded"><a href="<?php echo ASSETS_URL; ?>/images/art/jp6-full.jpg"><img src="<?php echo ASSETS_URL; ?>/images/art/jp6.jpg" alt="" /></a></figure></div>
            <div class="cbp-item size-medium"><figure class="overlay overlay3 rounded"><a href="<?php echo ASSETS_URL; ?>/images/art/jp7-full.jpg"><img src="<?php echo ASSETS_URL; ?>/images/art/jp7.jpg" alt="" /></a></figure></div>
            <div class="cbp-item size-tall"><figure class="overlay overlay3 rounded"><a href="<?php echo ASSETS_URL; ?>/images/art/jp8-full.jpg"><img src="<?php echo ASSETS_URL; ?>/images/art/jp8.jpg" alt="" /></a></figure></div>
            <div class="cbp-item size-short"><figure class="overlay overlay3 rounded"><a href="<?php echo ASSETS_URL; ?>/images/art/jp9-full.jpg"><img src="<?php echo ASSETS_URL; ?>/images/art/jp9.jpg" alt="" /></a></figure></div>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <!-- /.container -->
    </div>
    <!-- /.wrapper -->
<?php include 'includes/footer.php'; ?>
