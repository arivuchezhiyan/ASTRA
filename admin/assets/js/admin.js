/**
 * AstraClicks Admin Panel - JavaScript
 */
document.addEventListener('DOMContentLoaded', function() {

  // Sidebar toggle for mobile
  const toggleBtn = document.querySelector('.sidebar-toggle');
  const sidebar = document.querySelector('.admin-sidebar');
  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', () => sidebar.classList.toggle('open'));
  }

  // Image upload preview
  document.querySelectorAll('.upload-zone').forEach(zone => {
    const input = zone.querySelector('input[type="file"]');
    const preview = zone.querySelector('.preview-img') || zone.parentElement.querySelector('.preview-img');

    if (input) {
      zone.addEventListener('click', () => input.click());
      zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
      zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
      zone.addEventListener('drop', e => {
        e.preventDefault(); zone.classList.remove('dragover');
        input.files = e.dataTransfer.files;
        showPreview(input, preview);
      });
      input.addEventListener('change', () => showPreview(input, preview));
    }
  });

  function showPreview(input, preview) {
    if (input.files && input.files[0] && preview) {
      const reader = new FileReader();
      reader.onload = e => {
        preview.src = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Delete confirmations
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', e => {
      if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
        e.preventDefault();
      }
    });
  });

  // Auto-generate slug from title/name
  const nameInput = document.querySelector('input[name="service_name"], input[name="title"]');
  const slugInput = document.querySelector('input[name="slug"]');
  if (nameInput && slugInput && !slugInput.value) {
    nameInput.addEventListener('input', function() {
      slugInput.value = this.value.toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
    });
  }

  // Auto-dismiss alerts
  document.querySelectorAll('.admin-alert').forEach(alert => {
    setTimeout(() => {
      alert.style.transition = 'opacity 0.5s';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 500);
    }, 5000);
  });
});
