/* ========================================
   HMI Tour Payment - Invoices Module
   ======================================== */

/**
 * Initialize the invoices page
 */
const initInvoicesPage = () => {
  if (!requireAuth()) return;

  const user = getCurrentUser();
  if (!user) return;

  renderInvoiceStats(user);
  renderInvoices(user);
  initInvoiceFilters();
  initInvoiceSearch();
};

/**
 * Render invoice statistics
 * @param {object} user - Current user
 */
const renderInvoiceStats = (user) => {
  const invoices = getUserInvoices(user.id);

  const totalInvoices = invoices.length;
  const paidCount = invoices.filter((inv) => inv.status === 'lunas').length;
  const unpaidCount = invoices.filter((inv) => inv.status === 'belum_lunas').length;

  const totalStat = document.getElementById('totalInvoices');
  const paidStat = document.getElementById('paidInvoices');
  const unpaidStat = document.getElementById('unpaidInvoices');

  if (totalStat) totalStat.textContent = totalInvoices;
  if (paidStat) paidStat.textContent = paidCount;
  if (unpaidStat) unpaidStat.textContent = unpaidCount;
};

/**
 * Render invoice list
 * @param {object} user - Current user
 * @param {string} filter - Filter type: 'all', 'lunas', 'belum_lunas'
 * @param {string} searchQuery - Search query string
 */
const renderInvoices = (user, filter = 'all', searchQuery = '') => {
  const container = document.getElementById('invoiceList');
  if (!container) return;

  let invoices = getUserInvoices(user.id);

  // Apply filter
  if (filter !== 'all') {
    invoices = invoices.filter((inv) => inv.status === filter);
  }

  // Apply search
  if (searchQuery) {
    const query = searchQuery.toLowerCase();
    invoices = invoices.filter(
      (inv) =>
        inv.id.toLowerCase().includes(query) ||
        inv.tourPackage.toLowerCase().includes(query)
    );
  }

  if (invoices.length === 0) {
    container.innerHTML = `
      <div class="empty-state">
        <div class="empty-state-icon">📋</div>
        <h3 class="empty-state-title">Tidak ada invoice ditemukan</h3>
        <p class="empty-state-text">
          ${filter !== 'all'
        ? 'Tidak ada invoice dengan status ini.'
        : 'Belum ada invoice yang terdaftar untuk akun Anda.'}
        </p>
      </div>
    `;
    return;
  }

  container.innerHTML = invoices.map((inv) => createInvoiceCard(inv)).join('');

  // Add click handlers for expand/collapse
  container.querySelectorAll('.invoice-card-main').forEach((card) => {
    card.addEventListener('click', () => {
      const invoiceId = card.dataset.invoiceId;
      toggleInvoiceDetail(invoiceId);
    });
  });

  // Add print button handlers
  container.querySelectorAll('.btn-print-invoice').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const invoiceId = btn.dataset.invoiceId;
      printInvoice(invoiceId);
    });
  });

  // Add view detail button handlers
  container.querySelectorAll('.btn-view-invoice').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const invoiceId = btn.dataset.invoiceId;
      toggleInvoiceDetail(invoiceId);
    });
  });
};

/**
 * Create an invoice card HTML
 * @param {object} invoice - Invoice data
 * @returns {string} Invoice card HTML
 */
