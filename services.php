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
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Reenie+Beanie&family=Montserrat:wght@300;400;500;600;700&display=swap');

  /* Subtle light leak decoration background glows */
  .service-section-wrap {
    position: relative;
    overflow: hidden;
    padding: 100px 0;
  }
  .service-section-wrap::after {
    content: "";
    position: absolute;
    top: -10%;
    left: -10%;
    width: 450px;
    height: 450px;
    background: radial-gradient(circle, rgba(186, 104, 75, 0.06) 0%, rgba(255, 255, 255, 0) 70%);
    z-index: 0;
    pointer-events: none;
  }
  .service-section-wrap:nth-child(even)::after {
    left: auto;
    right: -10%;
    background: radial-gradient(circle, rgba(138, 92, 246, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
  }

  /* ========================================== */
  /* 1. weddings: FLOATING PHOTO STACK + POLAROID */
  /* ========================================== */
  .wedding-stack {
    position: relative;
    width: 100%;
    aspect-ratio: 4/3;
    z-index: 2;
  }
  .wedding-stack .stack-card {
    position: absolute;
    background: #fff;
    padding: 12px 12px 48px 12px;
    border-radius: 2px;
    transition: transform 0.45s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.45s ease, z-index 0.1s ease;
    overflow: hidden;
    backface-visibility: hidden;
  }
  .wedding-stack .stack-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 1px solid rgba(0,0,0,0.04);
  }
  .wedding-stack .polaroid-caption {
    position: absolute;
    bottom: 10px;
    left: 12px;
    right: 12px;
    font-family: 'Reenie Beanie', cursive;
    font-size: 26px;
    color: #4a4a4a;
    text-align: center;
    line-height: 1.1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .wedding-stack .stack-card:hover {
    transform: scale(1.06) translateY(-10px) rotate(0deg) !important;
    z-index: 10 !important;
  }
  .wedding-stack .card-1 { width: 53%; height: 75%; top: 4%; left: 4%; transform: rotate(-3deg); z-index: 2; box-shadow: 0 15px 35px rgba(0,0,0,0.12), 0 5px 15px rgba(0,0,0,0.06); }
  .wedding-stack .card-2 { width: 47%; height: 61%; top: 15%; right: 4%; transform: rotate(4deg); z-index: 1; box-shadow: 0 10px 25px rgba(0,0,0,0.1), 0 3px 10px rgba(0,0,0,0.04); }
  .wedding-stack .card-3 { width: 39%; height: 49%; bottom: 4%; left: 15%; transform: rotate(2deg); z-index: 3; box-shadow: 0 20px 40px rgba(0,0,0,0.15), 0 8px 20px rgba(0,0,0,0.08); }
  .wedding-stack .card-4 { width: 41%; height: 51%; bottom: 6%; right: 17%; transform: rotate(-5deg); z-index: 4; box-shadow: 0 25px 45px rgba(0,0,0,0.16), 0 10px 22px rgba(0,0,0,0.1); }

  /* Sticky tape decoration overlays */
  .wedding-stack .stack-card::before {
    content: "";
    position: absolute;
    top: -10px;
    left: 50%;
    width: 80px;
    height: 24px;
    background: rgba(246, 245, 242, 0.55);
    backdrop-filter: blur(2px);
    border: 1px dashed rgba(0, 0, 0, 0.08);
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    z-index: 5;
    pointer-events: none;
  }
  .wedding-stack .card-1::before { transform: translateX(-50%) rotate(-12deg); }
  .wedding-stack .card-2::before { transform: translateX(-50%) rotate(7deg); }
  .wedding-stack .card-3::before { transform: translateX(-50%) rotate(14deg); }
  .wedding-stack .card-4::before { transform: translateX(-50%) rotate(-8deg); }

  /* ========================================== */
  /* 2. reception: BENTO GRID + GLASS SHADOWS */
  /* ========================================== */
  .reception-bento {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    grid-template-rows: repeat(12, 1fr);
    width: 100%;
    aspect-ratio: 4/3;
    gap: 15px;
    z-index: 2;
  }
  .reception-bento .bento-card {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(255, 255, 255, 0.45);
    box-shadow: 0 15px 35px rgba(0,0,0,0.09), inset 0 1px 1px rgba(255,255,255,0.4);
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.4s ease;
  }
  .reception-bento .bento-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
  }
  .reception-bento .bento-card:hover {
    transform: scale(1.03) translateY(-6px);
    box-shadow: 0 20px 45px rgba(0,0,0,0.18);
  }
  .reception-bento .bento-card:hover img {
    transform: scale(1.05);
  }
  .reception-bento .card-1 { grid-column: 1 / 8; grid-row: 1 / 8; }
  .reception-bento .card-2 { grid-column: 8 / 13; grid-row: 1 / 5; }
  .reception-bento .card-3 { grid-column: 1 / 6; grid-row: 8 / 13; }
  .reception-bento .card-4 { grid-column: 6 / 13; grid-row: 5 / 13; }

  /* Glassmorphism label overlay */
  .reception-bento .glass-overlay {
    position: absolute;
    bottom: 12px;
    left: 12px;
    right: 12px;
    padding: 10px;
    background: rgba(255, 255, 255, 0.22);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.35);
    border-radius: 8px;
    color: #fff;
    text-shadow: 0 1px 2px rgba(0,0,0,0.4);
    text-align: center;
    transform: translateY(15px);
    opacity: 0;
    transition: transform 0.35s ease, opacity 0.35s ease;
    z-index: 3;
  }
  .reception-bento .bento-card:hover .glass-overlay {
    transform: translateY(0);
    opacity: 1;
  }
  .reception-bento .glass-overlay h5 {
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1.5px;
    margin-bottom: 2px;
    text-transform: uppercase;
  }
  .reception-bento .glass-overlay p {
    font-family: 'Playfair Display', serif;
    font-size: 10px;
    font-style: italic;
    margin-bottom: 0;
  }

  /* Paperclip overlay */
  .reception-bento .bento-clip {
    position: absolute;
    top: -12px;
    right: 25px;
    width: 18px;
    height: 38px;
    z-index: 5;
    filter: drop-shadow(1px 2px 2px rgba(0,0,0,0.15));
    transform: rotate(15deg);
    pointer-events: none;
  }

  /* ========================================== */
  /* 3. pre-wedding: EDITORIAL MAGAZINE + FILM STRIP */
  /* ========================================== */
  .prewedding-magazine {
    position: relative;
    width: 100%;
    z-index: 2;
  }
  .prewedding-magazine .magazine-cover {
    position: relative;
    width: 100%;
    aspect-ratio: 1.4;
    border: 12px solid #fff;
    background: #fff;
    box-shadow: 0 25px 60px rgba(0,0,0,0.16);
    overflow: hidden;
    transition: transform 0.4s ease;
  }
  .prewedding-magazine .magazine-cover:hover {
    transform: translateY(-5px);
  }
  .prewedding-magazine .magazine-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .prewedding-magazine .magazine-header {
    position: absolute;
    top: 20px;
    left: 0;
    right: 0;
    text-align: center;
    color: #fff;
    z-index: 3;
    text-shadow: 0 2px 8px rgba(0,0,0,0.35);
    pointer-events: none;
  }
  .prewedding-magazine .magazine-header h4 {
    font-family: 'Playfair Display', serif;
    font-size: 34px;
    font-weight: 700;
    letter-spacing: 7px;
    margin-bottom: 0;
    text-transform: uppercase;
  }
  .prewedding-magazine .magazine-header p {
    font-family: 'Montserrat', sans-serif;
    font-size: 9px;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-top: -2px;
  }
  .prewedding-magazine .magazine-side-story {
    position: absolute;
    bottom: 25px;
    left: 20px;
    color: #fff;
    z-index: 3;
    max-width: 220px;
    text-shadow: 0 2px 6px rgba(0,0,0,0.45);
    font-family: 'Montserrat', sans-serif;
    pointer-events: none;
  }
  .prewedding-magazine .magazine-side-story h5 {
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 4px;
    text-transform: uppercase;
  }
  .prewedding-magazine .magazine-side-story p {
    font-family: 'Playfair Display', serif;
    font-size: 11px;
    font-style: italic;
    line-height: 1.3;
  }
  .prewedding-magazine .magazine-date-issue {
    position: absolute;
    bottom: 25px;
    right: 20px;
    color: rgba(255,255,255,0.85);
    z-index: 3;
    font-family: 'Montserrat', sans-serif;
    font-size: 9px;
    letter-spacing: 2px;
    text-transform: uppercase;
    text-shadow: 0 1px 4px rgba(0,0,0,0.3);
    pointer-events: none;
  }

  .prewedding-magazine .film-strip-wrap {
    position: relative;
    margin-top: 25px;
    padding: 18px 10px;
    background: #151515;
    border-radius: 4px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.25);
    overflow: hidden;
  }
  .prewedding-magazine .film-strip-sprockets {
    position: absolute;
    left: 0;
    right: 0;
    height: 8px;
    background: repeating-linear-gradient(90deg, transparent 0px, transparent 8px, #fff 8px, #fff 14px);
    z-index: 3;
    pointer-events: none;
    opacity: 0.9;
  }
  .prewedding-magazine .sprockets-top { top: 5px; }
  .prewedding-magazine .sprockets-bottom { bottom: 5px; }
  .prewedding-magazine .film-reel {
    display: flex;
    gap: 12px;
    width: max-content;
    animation: filmScroll 24s linear infinite;
  }
  .prewedding-magazine .film-card {
    width: 180px;
    height: 135px;
    flex-shrink: 0;
    border: 2px solid #000;
    overflow: hidden;
    transition: transform 0.3s ease, border-color 0.3s ease;
  }
  .prewedding-magazine .film-card:hover {
    transform: scale(1.05);
    border-color: #777;
  }
  .prewedding-magazine .film-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .prewedding-magazine .film-strip-wrap:hover .film-reel {
    animation-play-state: paused;
  }

  @keyframes filmScroll {
    0% {
      transform: translate3d(0, 0, 0);
    }
    100% {
      transform: translate3d(calc(-50% - 6px), 0, 0);
    }
  }

  /* Colored pushpins */
  .prewedding-magazine .magazine-pin {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    width: 16px;
    height: 16px;
    background: radial-gradient(circle at 35% 35%, #ff4b4b 0%, #a81c1c 90%);
    border-radius: 50%;
    box-shadow: 0 4px 6px rgba(0,0,0,0.35), inset 0 2px 2px rgba(255,255,255,0.4);
    z-index: 6;
  }
  .prewedding-magazine .magazine-pin::after {
    content: "";
    position: absolute;
    bottom: -6px;
    left: 7px;
    width: 2px;
    height: 8px;
    background: #777;
    transform: rotate(15deg);
    box-shadow: 2px 2px 3px rgba(0,0,0,0.25);
  }

  /* ========================================== */
  /* 4. baby-shoots: SCRAPBOOK + CIRCULAR CONSTELLATION */
  /* ========================================== */
  .baby-constellation {
    position: relative;
    width: 100%;
    aspect-ratio: 4/3;
    z-index: 2;
  }
  .baby-constellation .main-circle {
    position: absolute;
    width: 46%;
    height: 62%;
    top: 19%;
    left: 27%;
    border-radius: 50%;
    border: 6px solid #fff;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1), outline 1px dashed #d6c8b9;
    overflow: hidden;
    z-index: 3;
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }
  .baby-constellation .main-circle img { width: 100%; height: 100%; object-fit: cover; }
  .baby-constellation .main-circle:hover { transform: scale(1.05) rotate(-2deg); }
  .baby-constellation .sub-circle {
    position: absolute;
    border-radius: 50%;
    border: 5px solid #fff;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }
  .baby-constellation .sub-circle img { width: 100%; height: 100%; object-fit: cover; }
  .baby-constellation .sub-circle:hover { transform: scale(1.08) rotate(3deg); z-index: 4; }
  .baby-constellation .card-2 { width: 26%; height: 35%; top: 4%; left: 6%; z-index: 2; }
  .baby-constellation .card-3 { width: 24%; height: 32%; top: 12%; right: 6%; z-index: 2; }
  .baby-constellation .card-4 { width: 25%; height: 34%; bottom: 4%; right: 10%; z-index: 2; }
  
  /* Constellation svg connector lines */
  .baby-constellation svg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
  }

  /* Scrapbook style stickers */
  .baby-constellation .baby-sticker {
    position: absolute;
    font-family: 'Reenie Beanie', cursive;
    font-size: 20px;
    background: #fff6f6;
    padding: 4px 10px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    color: #f7a4a4;
    border: 1px dashed #f5c2c2;
    transform: rotate(-8deg);
    z-index: 5;
    pointer-events: none;
  }
  .baby-constellation .sticker-1 { top: 45%; left: 8%; transform: rotate(10deg); }
  .baby-constellation .sticker-2 { bottom: 15%; left: 35%; transform: rotate(-5deg); font-size: 22px; }

  /* ========================================== */
  /* 5. birthdays: DIAGONAL RIBBON COMPOSITION */
  /* ========================================== */
  .birthday-diagonal {
    position: relative;
    width: 100%;
    aspect-ratio: 4/3;
    z-index: 2;
  }
  .birthday-diagonal::before {
    content: "";
    position: absolute;
    top: 15%;
    left: 10%;
    width: 80%;
    height: 70%;
    border-top: 2px dashed rgba(186, 104, 75, 0.2);
    transform: rotate(18deg);
    z-index: 1;
    pointer-events: none;
  }
  .birthday-diagonal .postcard-card {
    position: absolute;
    background: #fdfcf7;
    padding: 10px 10px 30px 10px;
    border: 1px solid #e3dec9;
    border-radius: 4px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.08), inset 0 0 40px rgba(0,0,0,0.02);
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.4s ease;
  }
  .birthday-diagonal .postcard-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: sepia(0.08) contrast(1.02);
  }
  .birthday-diagonal .postcard-card:hover {
    transform: scale(1.06) translateY(-8px) rotate(0deg) !important;
    box-shadow: 0 20px 45px rgba(0,0,0,0.15);
    z-index: 5 !important;
  }
  .birthday-diagonal .postcard-label {
    position: absolute;
    bottom: 8px;
    left: 10px;
    right: 10px;
    font-family: 'Reenie Beanie', cursive;
    font-size: 20px;
    color: #7c7258;
    text-align: center;
  }
  .birthday-diagonal .card-1 { width: 37%; height: 47%; top: 4%; left: 4%; transform: rotate(-6deg); z-index: 2; }
  .birthday-diagonal .card-2 { width: 35%; height: 44%; top: 22%; left: 46%; transform: rotate(3deg); z-index: 3; }
  .birthday-diagonal .card-3 { width: 33%; height: 42%; bottom: 4%; right: 4%; transform: rotate(-4deg); z-index: 2; }
  .birthday-diagonal .card-4 { width: 28%; height: 35%; bottom: 6%; left: 12%; transform: rotate(6deg); z-index: 4; }

  /* Postage stamp decoration */
  .birthday-diagonal .postcard-stamp {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 32px;
    height: 40px;
    background: #fff;
    border: 1px dashed #d1c7bd;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    z-index: 4;
    pointer-events: none;
    transform: rotate(8deg);
  }
  .birthday-diagonal .postcard-stamp::after {
    content: "";
    position: absolute;
    inset: 2px;
    border: 1px solid rgba(186, 104, 75, 0.25);
    background: radial-gradient(circle, #f7dcd0 0%, transparent 80%);
  }

  /* ========================================== */
  /* 6. baby-shower: LUXURY THEATRE DISPLAY */
  /* ========================================== */
  .shower-theatre {
    position: relative;
    width: 100%;
    aspect-ratio: 4/3;
    z-index: 2;
  }
  .shower-theatre .theatre-hero-frame {
    position: absolute;
    width: 63%;
    height: 73%;
    top: 10%;
    left: 18.5%;
    background: #faf6f0;
    border: 12px solid #f2ece4;
    outline: 1px solid #bfb7ad;
    box-shadow: 0 30px 60px rgba(0,0,0,0.18), inset 0 0 15px rgba(0,0,0,0.06);
    z-index: 2;
    overflow: hidden;
    transition: transform 0.4s ease;
  }
  .shower-theatre .theatre-hero-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 1px solid #c2b9af;
  }
  .shower-theatre .theatre-hero-frame:hover {
    transform: scale(1.02);
  }
  .shower-theatre .theatre-side-panel {
    position: absolute;
    width: 30%;
    height: 42%;
    background: #faf6f0;
    border: 8px solid #f2ece4;
    outline: 1px solid #bfb7ad;
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    z-index: 1;
    overflow: hidden;
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
  }
  .shower-theatre .theatre-side-panel img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 1px solid #c2b9af;
  }
  .shower-theatre .theatre-side-panel:hover {
    transform: scale(1.06) translateY(-8px) rotate(0deg) !important;
    z-index: 3 !important;
  }
  .shower-theatre .card-2 { bottom: 4%; left: 4%; transform: rotate(-5deg); }
  .shower-theatre .card-3 { bottom: 4%; right: 4%; transform: rotate(5deg); }
  .shower-theatre .card-4 { top: 4%; right: 4%; transform: rotate(-3deg); opacity: 0.85; }

  /* Gold canvas mount corners */
  .shower-theatre .mount-corner {
    position: absolute;
    width: 14px;
    height: 14px;
    background: #d4af37;
    z-index: 3;
    opacity: 0.85;
    box-shadow: 1px 1px 2px rgba(0,0,0,0.15);
  }
  .shower-theatre .mount-top-left { top: 0; left: 0; clip-path: polygon(0 0, 100% 0, 0 100%); }
  .shower-theatre .mount-top-right { top: 0; right: 0; clip-path: polygon(0 0, 100% 0, 100% 100%); }
  .shower-theatre .mount-bottom-left { bottom: 0; left: 0; clip-path: polygon(0 0, 0 100%, 100% 100%); }
  .shower-theatre .mount-bottom-right { bottom: 0; right: 0; clip-path: polygon(100% 0, 0 100%, 100% 100%); }

  /* Golden Art Plaque */
  .shower-theatre .art-plaque {
    position: absolute;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #cfb076, #f9f5dd, #c29d53);
    border: 1px solid #a37c35;
    box-shadow: 0 3px 6px rgba(0,0,0,0.15);
    padding: 3px 12px;
    border-radius: 1px;
    color: #4e3612;
    font-family: 'Montserrat', sans-serif;
    font-size: 8px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    text-align: center;
    z-index: 4;
    pointer-events: none;
  }

  /* ========================================== */
  /* 7. maternity: SPLIT SCREEN + 3D DEPTH LAYERS */
  /* ========================================== */
  .maternity-depth {
    position: relative;
    width: 100%;
    aspect-ratio: 4/3;
    z-index: 2;
  }
  .maternity-depth .depth-card {
    position: absolute;
    background: #fff;
    border: 6px solid #fff;
    border-radius: 4px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    overflow: hidden;
    transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.4s ease;
  }
  .maternity-depth .depth-card img { width: 100%; height: 100%; object-fit: cover; }
  .maternity-depth .depth-card:hover {
    transform: scale(1.04) translateY(-10px) rotate(0deg) !important;
    box-shadow: 0 25px 50px rgba(0,0,0,0.22);
    z-index: 6 !important;
  }
  .maternity-depth .card-1 { width: 58%; height: 72%; top: 4%; left: 4%; transform: rotate(-2deg); z-index: 1; opacity: 0.9; box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
  .maternity-depth .card-2 { width: 52%; height: 64%; bottom: 4%; right: 4%; transform: rotate(3deg); z-index: 2; box-shadow: 0 15px 30px rgba(0,0,0,0.14); }
  .maternity-depth .card-3 { width: 36%; height: 46%; top: 36%; left: 36%; transform: rotate(-4deg); z-index: 3; box-shadow: 0 20px 40px rgba(0,0,0,0.18); }
  
  /* Circular foreground layered badge */
  .maternity-depth .card-4 {
    position: absolute;
    width: 24%;
    aspect-ratio: 1/1;
    border-radius: 50%;
    border: 5px solid #fff;
    box-shadow: 0 12px 28px rgba(0,0,0,0.15);
    top: 8%;
    right: 14%;
    z-index: 4;
    overflow: hidden;
    transform: rotate(6deg);
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }
  .maternity-depth .card-4 img { width: 100%; height: 100%; object-fit: cover; }
  .maternity-depth .card-4:hover { transform: scale(1.1) rotate(0deg); z-index: 5; }

  /* Gold corner elements */
  .maternity-depth .gold-corner {
    position: absolute;
    width: 12px;
    height: 12px;
    border-top: 2px solid #cfb076;
    border-left: 2px solid #cfb076;
    top: 8px;
    left: 8px;
    z-index: 3;
  }
  .maternity-depth .gold-corner-tr {
    left: auto;
    right: 8px;
    border-left: none;
    border-right: 2px solid #cfb076;
  }

  /* Abstract background rings */
  .maternity-depth .background-ring {
    position: absolute;
    border: 1px solid rgba(207, 176, 118, 0.22);
    border-radius: 50%;
    pointer-events: none;
    z-index: 0;
  }
  .maternity-depth .ring-1 { width: 140px; height: 140px; top: 10%; right: 10%; }
  .maternity-depth .ring-2 { width: 220px; height: 220px; bottom: 5%; left: 5%; }

  /* Reversed layout desktop adjustments for text column order swapping */
  .row-reverse .wedding-stack .card-1 { width: 52%; height: 72%; top: 4%; right: 4%; left: auto; transform: rotate(3deg); }
  .row-reverse .wedding-stack .card-2 { width: 46%; height: 60%; top: 16%; left: 4%; right: auto; transform: rotate(-4deg); }
  .row-reverse .wedding-stack .card-3 { width: 38%; height: 48%; bottom: 4%; right: 16%; left: auto; transform: rotate(-2deg); }
  .row-reverse .wedding-stack .card-4 { width: 40%; height: 50%; bottom: 6%; left: 18%; right: auto; transform: rotate(5deg); }

  .row-reverse .reception-bento .card-1 { grid-column: 6 / 13; grid-row: 1 / 8; }
  .row-reverse .reception-bento .card-2 { grid-column: 1 / 6; grid-row: 1 / 5; }
  .row-reverse .reception-bento .card-3 { grid-column: 8 / 13; grid-row: 8 / 13; }
  .row-reverse .reception-bento .card-4 { grid-column: 1 / 8; grid-row: 5 / 13; }

  .row-reverse .baby-constellation .main-circle { left: auto; right: 27%; }
  .row-reverse .baby-constellation .card-2 { left: auto; right: 6%; }
  .row-reverse .baby-constellation .card-3 { right: auto; left: 6%; }
  .row-reverse .baby-constellation .card-4 { right: auto; left: 10%; }
  .row-reverse .baby-constellation .sticker-1 { left: auto; right: 8%; transform: rotate(-10deg); }
  .row-reverse .baby-constellation .sticker-2 { left: auto; right: 35%; transform: rotate(5deg); }
  .row-reverse .baby-constellation svg { transform: scaleX(-1); }

  .row-reverse .birthday-diagonal::before { transform: rotate(-18deg); }
  .row-reverse .birthday-diagonal .card-1 { left: auto; right: 4%; transform: rotate(6deg); }
  .row-reverse .birthday-diagonal .card-2 { left: auto; right: 46%; transform: rotate(-3deg); }
  .row-reverse .birthday-diagonal .card-3 { right: auto; left: 4%; transform: rotate(4deg); }
  .row-reverse .birthday-diagonal .card-4 { left: auto; right: 12%; transform: rotate(-6deg); }

  .row-reverse .shower-theatre .card-2 { left: auto; right: 4%; transform: rotate(5deg); }
  .row-reverse .shower-theatre .card-3 { right: auto; left: 4%; transform: rotate(-5deg); }
  .row-reverse .shower-theatre .card-4 { right: auto; left: 4%; transform: rotate(3deg); }

  .row-reverse .maternity-depth .card-1 { left: auto; right: 4%; transform: rotate(2deg); }
  .row-reverse .maternity-depth .card-2 { right: auto; left: 4%; transform: rotate(-3deg); }
  .row-reverse .maternity-depth .card-3 { left: auto; right: 36%; transform: rotate(4deg); }
  .row-reverse .maternity-depth .card-4 { right: auto; left: 14%; transform: rotate(-6deg); }
  .row-reverse .maternity-depth .ring-1 { right: auto; left: 10%; }
  .row-reverse .maternity-depth .ring-2 { left: auto; right: 5%; }

  /* Full responsive fallback rules for small viewports */
  @media (max-width: 991.98px) {
    .service-section-wrap {
      padding: 60px 0;
    }
    .wedding-stack, .reception-bento, .prewedding-magazine, .baby-constellation, .birthday-diagonal, .shower-theatre, .maternity-depth {
      aspect-ratio: auto !important;
      display: flex !important;
      flex-wrap: wrap !important;
      gap: 12px !important;
      padding: 10px 0 !important;
    }
    .wedding-stack .stack-card, 
    .reception-bento .bento-card, 
    .prewedding-magazine .film-card,
    .baby-constellation .main-circle,
    .baby-constellation .sub-circle,
    .birthday-diagonal .postcard-card,
    .shower-theatre .theatre-hero-frame,
    .shower-theatre .theatre-side-panel,
    .maternity-depth .depth-card,
    .maternity-depth .card-4 {
      position: static !important;
      width: calc(50% - 6px) !important;
      height: 180px !important;
      transform: none !important;
      border-width: 3px !important;
      border-radius: 8px !important;
      opacity: 1 !important;
      padding: 0 !important;
      box-shadow: 0 6px 15px rgba(0,0,0,0.06) !important;
      outline: none !important;
    }
    .wedding-stack .stack-card img,
    .birthday-diagonal .postcard-card img,
    .shower-theatre .theatre-hero-frame img,
    .shower-theatre .theatre-side-panel img {
      border: none !important;
    }
    .prewedding-magazine .magazine-cover {
      width: 100% !important;
      height: 280px !important;
      position: static !important;
      border-radius: 8px !important;
      border: none !important;
    }
    .prewedding-magazine .film-strip-wrap {
      width: 100% !important;
      margin-top: 10px !important;
      background: none !important;
      padding: 0 !important;
      box-shadow: none !important;
      overflow: visible !important;
    }
    .prewedding-magazine .film-reel {
      width: 100% !important;
      animation: none !important;
      display: flex !important;
      flex-wrap: wrap !important;
      gap: 12px !important;
    }
    .prewedding-magazine .film-card {
      width: calc(33.333% - 8px) !important;
      height: 120px !important;
    }
    .prewedding-magazine .film-card:nth-child(n+7) {
      display: none !important;
    }
    .prewedding-magazine .film-strip-sprockets,
    .prewedding-magazine .film-strip-wrap::before,
    .prewedding-magazine .film-strip-wrap::after {
      display: none !important;
    }
    .baby-constellation svg {
      display: none !important;
    }
    .birthday-diagonal::before {
      display: none !important;
    }
    .maternity-depth .background-ring {
      display: none !important;
    }
    /* Hide decorative overlays/borders/captions/badges on mobile to keep layout clean */
    .wedding-stack .stack-card::before,
    .wedding-stack .polaroid-caption,
    .reception-bento .bento-clip,
    .reception-bento .glass-overlay,
    .prewedding-magazine .magazine-pin,
    .prewedding-magazine .magazine-header,
    .prewedding-magazine .magazine-side-story,
    .prewedding-magazine .magazine-date-issue,
    .baby-constellation .baby-sticker,
    .birthday-diagonal .postcard-label,
    .birthday-diagonal .postcard-stamp,
    .shower-theatre .mount-corner,
    .shower-theatre .art-plaque,
    .maternity-depth .gold-corner {
      display: none !important;
    }
    .stack-card:hover, .bento-card:hover, .film-card:hover, .main-circle:hover, .sub-circle:hover, .postcard-card:hover, .theatre-hero-frame:hover, .theatre-side-panel:hover, .depth-card:hover, .card-4:hover {
      transform: translateY(-4px) !important;
    }
  }

  @media (max-width: 575.98px) {
    .wedding-stack .stack-card, 
    .reception-bento .bento-card, 
    .prewedding-magazine .film-card,
    .baby-constellation .main-circle,
    .baby-constellation .sub-circle,
    .birthday-diagonal .postcard-card,
    .shower-theatre .theatre-hero-frame,
    .shower-theatre .theatre-side-panel,
    .maternity-depth .depth-card,
    .maternity-depth .card-4 {
      height: 130px !important;
    }
    .prewedding-magazine .magazine-cover {
      height: 200px !important;
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
                BASE_URL . '/assets/images/images/wedding/img_6.jpg',
                BASE_URL . '/assets/images/images/wedding/img_11.jpg',
                BASE_URL . '/assets/images/images/wedding/img_18.jpg',
                BASE_URL . '/assets/images/images/wedding/img_15.jpg'
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
                BASE_URL . '/assets/images/images/pre_wedding/pre_wedding_7.jpg',
                BASE_URL . '/assets/images/images/wedding/img_5.jpg',
                BASE_URL . '/assets/images/images/wedding/img_9.jpg',
                BASE_URL . '/assets/images/images/wedding/img_14.jpg'
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
          <!-- Visual Showcase Column -->
          <div class="col-lg-7">
            <?php if ($service['slug'] === 'weddings'): ?>
              <!-- weddings: Floating Photo Stack + Polaroid Collection -->
              <div class="wedding-stack">
                <div class="stack-card card-1">
                  <img src="<?php echo $collage_images[0]; ?>" alt="Wedding" loading="lazy" />
                  <div class="polaroid-caption">Perfect Moments</div>
                </div>
                <div class="stack-card card-2">
                  <img src="<?php echo $collage_images[1]; ?>" alt="Wedding" loading="lazy" />
                  <div class="polaroid-caption">Sweet Vows</div>
                </div>
                <div class="stack-card card-3">
                  <img src="<?php echo $collage_images[2]; ?>" alt="Wedding" loading="lazy" />
                  <div class="polaroid-caption">Eternal Love</div>
                </div>
                <div class="stack-card card-4">
                  <img src="<?php echo $collage_images[3]; ?>" alt="Wedding" loading="lazy" />
                  <div class="polaroid-caption">Forever Stories</div>
                </div>
              </div>
            <?php elseif ($service['slug'] === 'reception'): ?>
              <!-- reception: Bento Grid + Glass Showcase Cards -->
              <div class="reception-bento">
                <div class="bento-card card-1">
                  <svg class="bento-clip" viewBox="0 0 14 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 34V8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8V24C17 27.866 13.866 31 10 31C6.13401 31 3 27.866 3 24V10C3 7.23858 5.23858 5 8 5" stroke="#7f8c8d" stroke-width="1.8" stroke-linecap="round"/>
                  </svg>
                  <img src="<?php echo $collage_images[0]; ?>" alt="Reception" loading="lazy" />
                  <div class="glass-overlay">
                    <h5>Grand Hall</h5>
                    <p>Celebration Venue</p>
                  </div>
                </div>
                <div class="bento-card card-2">
                  <img src="<?php echo $collage_images[1]; ?>" alt="Reception" loading="lazy" />
                  <div class="glass-overlay">
                    <h5>Warm Glow</h5>
                    <p>Sparkles &amp; Lights</p>
                  </div>
                </div>
                <div class="bento-card card-3">
                  <img src="<?php echo $collage_images[2]; ?>" alt="Reception" loading="lazy" />
                  <div class="glass-overlay">
                    <h5>Laughter</h5>
                    <p>Shared Moments</p>
                  </div>
                </div>
                <div class="bento-card card-4">
                  <img src="<?php echo $collage_images[3]; ?>" alt="Reception" loading="lazy" />
                  <div class="glass-overlay">
                    <h5>The Dance</h5>
                    <p>Under the Stars</p>
                  </div>
                </div>
              </div>
            <?php elseif ($service['slug'] === 'pre-wedding'): ?>
              <!-- pre-wedding: Magazine Cover Layout + Film Strip -->
              <div class="prewedding-magazine">
                <div class="magazine-pin"></div>
                <div class="magazine-cover">
                  <div class="magazine-header">
                    <h4>ASTRA</h4>
                    <p>Photography &amp; Lifestyle</p>
                  </div>
                  <img src="<?php echo $collage_images[0]; ?>" alt="Pre Wedding" loading="lazy" />
                  <div class="magazine-side-story">
                    <h5>Love in Bloom</h5>
                    <p>Chasing sunsets and beautiful moments in style</p>
                  </div>
                  <div class="magazine-date-issue">Vol. 12 / Issue 8</div>
                </div>
                <div class="film-strip-wrap">
                  <div class="film-strip-sprockets sprockets-top"></div>
                  <div class="film-reel">
                    <div class="film-card"><img src="<?php echo $collage_images[1]; ?>" alt="Pre Wedding Film 1" loading="lazy" /></div>
                    <div class="film-card"><img src="<?php echo $collage_images[4]; ?>" alt="Wedding Showcase 1" loading="lazy" /></div>
                    <div class="film-card"><img src="<?php echo $collage_images[2]; ?>" alt="Pre Wedding Film 2" loading="lazy" /></div>
                    <div class="film-card"><img src="<?php echo $collage_images[5]; ?>" alt="Wedding Showcase 2" loading="lazy" /></div>
                    <div class="film-card"><img src="<?php echo $collage_images[3]; ?>" alt="Pre Wedding Film 3" loading="lazy" /></div>
                    <div class="film-card"><img src="<?php echo $collage_images[6]; ?>" alt="Wedding Showcase 3" loading="lazy" /></div>
                    <!-- Duplicate images for seamless scroll looping -->
                    <div class="film-card"><img src="<?php echo $collage_images[1]; ?>" alt="Pre Wedding Film 1 Copy" loading="lazy" /></div>
                    <div class="film-card"><img src="<?php echo $collage_images[4]; ?>" alt="Wedding Showcase 1 Copy" loading="lazy" /></div>
                    <div class="film-card"><img src="<?php echo $collage_images[2]; ?>" alt="Pre Wedding Film 2 Copy" loading="lazy" /></div>
                    <div class="film-card"><img src="<?php echo $collage_images[5]; ?>" alt="Wedding Showcase 2 Copy" loading="lazy" /></div>
                    <div class="film-card"><img src="<?php echo $collage_images[3]; ?>" alt="Pre Wedding Film 3 Copy" loading="lazy" /></div>
                    <div class="film-card"><img src="<?php echo $collage_images[6]; ?>" alt="Wedding Showcase 3 Copy" loading="lazy" /></div>
                  </div>
                  <div class="film-strip-sprockets sprockets-bottom"></div>
                </div>
              </div>
            <?php elseif ($service['slug'] === 'baby-shoots'): ?>
              <!-- baby-shoots: Constellation Layout + Scrapbook Style -->
              <div class="baby-constellation">
                <svg viewBox="0 0 400 300">
                  <path d="M 60,60 C 120,60 160,110 200,110 C 240,110 280,60 340,60" fill="none" stroke="#f7a4a4" stroke-width="2" stroke-dasharray="4,6" />
                  <path d="M 200,110 C 200,160 250,220 300,220" fill="none" stroke="#f7a4a4" stroke-width="2" stroke-dasharray="4,6" />
                  <circle cx="200" cy="110" r="4" fill="#f7a4a4" />
                  <circle cx="60" cy="60" r="4" fill="#f7a4a4" />
                  <circle cx="340" cy="60" r="4" fill="#f7a4a4" />
                  <circle cx="300" cy="220" r="4" fill="#f7a4a4" />
                </svg>
                <div class="baby-sticker sticker-1">So Cute!</div>
                <div class="baby-sticker sticker-2">Oh Baby ♥</div>
                <div class="main-circle"><img src="<?php echo $collage_images[0]; ?>" alt="Baby" loading="lazy" /></div>
                <div class="sub-circle card-2"><img src="<?php echo $collage_images[1]; ?>" alt="Baby" loading="lazy" /></div>
                <div class="sub-circle card-3"><img src="<?php echo $collage_images[2]; ?>" alt="Baby" loading="lazy" /></div>
                <div class="sub-circle card-4"><img src="<?php echo $collage_images[3]; ?>" alt="Baby" loading="lazy" /></div>
              </div>
            <?php elseif ($service['slug'] === 'birthdays'): ?>
              <!-- birthdays: Diagonal Ribbon + Premium Postcard Cards -->
              <div class="birthday-diagonal">
                <div class="postcard-card card-1">
                  <div class="postcard-stamp"></div>
                  <img src="<?php echo $collage_images[0]; ?>" alt="Birthday" loading="lazy" />
                  <div class="postcard-label">Make a Wish</div>
                </div>
                <div class="postcard-card card-2">
                  <img src="<?php echo $collage_images[1]; ?>" alt="Birthday" loading="lazy" />
                  <div class="postcard-label">Birthday Magic</div>
                </div>
                <div class="postcard-card card-3">
                  <img src="<?php echo $collage_images[2]; ?>" alt="Birthday" loading="lazy" />
                  <div class="postcard-label">Sweet Smiles</div>
                </div>
                <div class="postcard-card card-4">
                  <img src="<?php echo $collage_images[3]; ?>" alt="Birthday" loading="lazy" />
                  <div class="postcard-label">Celebration</div>
                </div>
              </div>
            <?php elseif ($service['slug'] === 'baby-shower'): ?>
              <!-- baby-shower: Gallery Theatre Layout + Framed Display -->
              <div class="shower-theatre">
                <div class="theatre-hero-frame">
                  <div class="mount-corner mount-top-left"></div>
                  <div class="mount-corner mount-top-right"></div>
                  <div class="mount-corner mount-bottom-left"></div>
                  <div class="mount-corner mount-bottom-right"></div>
                  <img src="<?php echo $collage_images[0]; ?>" alt="Baby Shower" loading="lazy" />
                  <div class="art-plaque">"Mom-to-Be Journey" • AstraClicks</div>
                </div>
                <div class="theatre-side-panel card-2">
                  <div class="mount-corner mount-top-left"></div>
                  <div class="mount-corner mount-top-right"></div>
                  <div class="mount-corner mount-bottom-left"></div>
                  <div class="mount-corner mount-bottom-right"></div>
                  <img src="<?php echo $collage_images[1]; ?>" alt="Baby Shower" loading="lazy" />
                </div>
                <div class="theatre-side-panel card-3">
                  <div class="mount-corner mount-top-left"></div>
                  <div class="mount-corner mount-top-right"></div>
                  <div class="mount-corner mount-bottom-left"></div>
                  <div class="mount-corner mount-bottom-right"></div>
                  <img src="<?php echo $collage_images[2]; ?>" alt="Baby Shower" loading="lazy" />
                </div>
                <div class="theatre-side-panel card-4">
                  <div class="mount-corner mount-top-left"></div>
                  <div class="mount-corner mount-top-right"></div>
                  <div class="mount-corner mount-bottom-left"></div>
                  <div class="mount-corner mount-bottom-right"></div>
                  <img src="<?php echo $collage_images[3]; ?>" alt="Baby Shower" loading="lazy" />
                </div>
              </div>
            <?php elseif ($service['slug'] === 'maternity'): ?>
              <!-- maternity: Depth Layer Composition + Split screen -->
              <div class="maternity-depth">
                <div class="background-ring ring-1"></div>
                <div class="background-ring ring-2"></div>
                <div class="depth-card card-1">
                  <div class="gold-corner"></div>
                  <div class="gold-corner gold-corner-tr"></div>
                  <img src="<?php echo $collage_images[0]; ?>" alt="Maternity" loading="lazy" />
                </div>
                <div class="depth-card card-2">
                  <div class="gold-corner"></div>
                  <div class="gold-corner gold-corner-tr"></div>
                  <img src="<?php echo $collage_images[1]; ?>" alt="Maternity" loading="lazy" />
                </div>
                <div class="depth-card card-3">
                  <div class="gold-corner"></div>
                  <div class="gold-corner gold-corner-tr"></div>
                  <img src="<?php echo $collage_images[2]; ?>" alt="Maternity" loading="lazy" />
                </div>
                <div class="card-4">
                  <img src="<?php echo $collage_images[3]; ?>" alt="Maternity" loading="lazy" />
                </div>
              </div>
            <?php else: ?>
              <!-- Fallback to grid collage polaroid style -->
              <div class="wedding-stack">
                <div class="stack-card card-1">
                  <img src="<?php echo $collage_images[0]; ?>" alt="Service" loading="lazy" />
                  <div class="polaroid-caption">Moments</div>
                </div>
                <div class="stack-card card-2">
                  <img src="<?php echo $collage_images[1]; ?>" alt="Service" loading="lazy" />
                  <div class="polaroid-caption">Vows</div>
                </div>
                <div class="stack-card card-3">
                  <img src="<?php echo $collage_images[2]; ?>" alt="Service" loading="lazy" />
                  <div class="polaroid-caption">Love</div>
                </div>
                <div class="stack-card card-4">
                  <img src="<?php echo $collage_images[3]; ?>" alt="Service" loading="lazy" />
                  <div class="polaroid-caption">Stories</div>
                </div>
              </div>
            <?php endif; ?>
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
