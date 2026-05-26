/* ========================================
   HMI Tour Payment - Navigation Module
   ======================================== */

/**
 * Initialize the sidebar navigation
 */
const initSidebar = () => {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const menuBtn = document.getElementById('mobileMenuBtn');

  if (!sidebar || !menuBtn) return;

  // Toggle mobile sidebar
  menuBtn.addEventListener('click', () => toggleSidebar(true));

  // Close sidebar on overlay click
  if (overlay) {
    overlay.addEventListener('click', () => toggleSidebar(false));
  }

  // Close sidebar on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && sidebar.classList.contains('open')) {
      toggleSidebar(false);
    }
  });

  // Highlight active nav link
  highlightActiveLink();
};

/**
 * Toggle the sidebar open/closed
 * @param {boolean} open - Whether to open the sidebar
 */
const toggleSidebar = (open) => {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');

  if (!sidebar) return;

  if (open) {
    sidebar.classList.add('open');
    overlay?.classList.add('active');
    document.body.style.overflow = 'hidden';
  } else {
    sidebar.classList.remove('open');
    overlay?.classList.remove('active');
    document.body.style.overflow = '';
  }
};

/**
 * Highlight the current page link in the sidebar
 */
const highlightActiveLink = () => {
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll('.sidebar-nav-link');

  navLinks.forEach((link) => {
    const href = link.getAttribute('href');
    // Compare full pathname with href (Blade links are like "/dashboard", "/payment", etc.)
    if (href === currentPath) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });
};

/**
 * Initialize sticky header behavior
 */
const initStickyHeader = () => {
  const header = document.querySelector('.top-header');
  if (!header) return;

  let lastScroll = 0;
  const scrollThreshold = 10;

  const handleScroll = () => {
    const currentScroll = window.scrollY;

    if (currentScroll > scrollThreshold) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }

    lastScroll = currentScroll;
  };

  window.addEventListener('scroll', handleScroll, { passive: true });
};

/**
 * Initialize smooth scroll for anchor links
 */
const initSmoothScroll = () => {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (e) => {
      const targetId = anchor.getAttribute('href');
      if (targetId === '#') return;

      e.preventDefault();
      const target = document.querySelector(targetId);
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start',
        });
      }
    });
  });
};

/**
 * Populate user info in the sidebar and header
 */
const populateUserInfo = () => {
  const user = getCurrentUser();
  if (!user) return;

  // Sidebar user info
  const sidebarUserName = document.getElementById('sidebarUserName');
  const sidebarUserRole = document.getElementById('sidebarUserRole');
  const sidebarAvatar = document.getElementById('sidebarAvatar');

  if (sidebarUserName) sidebarUserName.textContent = user.name;
  if (sidebarUserRole) sidebarUserRole.textContent = user.role;
  if (sidebarAvatar) sidebarAvatar.textContent = getInitials(user.name);

  // Header user info
  const headerUserName = document.getElementById('headerUserName');
  const headerAvatar = document.getElementById('headerAvatar');

  if (headerUserName) headerUserName.textContent = user.name.split(' ')[0];
  if (headerAvatar) headerAvatar.textContent = getInitials(user.name);
};

/**
 * Initialize logout button
 */
const initLogout = () => {
  const logoutBtn = document.getElementById('logoutBtn');
  if (!logoutBtn) return;

  logoutBtn.addEventListener('click', (e) => {
    e.preventDefault();

    // Show confirmation
    const confirmed = confirm('Apakah Anda yakin ingin keluar?');
    if (confirmed) {
      showToast('Berhasil', 'Anda telah logout dari sistem', 'success', 2000);
      setTimeout(() => logoutUser(), 1500);
    }
  });
};

/**
 * Initialize all navigation-related functionality
 */
const initNavigation = () => {
  initSidebar();
  initStickyHeader();
  initSmoothScroll();
  populateUserInfo();
  initLogout();
};
