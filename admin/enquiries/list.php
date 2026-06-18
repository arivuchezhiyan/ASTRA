<?php
require_once dirname(dirname(__DIR__)) . '/app/config/database.php';
require_once dirname(dirname(__DIR__)) . '/app/helpers/functions.php';
require_admin_login();

// Handle search and filters
$search = trim($_GET['search'] ?? '');
$start_date = trim($_GET['start_date'] ?? '');
$end_date = trim($_GET['end_date'] ?? '');

$where = [];
$params = [];

if (!empty($search)) {
    $where[] = "(name LIKE ? OR whatsapp_number LIKE ? OR event_details LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($start_date)) {
    $where[] = "event_date >= ?";
    $params[] = $start_date;
}

if (!empty($end_date)) {
    $where[] = "event_date <= ?";
    $params[] = $end_date;
}

$where_sql = '';
if (!empty($where)) {
    $where_sql = 'WHERE ' . implode(' AND ', $where);
}

// Handle CSV Export
if (isset($_GET['export'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=enquiries_' . date('Y-m-d') . '.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Name', 'WhatsApp Number', 'Event Details', 'Event Date', 'Created At']);
    
    $sql = "SELECT * FROM enquiries $where_sql ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    while ($row = $stmt->fetch()) {
        fputcsv($output, [
            $row['id'],
            $row['name'],
            $row['whatsapp_number'],
            $row['event_details'],
            $row['event_date'],
            $row['created_at']
        ]);
    }
    fclose($output);
    exit;
}

// For rendering, implement pagination
$page = (int)($_GET['page'] ?? 1);
if ($page < 1) $page = 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;

// Count total matching
$count_sql = "SELECT COUNT(*) FROM enquiries $where_sql";
$count_stmt = $pdo->prepare($count_sql);
$count_stmt->execute($params);
$total_rows = $count_stmt->fetchColumn();
$total_pages = ceil($total_rows / $per_page);

// Fetch data
$sql = "SELECT * FROM enquiries $where_sql ORDER BY created_at DESC LIMIT $per_page OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$enquiries = $stmt->fetchAll();

$admin_page_title = 'Enquiries';
include dirname(__DIR__) . '/includes/header.php';
?>

<div class="admin-card mb-30" style="margin-bottom:24px;">
  <div class="card-header"><h5>Filter Enquiries</h5></div>
  <div class="card-body">
    <form method="get" class="admin-form">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Search Query</label>
            <input type="text" class="form-control" name="search" placeholder="Search by name, whatsapp, event details..." value="<?php echo sanitize($search); ?>">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Event Start Date</label>
            <input type="date" class="form-control" name="start_date" value="<?php echo sanitize($start_date); ?>">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Event End Date</label>
            <input type="date" class="form-control" name="end_date" value="<?php echo sanitize($end_date); ?>">
          </div>
        </div>
        <div class="col-md-2" style="display:flex;align-items:flex-end;gap:10px;">
          <div class="form-group" style="width:100%;margin-bottom:1rem;display:flex;gap:10px;">
            <button type="submit" class="btn-admin btn-primary-admin" style="flex:1;justify-content:center;"><i class="fa fa-filter"></i> Filter</button>
            <a href="list.php" class="btn-admin btn-outline-admin" style="flex:1;justify-content:center;"><i class="fa fa-refresh"></i> Clear</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="admin-card">
  <div class="card-header" style="justify-content: space-between; flex-wrap: wrap; gap: 15px;">
    <h5>Enquiries List (<?php echo $total_rows; ?> matched)</h5>
    <div>
      <?php
      // Build export url with filters
      $export_url = 'list.php?export=1';
      if (!empty($search)) $export_url .= '&search=' . urlencode($search);
      if (!empty($start_date)) $export_url .= '&start_date=' . urlencode($start_date);
      if (!empty($end_date)) $export_url .= '&end_date=' . urlencode($end_date);
      ?>
      <a href="<?php echo $export_url; ?>" class="btn-admin btn-success-admin"><i class="fa fa-file-excel-o"></i> Export to CSV</a>
    </div>
  </div>
  <div class="card-body" style="padding:0;">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>WhatsApp Number</th>
          <th>Event Date</th>
          <th>Event Details</th>
          <th>Received At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($enquiries)): ?>
        <tr><td colspan="7" style="text-align:center;padding:30px;color:#999;">No enquiries found.</td></tr>
        <?php else: ?>
        <?php foreach ($enquiries as $enq): ?>
        <tr>
          <td><?php echo $enq['id']; ?></td>
          <td><strong><?php echo sanitize($enq['name']); ?></strong></td>
          <td>
            <a href="https://wa.me/91<?php echo $enq['whatsapp_number']; ?>" target="_blank" class="text-success" style="font-weight: 500;">
              <i class="fa fa-whatsapp"></i> <?php echo sanitize($enq['whatsapp_number']); ?>
            </a>
          </td>
          <td><?php echo $enq['event_date'] ? format_date($enq['event_date']) : 'N/A'; ?></td>
          <td>
            <div style="max-width:300px; white-space:pre-wrap; font-size:13px;"><?php echo sanitize($enq['event_details']); ?></div>
          </td>
          <td><?php echo format_date($enq['created_at'], 'j M Y, H:i'); ?></td>
          <td>
            <a href="delete.php?id=<?php echo $enq['id']; ?>" class="btn-admin btn-sm-admin btn-danger-admin btn-delete"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <?php if ($total_pages > 1): ?>
    <div style="padding: 15px; display: flex; justify-content: center;">
      <div class="pagination-admin">
        <?php
        // Build base URL for pagination
        $query_params = $_GET;
        unset($query_params['page']);
        $base_qs = http_build_query($query_params);
        $base_pagination_url = 'list.php?' . ($base_qs ? $base_qs . '&' : '');
        ?>
        <?php if ($page > 1): ?>
          <a href="<?php echo $base_pagination_url . 'page=' . ($page - 1); ?>" class="btn-admin btn-sm-admin btn-outline-admin"><i class="fa fa-chevron-left"></i></a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <a href="<?php echo $base_pagination_url . 'page=' . $i; ?>" class="btn-admin btn-sm-admin <?php echo $i === $page ? 'btn-primary-admin' : 'btn-outline-admin'; ?>">
            <?php echo $i; ?>
          </a>
        <?php endfor; ?>
        
        <?php if ($page < $total_pages): ?>
          <a href="<?php echo $base_pagination_url . 'page=' . ($page + 1); ?>" class="btn-admin btn-sm-admin btn-outline-admin"><i class="fa fa-chevron-right"></i></a>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
