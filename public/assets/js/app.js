/* ========================================
   HMI Tour Payment - App Initialization
   ======================================== */

/**
 * Initialize the appropriate page based on the current URL
 */
const initApp = () => {
  const pathname = window.location.pathname;
  let currentPage = '';

  // Extract page name from Laravel route (e.g., /user/dashboard -> user/dashboard)
  if (pathname === '/' || pathname === '') {
    currentPage = '';
  } else {
    // Remove leading slash and trailing slash
    currentPage = pathname.replace(/^\/|\/$/g, '');
  }

  switch (currentPage) {
    case '':
      initLoginPage();
      break;
    case 'user/dashboard':
      initDashboardPage();
      break;
    case 'user/payment':
      initPaymentPage();
      initNavigation();
      break;
    case 'user/invoices':
      initInvoicesPage();
      initNavigation();
      break;
    case 'user/profile':
      initProfilePage();
      initNavigation();
      break;
    default:
      break;
  }
};

/**
 * Initialize the login page
 */
const initLoginPage = () => {
  // If already logged in, redirect to dashboard
  if (isLoggedIn()) {
    window.location.href = '/user/dashboard';
    return;
  }

  const loginForm = document.getElementById('loginForm');
  const emailInput = document.getElementById('loginEmail');
  const passwordInput = document.getElementById('loginPassword');
  const togglePasswordBtn = document.getElementById('togglePassword');
  const loginError = document.getElementById('loginError');

  if (!loginForm) return;

  // Password toggle
  if (togglePasswordBtn && passwordInput) {
    togglePasswordBtn.addEventListener('click', () => {
      const type = passwordInput.type === 'password' ? 'text' : 'password';
      passwordInput.type = type;
      togglePasswordBtn.textContent = type === 'password' ? '👁' : '👁‍🗨';
    });
  }

  // Form submission
  loginForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const email = emailInput?.value?.trim();
    const password = passwordInput?.value;

    if (!email || !password) {
      showLoginError('Silakan isi email dan password Anda.');
      return;
    }

    // Show loading state
    const submitBtn = loginForm.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="btn-spinner"></span> Memproses...';

    // Simulate network delay
    setTimeout(() => {
      const user = loginUser(email, password);

      if (user) {
        showToast('Selamat Datang!', `Halo, ${user.name}`, 'success', 2000);
        setTimeout(() => {
          window.location.href = '/user/dashboard';
        }, 1000);
      } else {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        showLoginError('Email atau password salah. Silakan coba lagi.');

        // Shake animation on form
        loginForm.style.animation = 'none';
        loginForm.offsetHeight; // trigger reflow
        loginForm.style.animation = '';
      }
    }, 1200);
  });

  // Clear error on input
  [emailInput, passwordInput].forEach((input) => {
    input?.addEventListener('input', () => {
      hideLoginError();
    });
  });
};

/**
 * Show login error message
 * @param {string} message - Error message
 */
const showLoginError = (message) => {
  const errorEl = document.getElementById('loginError');
  if (errorEl) {
    errorEl.textContent = `⚠ ${message}`;
    errorEl.classList.remove('hidden');
  }
};

/**
 * Hide login error message
 */
const hideLoginError = () => {
  const errorEl = document.getElementById('loginError');
  if (errorEl) {
    errorEl.classList.add('hidden');
  }
};

/**
 * Initialize the dashboard page
 */
const initDashboardPage = () => {
  if (!requireAuth()) return;

  const user = getCurrentUser();
  if (!user) return;

  initNavigation();
  renderWelcomeBanner(user);
  renderDashboardStats(user);
  renderPaymentProgress(user);
  renderRecentTransactions(user);
  animateDashboardCards();
};

/**
 * Render welcome banner with user name
 * @param {object} user - Current user
 */
const renderWelcomeBanner = (user) => {
  const welcomeName = document.getElementById('welcomeName');
  if (welcomeName) {
    welcomeName.textContent = user.name.split(' ')[0];
  }
};

/**
 * Render dashboard statistics
 * @param {object} user - Current user
 */
const renderDashboardStats = (user) => {
  const invoices = getUserInvoices(user.id);
  const activeInvoice = invoices[0];

  if (!activeInvoice) return;

  const totalCost = activeInvoice.totalAmount;
  const paidAmount = activeInvoice.paidAmount;
  const remaining = totalCost - paidAmount;
  const isPaid = paidAmount >= totalCost;

  const statTotal = document.getElementById('statTotalCost');
  const statPaid = document.getElementById('statPaidAmount');
  const statRemaining = document.getElementById('statRemaining');
  const statStatus = document.getElementById('statStatus');

  if (statTotal) statTotal.textContent = formatCurrency(totalCost);
  if (statPaid) statPaid.textContent = formatCurrency(paidAmount);
  if (statRemaining) statRemaining.textContent = formatCurrency(remaining);
  if (statStatus) {
    statStatus.innerHTML = isPaid
      ? '<span class="badge badge-success badge-dot">Lunas</span>'
      : '<span class="badge badge-warning badge-dot">Belum Lunas</span>';
  }
};

/**
 * Render the payment progress section
 * @param {object} user - Current user
 */
