/* ========================================
   HMI Tour Payment - Utility Functions
   ======================================== */

/**
 * Format a number as Indonesian Rupiah currency
 * @param {number} amount - The amount to format
 * @returns {string} Formatted currency string
 */
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(amount);
};

/**
 * Format a date string to Indonesian locale
 * @param {string} dateStr - ISO date string
 * @param {object} options - Intl.DateTimeFormat options
 * @returns {string} Formatted date string
 */
const formatDate = (dateStr, options = {}) => {
  const defaultOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    ...options,
  };
  return new Date(dateStr).toLocaleDateString('id-ID', defaultOptions);
};

/**
 * Format a date string to short format
 * @param {string} dateStr - ISO date string
 * @returns {string} Formatted short date string
 */
const formatDateShort = (dateStr) => {
  return formatDate(dateStr, { month: 'short' });
};

/**
 * Generate a unique ID with prefix
 * @param {string} prefix - ID prefix
 * @returns {string} Generated ID
 */
const generateId = (prefix = 'ID') => {
  const timestamp = Date.now().toString(36);
  const random = Math.random().toString(36).substring(2, 6);
  return `${prefix}-${timestamp}-${random}`.toUpperCase();
};

/**
 * Get initials from a full name
 * @param {string} name - Full name
 * @returns {string} Initials (max 2 characters)
 */
const getInitials = (name) => {
  return name
    .split(' ')
    .map((word) => word[0])
    .join('')
    .substring(0, 2)
    .toUpperCase();
};

/**
 * Show a toast notification
 * @param {string} title - Toast title
 * @param {string} message - Toast message
 * @param {string} type - Toast type: 'success', 'error', 'warning', 'info'
 * @param {number} duration - Duration in ms before auto-dismiss
 */
const showToast = (title, message, type = 'info', duration = 4000) => {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    container.setAttribute('role', 'alert');
    container.setAttribute('aria-live', 'polite');
    document.body.appendChild(container);
  }

  const icons = {
    success: '✓',
    error: '✕',
    warning: '⚠',
    info: 'ℹ',
  };

  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `
    <span class="toast-icon">${icons[type] || icons.info}</span>
    <div class="toast-content">
      <div class="toast-title">${title}</div>
      <p class="toast-message">${message}</p>
    </div>
    <button class="toast-close" aria-label="Tutup notifikasi">&times;</button>
  `;

  container.appendChild(toast);

  const closeBtn = toast.querySelector('.toast-close');
  closeBtn.addEventListener('click', () => removeToast(toast));

  if (duration > 0) {
    setTimeout(() => removeToast(toast), duration);
  }

  return toast;
};

/**
 * Remove a toast notification with animation
 * @param {HTMLElement} toast - Toast element to remove
 */
const removeToast = (toast) => {
  if (!toast || toast.classList.contains('removing')) return;
  toast.classList.add('removing');
  setTimeout(() => toast.remove(), 300);
};

/**
 * Format file size in human readable format
 * @param {number} bytes - File size in bytes
 * @returns {string} Formatted file size
 */
const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

/**
 * Debounce function to limit execution rate
 * @param {Function} func - Function to debounce
 * @param {number} wait - Wait time in ms
 * @returns {Function} Debounced function
 */
const debounce = (func, wait = 300) => {
  let timeout;
  return (...args) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(null, args), wait);
  };
};

/**
 * Simple input validation
 * @param {HTMLInputElement} input - Input element
 * @param {string} message - Error message
 * @returns {boolean} Whether the input is valid
 */
const validateInput = (input, message) => {
  const group = input.closest('.form-group');
  const existingError = group?.querySelector('.form-error');

  if (!input.value.trim()) {
    input.classList.add('error');
    if (group && !existingError) {
      const errorEl = document.createElement('div');
      errorEl.className = 'form-error';
      errorEl.textContent = message;
      group.appendChild(errorEl);
    }
    return false;
  }

  input.classList.remove('error');
  if (existingError) existingError.remove();
  return true;
};

/**
 * Clear all validation errors from a form
 * @param {HTMLFormElement} form - Form element
 */
const clearValidation = (form) => {
  form.querySelectorAll('.error').forEach((el) => el.classList.remove('error'));
  form.querySelectorAll('.form-error').forEach((el) => el.remove());
};

/**
 * Format a number with Indonesian thousand separator
 * @param {number|string} num - Number to format
 * @returns {string} Formatted number
 */
const formatNumber = (num) => {
  return new Intl.NumberFormat('id-ID').format(num);
};

/**
 * Parse a formatted Indonesian number back to integer
 * @param {string} str - Formatted number string
 * @returns {number} Parsed number
 */
const parseFormattedNumber = (str) => {
  return parseInt(str.replace(/\./g, '').replace(/,/g, ''), 10) || 0;
};

/**
 * Save data to localStorage
 * @param {string} key - Storage key
 * @param {*} data - Data to store
 */
const saveToStorage = (key, data) => {
  try {
    localStorage.setItem(key, JSON.stringify(data));
  } catch (e) {
    console.warn('Failed to save to localStorage:', e);
  }
};

/**
 * Load data from localStorage
 * @param {string} key - Storage key
 * @param {*} defaultValue - Default value if key not found
 * @returns {*} Stored data or default value
 */
const loadFromStorage = (key, defaultValue = null) => {
  try {
    const data = localStorage.getItem(key);
    return data ? JSON.parse(data) : defaultValue;
  } catch (e) {
    console.warn('Failed to load from localStorage:', e);
    return defaultValue;
  }
};