const createInvoiceCard = (invoice) => {
  const isPaid = invoice.status === 'lunas';
  const remaining = invoice.totalAmount - invoice.paidAmount;
  const progressPercent = Math.min(
    Math.round((invoice.paidAmount / invoice.totalAmount) * 100),
    100
  );

  const paymentHistoryHtml = invoice.payments
    ? invoice.payments
      .map(
        (p) => `
      <div class="payment-history-item">
        <span class="payment-history-dot ${p.status === 'verified' ? 'verified' : 'pending'}"></span>
        <span class="payment-history-info">
          ${formatDateShort(p.date)} — ${p.method}${p.bank ? ` (${p.bank.toUpperCase()})` : ''}
        </span>
        <span class="payment-history-amount">${formatCurrency(p.amount)}</span>
      </div>
    `
      )
      .join('')
    : '<p class="text-muted" style="font-size: var(--text-sm);">Belum ada pembayaran</p>';

  return `
    <article class="invoice-card" id="invoice-${invoice.id}">
      <div class="invoice-card-main" data-invoice-id="${invoice.id}">
        <div class="invoice-card-icon ${isPaid ? 'paid' : 'unpaid'}">
          ${isPaid ? '✓' : '⏳'}
        </div>
        <div class="invoice-card-info">
          <div class="invoice-card-id">${invoice.id}</div>
          <div class="invoice-card-tour">${invoice.tourPackage}</div>
        </div>
        <div class="invoice-card-meta">
          <div class="invoice-card-amount">
            <div class="invoice-amount-label">Total Tagihan</div>
            <div class="invoice-amount-value">${formatCurrency(invoice.totalAmount)}</div>
          </div>
          <span class="badge ${isPaid ? 'badge-success' : 'badge-warning'} badge-dot">
            ${isPaid ? 'Lunas' : 'Belum Lunas'}
          </span>
          <div class="invoice-card-actions">
            <button class="btn btn-ghost btn-sm btn-view-invoice" data-invoice-id="${invoice.id}" aria-label="Lihat detail invoice ${invoice.id}">
              👁
            </button>
            <button class="btn btn-ghost btn-sm btn-print-invoice" data-invoice-id="${invoice.id}" aria-label="Cetak invoice ${invoice.id}">
              🖨
            </button>
          </div>
        </div>
      </div>
      <div class="invoice-detail" id="detail-${invoice.id}">
        <div class="invoice-detail-grid">
          <div class="invoice-detail-section">
            <h5>Informasi Invoice</h5>
            <div class="detail-row">
              <span class="detail-label">Nomor Invoice</span>
              <span class="detail-value">${invoice.id}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Paket Tour</span>
              <span class="detail-value">${invoice.tourPackage}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Tanggal Dibuat</span>
              <span class="detail-value">${formatDate(invoice.createdDate)}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Jatuh Tempo</span>
              <span class="detail-value">${formatDate(invoice.dueDate)}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Status</span>
              <span class="detail-value">
                <span class="badge ${isPaid ? 'badge-success' : 'badge-warning'} badge-dot">
                  ${isPaid ? 'Lunas' : 'Belum Lunas'}
                </span>
              </span>
            </div>
          </div>
          <div class="invoice-detail-section">
            <h5>Rincian Pembayaran</h5>
            <div class="detail-row">
              <span class="detail-label">Total Tagihan</span>
              <span class="detail-value">${formatCurrency(invoice.totalAmount)}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Sudah Dibayar</span>
              <span class="detail-value" style="color: var(--color-success);">${formatCurrency(invoice.paidAmount)}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Sisa Tagihan</span>
              <span class="detail-value" style="color: ${isPaid ? 'var(--color-success)' : 'var(--color-danger)'};">${formatCurrency(remaining)}</span>
            </div>
            <div style="margin-top: var(--space-3);">
              <div style="display: flex; justify-content: space-between; margin-bottom: var(--space-2);">
                <span style="font-size: var(--text-xs); color: var(--color-text-muted);">Progress</span>
                <span style="font-size: var(--text-xs); font-weight: 600; color: var(--color-primary);">${progressPercent}%</span>
              </div>
              <div class="progress-bar">
                <div class="progress-fill ${isPaid ? 'success' : ''}" style="width: ${progressPercent}%;"></div>
              </div>
            </div>
          </div>
        </div>
        <div style="margin-top: var(--space-6);">
          <h5 style="font-size: var(--text-sm); font-weight: 600; margin-bottom: var(--space-3);">Riwayat Pembayaran</h5>
          <div class="payment-history-list">
            ${paymentHistoryHtml}
          </div>
        </div>
      </div>
    </article>
  `;
};

/**
 * Toggle invoice detail expansion
 * @param {string} invoiceId - Invoice ID
 */
const toggleInvoiceDetail = (invoiceId) => {
  const detail = document.getElementById(`detail-${invoiceId}`);
  if (!detail) return;

  // Close other open details
  document.querySelectorAll('.invoice-detail.visible').forEach((d) => {
    if (d.id !== `detail-${invoiceId}`) {
      d.classList.remove('visible');
    }
  });

  detail.classList.toggle('visible');
};

/**
 * Initialize invoice filter tabs
 */
const initInvoiceFilters = () => {
  const tabs = document.querySelectorAll('.tab-btn[data-filter]');
  const user = getCurrentUser();

  tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      // Update active tab
      tabs.forEach((t) => t.classList.remove('active'));
      tab.classList.add('active');

      // Re-render with filter
      const filter = tab.dataset.filter;
      const searchInput = document.getElementById('invoiceSearch');
      const searchQuery = searchInput?.value || '';

      renderInvoices(user, filter, searchQuery);
    });
  });
};

/**
 * Initialize invoice search
 */
const initInvoiceSearch = () => {
  const searchInput = document.getElementById('invoiceSearch');
  const user = getCurrentUser();

  if (!searchInput) return;

  const handleSearch = debounce((query) => {
    const activeTab = document.querySelector('.tab-btn.active[data-filter]');
    const filter = activeTab?.dataset.filter || 'all';
    renderInvoices(user, filter, query);
  }, 300);

  searchInput.addEventListener('input', (e) => {
    handleSearch(e.target.value);
  });
};

/**
 * Print a specific invoice
 * @param {string} invoiceId - Invoice ID
 */