const renderPaymentProgress = (user) => {
  const invoices = getUserInvoices(user.id);
  const activeInvoice = invoices[0];

  if (!activeInvoice) return;

  const percentage = Math.min(
    Math.round((activeInvoice.paidAmount / activeInvoice.totalAmount) * 100),
    100
  );

  const progressPercentage = document.getElementById('progressPercentage');
  const progressFill = document.getElementById('progressFill');
  const progressPaid = document.getElementById('progressPaid');
  const progressTotal = document.getElementById('progressTotal');
  const progressRemaining = document.getElementById('progressRemaining');

  if (progressPercentage) progressPercentage.textContent = `${percentage}%`;
  if (progressFill) progressFill.style.width = `${percentage}%`;
  if (progressPaid) progressPaid.textContent = formatCurrency(activeInvoice.paidAmount);
  if (progressTotal) progressTotal.textContent = formatCurrency(activeInvoice.totalAmount);
  if (progressRemaining) {
    progressRemaining.textContent = formatCurrency(
      activeInvoice.totalAmount - activeInvoice.paidAmount
    );
  }
};

/**
 * Render recent transactions on the dashboard
 * @param {object} user - Current user
 */
const renderRecentTransactions = (user) => {
  const container = document.getElementById('recentTransactions');
  if (!container) return;

  const payments = getUserPayments(user.id);
  const recent = payments.slice(0, 5);

  if (recent.length === 0) {
    container.innerHTML = `
      <div class="empty-state" style="padding: var(--space-8);">
        <div class="empty-state-icon">💳</div>
        <h3 class="empty-state-title">Belum Ada Transaksi</h3>
        <p class="empty-state-text">Mulai pembayaran pertama Anda sekarang.</p>
      </div>
    `;
    return;
  }

  container.innerHTML = recent
    .map(
      (payment) => `
    <div class="transaction-item">
      <div class="transaction-icon ${payment.method === 'Transfer' ? 'transfer' : 'cash'}">
        ${payment.method === 'Transfer' ? '🏦' : '💵'}
      </div>
      <div class="transaction-details">
        <div class="transaction-method">
          ${payment.method}${payment.bank ? ` - ${payment.bank.toUpperCase()}` : ''}
        </div>
        <div class="transaction-date">${formatDate(payment.date)}</div>
      </div>
      <div class="transaction-amount">
        <div class="transaction-value">${formatCurrency(payment.amount)}</div>
        <div class="transaction-status">
          <span class="badge badge-sm ${payment.status === 'verified' ? 'badge-success' : 'badge-warning'}">
            ${payment.status === 'verified' ? 'Terverifikasi' : 'Pending'}
          </span>
        </div>
      </div>
    </div>
  `
    )
    .join('');
};

/**
 * Animate dashboard cards with staggered entrance
 */
const animateDashboardCards = () => {
  const cards = document.querySelectorAll('.stat-card, .quick-action-card, .payment-progress-card');

  cards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';

    setTimeout(() => {
      card.style.transition = 'all 0.5s ease';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, 100 + index * 80);
  });
};

/**
 * Initialize the profile page
 */
const initProfilePage = () => {
  if (!requireAuth()) return;

  const user = getCurrentUser();
  if (!user) return;

  renderProfileInfo(user);
  renderTourPackage(user);
};

/**
 * Render profile information
 * @param {object} user - Current user
 */
const renderProfileInfo = (user) => {
  const profileAvatar = document.getElementById('profileAvatar');
  const profileName = document.getElementById('profileName');
  const profileMemberId = document.getElementById('profileMemberId');

  if (profileAvatar) profileAvatar.textContent = getInitials(user.name);
  if (profileName) profileName.textContent = user.name;
  if (profileMemberId) profileMemberId.textContent = user.id;

  // Personal info
  const infoFields = {
    profileNik: user.nik,
    profileEmail: user.email,
    profilePhone: user.phone,
    profileRole: user.role,
    profileJoinDate: formatDate(user.joinDate),
  };

  Object.entries(infoFields).forEach(([id, value]) => {
    const el = document.getElementById(id);
    if (el) el.textContent = value;
  });
};

/**
 * Render tour package information and progress
 * @param {object} user - Current user
 */
const renderTourPackage = (user) => {
  const invoices = getUserInvoices(user.id);
  const activeInvoice = invoices[0];

  if (!activeInvoice) return;

  const packageName = document.getElementById('tourPackageName');
  const packageDate = document.getElementById('tourPackageDate');
  const progressFill = document.getElementById('tourProgressFill');
  const progressText = document.getElementById('tourProgressText');
  const paidAmount = document.getElementById('tourPaidAmount');
  const remainingAmount = document.getElementById('tourRemainingAmount');

  const percentage = Math.min(
    Math.round((activeInvoice.paidAmount / activeInvoice.totalAmount) * 100),
    100
  );
  const remaining = activeInvoice.totalAmount - activeInvoice.paidAmount;

  if (packageName) packageName.textContent = user.tourPackage;
  if (packageDate) packageDate.textContent = `Jadwal: ${formatDate(user.tourDate)}`;
  if (progressFill) progressFill.style.width = `${percentage}%`;
  if (progressText) progressText.textContent = `${percentage}%`;
  if (paidAmount) paidAmount.textContent = formatCurrency(activeInvoice.paidAmount);
  if (remainingAmount) remainingAmount.textContent = formatCurrency(remaining);
};

// --- Initialize app on DOM ready ---
document.addEventListener('DOMContentLoaded', initApp);
