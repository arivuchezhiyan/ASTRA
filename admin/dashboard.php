<?php
/**
 * Admin Dashboard
 */
$admin_page_title = 'Dashboard';
include __DIR__ . '/includes/header.php';

$total_services = count_total($pdo, 'services');
$total_blogs = count_total($pdo, 'blogs');
$total_gallery = count_total($pdo, 'gallery');
$total_branches = count_total($pdo, 'branches');
$total_enquiries = count_total($pdo, 'enquiries');

// Recent enquiries
$recent_enquiries = get_enquiries($pdo, 1, 5);
?>

<div class="row mb-30" style="margin-bottom:24px;">
  <div class="col-md-4 col-lg mb-20" style="margin-bottom:20px;">
    <div class="stat-card animate-in">
      <div class="stat-icon bg-purple"><i class="fa fa-camera"></i></div>
      <h2><?php echo $total_services; ?></h2>
      <p>Services</p>
    </div>
  </div>
  <div class="col-md-4 col-lg mb-20" style="margin-bottom:20px;">
    <div class="stat-card animate-in" style="animation-delay:0.1s">
      <div class="stat-icon bg-blue"><i class="fa fa-pencil-square-o"></i></div>
      <h2><?php echo $total_blogs; ?></h2>
      <p>Blog Posts</p>
    </div>
  </div>
  <div class="col-md-4 col-lg mb-20" style="margin-bottom:20px;">
    <div class="stat-card animate-in" style="animation-delay:0.2s">
      <div class="stat-icon bg-green"><i class="fa fa-image"></i></div>
      <h2><?php echo $total_gallery; ?></h2>
      <p>Gallery Images</p>
    </div>
  </div>
  <div class="col-md-4 col-lg mb-20" style="margin-bottom:20px;">
    <div class="stat-card animate-in" style="animation-delay:0.3s">
      <div class="stat-icon bg-orange"><i class="fa fa-map-marker"></i></div>
      <h2><?php echo $total_branches; ?></h2>
      <p>Branches</p>
    </div>
  </div>
  <div class="col-md-4 col-lg mb-20" style="margin-bottom:20px;">
    <div class="stat-card animate-in" style="animation-delay:0.4s">
      <div class="stat-icon bg-pink"><i class="fa fa-envelope"></i></div>
      <h2><?php echo $total_enquiries; ?></h2>
      <p>Enquiries</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8" style="margin-bottom:24px;">
    <div class="admin-card">
      <div class="card-header">
        <h5>Recent Enquiries</h5>
        <a href="<?php echo BASE_URL; ?>/admin/enquiries/list.php" class="btn-admin btn-sm-admin btn-outline-admin">View All</a>
      </div>
      <div class="card-body" style="padding:0;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>WhatsApp</th>
              <th>Event</th>
              <th>Date</th>
              <th>Received</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($recent_enquiries)): ?>
            <tr><td colspan="5" style="text-align:center;padding:30px;color:#999;">No enquiries yet</td></tr>
            <?php else: ?>
            <?php foreach ($recent_enquiries as $enq): ?>
            <tr>
              <td><strong><?php echo sanitize($enq['name']); ?></strong></td>
              <td><a href="https://wa.me/91<?php echo $enq['whatsapp_number']; ?>" target="_blank" style="color:var(--success);"><?php echo sanitize($enq['whatsapp_number']); ?></a></td>
              <td><?php echo sanitize(truncate($enq['event_details'], 30)); ?></td>
              <td><?php echo $enq['event_date'] ? format_date($enq['event_date']) : '-'; ?></td>
              <td><?php echo format_date($enq['created_at'], 'j M Y H:i'); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-4" style="margin-bottom:24px;">
    <div class="admin-card">
      <div class="card-header"><h5>Quick Actions</h5></div>
      <div class="card-body">
        <a href="<?php echo BASE_URL; ?>/admin/services/add.php" class="btn-admin btn-primary-admin" style="width:100%;margin-bottom:10px;justify-content:center;"><i class="fa fa-plus"></i> Add Service</a>
        <a href="<?php echo BASE_URL; ?>/admin/blogs/add.php" class="btn-admin btn-primary-admin" style="width:100%;margin-bottom:10px;justify-content:center;"><i class="fa fa-plus"></i> Add Blog Post</a>
        <a href="<?php echo BASE_URL; ?>/admin/gallery/add.php" class="btn-admin btn-primary-admin" style="width:100%;margin-bottom:10px;justify-content:center;"><i class="fa fa-plus"></i> Add Gallery Image</a>
        <a href="<?php echo BASE_URL; ?>/admin/branches/add.php" class="btn-admin btn-primary-admin" style="width:100%;margin-bottom:10px;justify-content:center;"><i class="fa fa-plus"></i> Add Branch</a>
        <hr>
        <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn-admin btn-outline-admin" style="width:100%;justify-content:center;"><i class="fa fa-external-link"></i> View Website</a>
      </div>
    </div>

    <div class="admin-card">
      <div class="card-header"><h5>Website Overview</h5></div>
      <div class="card-body">
        <ul style="list-style:none;padding:0;margin:0;">
          <li style="padding:10px 0;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;">
            <span>Active Services</span>
            <strong><?php echo $total_services; ?></strong>
          </li>
          <li style="padding:10px 0;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;">
            <span>Published Blogs</span>
            <strong><?php echo $total_blogs; ?></strong>
          </li>
          <li style="padding:10px 0;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;">
            <span>Gallery Images</span>
            <strong><?php echo $total_gallery; ?></strong>
          </li>
          <li style="padding:10px 0;display:flex;justify-content:space-between;">
            <span>Total Enquiries</span>
            <strong><?php echo $total_enquiries; ?></strong>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
