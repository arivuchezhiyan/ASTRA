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
$gallery_images = get_gallery($pdo, 1, 150);

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
  #cube-grid-mosaic .cbp-item figure a,
  #cube-grid-mosaic .cbp-item figure .video-trigger {
    display: block !important;
    width: 100% !important;
    height: 100% !important;
  }
  #cube-grid-mosaic .cbp-item img,
  #cube-grid-mosaic .cbp-item video {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
  }
  #cube-grid-mosaic .cbp-item:hover figure {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.22) !important;
    transform: translateY(-2px) !important;
  }
  #cube-grid-mosaic .cbp-item:hover img,
  #cube-grid-mosaic .cbp-item:hover video {
    transform: scale(1.08) rotate(1deg) !important;
  }

  /* Glassy Filter Buttons */
  #cube-grid-mosaic-filter {
    display: flex !important;
    flex-wrap: wrap !important;
    justify-content: center !important;
    gap: 12px !important;
    margin-bottom: 35px !important;
    border: none !important;
  }
  #cube-grid-mosaic-filter .cbp-filter-item {
    background: rgba(255, 255, 255, 0.65) !important;
    backdrop-filter: blur(10px) !important;
    -webkit-backdrop-filter: blur(10px) !important;
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
    color: #4b5563 !important;
    padding: 8px 22px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.8px !important;
    border-radius: 50px !important;
    cursor: pointer !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    margin: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
  }
  #cube-grid-mosaic-filter .cbp-filter-item:hover {
    background: rgba(255, 255, 255, 0.95) !important;
    border-color: rgba(219, 129, 89, 0.4) !important;
    color: #db8159 !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 18px rgba(219, 129, 89, 0.1) !important;
  }
  #cube-grid-mosaic-filter .cbp-filter-item-active,
  #cube-grid-mosaic-filter .cbp-filter-item-active:hover {
    background: #db8159 !important;
    border-color: #db8159 !important;
    color: #fff !important;
    box-shadow: 0 8px 20px rgba(219, 129, 89, 0.35) !important;
    transform: translateY(-2px) !important;
  }
  #cube-grid-mosaic-filter .cbp-filter-item::after,
  #cube-grid-mosaic-filter .cbp-filter-item::before {
    display: none !important;
    content: none !important;
  }

  @media (max-width: 767px) {
    #cube-grid-mosaic-filter {
      gap: 8px !important;
      margin-bottom: 25px !important;
    }
    #cube-grid-mosaic-filter .cbp-filter-item {
      padding: 6px 14px !important;
      font-size: 11px !important;
    }
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
          <div data-filter=".image-item" class="cbp-filter-item">Images</div>
          <div data-filter=".video-item" class="cbp-filter-item">Videos</div>
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
            $ext = strtolower(pathinfo($img['image'], PATHINFO_EXTENSION));
            $is_video = in_array($ext, ['mp4', 'webm', 'ogg', 'mov']);
            $media_class = $is_video ? 'video-item' : 'image-item';
            $category_class = $img['category'] ? generate_slug($img['category']) : '';
          ?>
          <div class="cbp-item <?php echo $category_class; ?> <?php echo $media_class; ?> <?php echo $size_class; ?>">
            <figure class="overlay <?php echo $is_video ? '' : 'overlay3'; ?> rounded" style="position: relative; width: 100%; height: 100%; margin: 0; overflow: hidden;">
              <?php if ($is_video): ?>
                <div class="video-trigger" style="cursor: pointer;" data-src="<?php echo upload_url('gallery', $img['image']); ?>">
                  <video src="<?php echo upload_url('gallery', $img['image']); ?>" style="width: 100%; height: 100%; object-fit: cover;" muted playsinline loop></video>
                  <div class="video-play-indicator" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; font-size: 2.2rem; text-shadow: 0 4px 10px rgba(0,0,0,0.55); pointer-events: none; z-index: 5;"><i class="fa fa-play-circle"></i></div>
                </div>
              <?php else: ?>
                <a href="<?php echo upload_url('gallery', $img['image']); ?>">
                  <img src="<?php echo upload_url('gallery', $img['image']); ?>" alt="<?php echo sanitize($img['alt_tag'] ?? $img['image_title']); ?>" loading="lazy" />
                </a>
              <?php endif; ?>
            </figure>
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

<!-- Premium Video Lightbox Modal -->
<div id="premium-video-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(10, 10, 10, 0.98); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); z-index: 999999; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease;">
    <div id="close-premium-modal" style="position: absolute; top: 25px; right: 30px; color: rgba(255,255,255,0.7); font-size: 40px; cursor: pointer; transition: color 0.2s, transform 0.2s; z-index: 1000000; line-height: 1;">&times;</div>
    <div style="width: 90%; max-width: 1000px; aspect-ratio: 16/9; background: #000; border-radius: 20px; overflow: hidden; box-shadow: 0 30px 70px rgba(0,0,0,0.8); border: 1px solid rgba(255,255,255,0.12); position: relative; transform: scale(0.9); transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
        <video id="premium-modal-video" style="width: 100%; height: 100%; object-fit: contain;" controls autoplay playsinline></video>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Play video on hover
    var items = document.querySelectorAll('#cube-grid-mosaic .cbp-item.video-item');
    items.forEach(function(item) {
        var video = item.querySelector('video');
        if (video) {
            item.addEventListener('mouseenter', function() {
                video.play().catch(function(e) {});
            });
            item.addEventListener('mouseleave', function() {
                video.pause();
                video.currentTime = 0;
            });
        }
    });

    // Custom video modal logic
    var videoTriggers = document.querySelectorAll('.video-trigger');
    var modal = document.getElementById('premium-video-modal');
    var video = document.getElementById('premium-modal-video');
    var closeBtn = document.getElementById('close-premium-modal');
    var innerContainer = modal.querySelector('div:last-child');

    videoTriggers.forEach(function(trigger) {
        trigger.addEventListener('click', function(e) {
            var src = trigger.getAttribute('data-src');
            if (src) {
                video.src = src;
                modal.style.display = 'flex';
                // Trigger animation
                setTimeout(function() {
                    modal.style.opacity = '1';
                    innerContainer.style.transform = 'scale(1)';
                }, 10);
            }
        });
    });

    function closeModal() {
        modal.style.opacity = '0';
        innerContainer.style.transform = 'scale(0.9)';
        setTimeout(function() {
            modal.style.display = 'none';
            video.pause();
            video.src = '';
        }, 300);
    }

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            closeModal();
        }
    });

    // Style close button hover effects
    closeBtn.addEventListener('mouseenter', function() {
        closeBtn.style.color = '#fff';
        closeBtn.style.transform = 'scale(1.1)';
    });
    closeBtn.addEventListener('mouseleave', function() {
        closeBtn.style.color = 'rgba(255,255,255,0.7)';
        closeBtn.style.transform = 'scale(1)';
    });
});
</script>
<?php include 'includes/footer.php'; ?>