const printInvoice = (invoiceId) => {
  const user = getCurrentUser();
  if (!user) return;

  const invoices = getUserInvoices(user.id);
  const invoice = invoices.find((inv) => inv.id === invoiceId);
  if (!invoice) return;

  const isPaid = invoice.status === 'lunas';
  const remaining = invoice.totalAmount - invoice.paidAmount;

  const paymentRows = invoice.payments
    ? invoice.payments
      .map(
        (p, i) => `
        <tr>
          <td>${i + 1}</td>
          <td>${formatDate(p.date)}</td>
          <td>${p.method}${p.bank ? ` (${p.bank.toUpperCase()})` : ''}</td>
          <td style="text-align:right;">${formatCurrency(p.amount)}</td>
          <td><span style="color: ${p.status === 'verified' ? '#059669' : '#D97706'};">${p.status === 'verified' ? 'Terverifikasi' : 'Pending'}</span></td>
        </tr>`
      )
      .join('')
    : '<tr><td colspan="5" style="text-align:center;">Belum ada pembayaran</td></tr>';

  // Open a new window for printing
  const printWindow = window.open('', '_blank', 'width=800,height=600');

  printWindow.document.write(`
    <!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="UTF-8">
      <title>Invoice ${invoice.id} - HMI Tour</title>
      <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: #1a1a2e; padding: 40px; line-height: 1.6; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #8B1A1A; padding-bottom: 20px; margin-bottom: 30px; }
        .header-left h1 { font-family: 'Poppins', sans-serif; font-size: 24px; color: #8B1A1A; }
        .header-left p { font-size: 13px; color: #6b7280; }
        .header-right { text-align: right; }
        .header-right h2 { font-size: 28px; font-family: 'Poppins', sans-serif; color: #1a1a2e; }
        .header-right p { font-size: 13px; color: #6b7280; }
        .status-badge { display: inline-block; padding: 4px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-top: 8px; }
        .status-paid { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
        .status-unpaid { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
        .info-section h3 { font-size: 14px; color: #8B1A1A; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.05em; }
        .info-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; border-bottom: 1px solid #f3f4f6; }
        .info-label { color: #6b7280; }
        .info-value { font-weight: 500; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #f7f8fa; padding: 10px 12px; text-align: left; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; border-bottom: 2px solid #e5e7eb; }
        td { padding: 10px 12px; font-size: 14px; border-bottom: 1px solid #f3f4f6; }
        .summary { margin-top: 20px; border-top: 2px solid #8B1A1A; padding-top: 15px; }
        .summary-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; }
        .summary-total { font-size: 18px; font-weight: 700; color: #8B1A1A; border-top: 1px solid #e5e7eb; padding-top: 10px; margin-top: 8px; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 20px; }
        @media print { body { padding: 20px; } }
      </style>
    </head>
    <body>
      <div class="header">
        <div class="header-left">
          <h1>HMI Tour Travel</h1>
          <p>Sistem Record Pembayaran Tour</p>
          <p>Jl. Merdeka No. 45, Jakarta Pusat</p>
        </div>
        <div class="header-right">
          <h2>INVOICE</h2>
          <p><strong>${invoice.id}</strong></p>
          <p>Tanggal: ${formatDate(invoice.createdDate)}</p>
          <span class="status-badge ${isPaid ? 'status-paid' : 'status-unpaid'}">
            ${isPaid ? '● Lunas' : '● Belum Lunas'}
          </span>
        </div>
      </div>

      <div class="info-grid">
        <div class="info-section">
          <h3>Informasi Member</h3>
          <div class="info-row"><span class="info-label">Nama</span><span class="info-value">${user.name}</span></div>
          <div class="info-row"><span class="info-label">ID Member</span><span class="info-value">${user.id}</span></div>
          <div class="info-row"><span class="info-label">NIK</span><span class="info-value">${user.nik}</span></div>
          <div class="info-row"><span class="info-label">Email</span><span class="info-value">${user.email}</span></div>
          <div class="info-row"><span class="info-label">Telepon</span><span class="info-value">${user.phone}</span></div>
        </div>
        <div class="info-section">
          <h3>Detail Tour</h3>
          <div class="info-row"><span class="info-label">Paket</span><span class="info-value">${invoice.tourPackage}</span></div>
          <div class="info-row"><span class="info-label">Tanggal Invoice</span><span class="info-value">${formatDate(invoice.createdDate)}</span></div>
          <div class="info-row"><span class="info-label">Jatuh Tempo</span><span class="info-value">${formatDate(invoice.dueDate)}</span></div>
        </div>
      </div>

      <h3 style="font-size:14px; color:#8B1A1A; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:10px;">Riwayat Pembayaran</h3>
      <table>
        <thead>
          <tr><th>No</th><th>Tanggal</th><th>Metode</th><th style="text-align:right;">Jumlah</th><th>Status</th></tr>
        </thead>
        <tbody>${paymentRows}</tbody>
      </table>

      <div class="summary">
        <div class="summary-row"><span>Total Tagihan</span><span>${formatCurrency(invoice.totalAmount)}</span></div>
        <div class="summary-row"><span>Total Dibayar</span><span style="color:#059669;">${formatCurrency(invoice.paidAmount)}</span></div>
        <div class="summary-row summary-total"><span>Sisa Tagihan</span><span>${formatCurrency(remaining)}</span></div>
      </div>

      <div class="footer">
        <p>Invoice ini digenerate secara otomatis oleh sistem HMI Tour Travel.</p>
        <p>Dicetak pada: ${formatDate(new Date().toISOString())} | © 2024 HMI Tour Travel</p>
      </div>

      <script>
        window.onload = () => { window.print(); };
      </script>
    </body>
    </html>
  `);

  printWindow.document.close();
};
