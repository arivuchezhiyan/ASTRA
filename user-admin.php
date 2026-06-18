<?php
/**
 * AstraClicks - Admin Login
 * Premium login page matching website aesthetic
 */
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/helpers/functions.php';

// Redirect if already logged in
if (is_admin_logged_in()) {
    redirect(BASE_URL . '/admin/dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid form submission.';
    } else {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $admin_user = getenv('ADMIN_USERNAME') ?: 'admin';
        $admin_pass = getenv('ADMIN_PASSWORD') ?: 'admin123';

        if ($username === $admin_user && $password === $admin_pass) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            $_SESSION['login_time'] = time();
            redirect(BASE_URL . '/admin/dashboard.php');
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | AstraClicks</title>
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/assets/images/icons/astra_clicks_fav_icon.png">
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>/assets/images/icons/astra_clicks_fav_icon.png">
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL; ?>/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL; ?>/css/plugins.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/style/type/icons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL; ?>/css/color/purple.css">
  <!-- <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet"> -->
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL; ?>/css/font/font5.css">
  <style>
    body { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    .login-wrapper { width: 100%; max-width: 440px; padding: 20px; }
    .login-card {
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 50px 40px;
      box-shadow: 0 25px 60px rgba(0,0,0,0.15);
      border: 1px solid rgba(255,255,255,0.2);
    }
    .login-card .logo { margin-bottom: 30px; }
    .login-card h3 { margin-bottom: 8px; font-weight: 700; }
    .login-card p.lead { font-size: 0.95rem; color: #666; margin-bottom: 30px; }
    .login-card .form-control {
      border-radius: 10px;
      padding: 14px 18px;
      border: 2px solid #e8e8e8;
      transition: all 0.3s ease;
      font-size: 0.95rem;
    }
    .login-card .form-control:focus {
      border-color: #8b5cf6;
      box-shadow: 0 0 0 4px rgba(139,92,246,0.1);
    }
    .login-card .btn {
      width: 100%;
      padding: 14px;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    .alert { border-radius: 10px; }
    .bg-overlay {
      position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
      z-index: -1;
    }
  </style>
</head>
<body>
  <div class="bg-overlay"></div>
  <div class="login-wrapper">
    <div class="login-card text-center">
      <div class="logo">
        <img src="<?php echo BASE_URL; ?>/assets/images/icons/astra_clicks_logo.png" alt="AstraClicks" style="max-width: 180px;">
      </div>
      <h3>Welcome Back</h3>
      <p class="lead">Sign in to AstraClicks Admin Panel</p>

      <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <form method="post" action="">
        <?php csrf_field(); ?>
        <div class="form-group mb-20">
          <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
        </div>
        <div class="form-group mb-20">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn">Sign In</button>
      </form>
      <div class="mt-20">
        <a href="<?php echo BASE_URL; ?>" class="nocolor" style="font-size:0.85rem;color:#888;">← Back to Website</a>
      </div>
    </div>
  </div>
  <script src="<?php echo ASSETS_URL; ?>/js/jquery.min.js"></script>
  <script src="<?php echo ASSETS_URL; ?>/js/bootstrap.min.js"></script>
</body>
</html>
