/* ========================================
   HMI Tour Payment - Authentication Module
   ======================================== */

/**
 * Dummy user database for demonstration
 */
const USERS_DB = [
  {
    id: 'HMI-2024-001',
    nik: '3201150305990001',
    name: 'Ahmad Rizky Pratama',
    email: 'ahmad.rizky@email.com',
    phone: '081234567890',
    password: 'demo123',
    role: 'Anggota HMI',
    tourPackage: 'Paket Umrah Reguler 2024',
    tourDate: '2024-09-15',
    totalCost: 25000000,
    paidAmount: 15000000,
    joinDate: '2023-06-15',
  },
  {
    id: 'HMI-2024-002',
    nik: '3201150305990002',
    name: 'Siti Aisyah Ramadhani',
    email: 'siti.aisyah@email.com',
    phone: '081234567891',
    password: 'demo123',
    role: 'Anggota HMI',
    tourPackage: 'Paket Umrah VIP 2024',
    tourDate: '2024-08-20',
    totalCost: 45000000,
    paidAmount: 45000000,
    joinDate: '2023-03-10',
  },
  {
    id: 'HMI-2024-003',
    nik: '3201150305990003',
    name: 'Muhammad Fadli Hakim',
    email: 'fadli.hakim@email.com',
    phone: '081234567892',
    password: 'demo123',
    role: 'Anggota HMI',
    tourPackage: 'Paket Umrah Ekonomi 2024',
    tourDate: '2024-11-01',
    totalCost: 20000000,
    paidAmount: 5000000,
    joinDate: '2024-01-20',
  },
];

/**
 * Dummy payment records
 */
const PAYMENTS_DB = [
  {
    id: 'PAY-001',
    userId: 'HMI-2024-001',
    invoiceId: 'INV-2024-001',
    date: '2024-01-15',
    amount: 5000000,
    method: 'Transfer',
    bank: 'BCA',
    status: 'verified',
    proof: 'bukti_transfer_bca_001.jpg',
  },
  {
    id: 'PAY-002',
    userId: 'HMI-2024-001',
    invoiceId: 'INV-2024-001',
    date: '2024-03-20',
    amount: 5000000,
    method: 'Transfer',
    bank: 'Mandiri',
    status: 'verified',
    proof: 'bukti_transfer_mandiri_002.jpg',
  },
  {
    id: 'PAY-003',
    userId: 'HMI-2024-001',
    invoiceId: 'INV-2024-001',
    date: '2024-05-10',
    amount: 5000000,
    method: 'Tunai',
    bank: null,
    status: 'verified',
    proof: null,
  },
  {
    id: 'PAY-004',
    userId: 'HMI-2024-002',
    invoiceId: 'INV-2024-002',
    date: '2024-01-05',
    amount: 15000000,
    method: 'Transfer',
    bank: 'BCA',
    status: 'verified',
    proof: 'bukti_transfer_bca_004.jpg',
  },
  {
    id: 'PAY-005',
    userId: 'HMI-2024-002',
    invoiceId: 'INV-2024-002',
    date: '2024-02-15',
    amount: 15000000,
    method: 'Transfer',
    bank: 'BNI',
    status: 'verified',
    proof: 'bukti_transfer_bni_005.jpg',
  },
  {
    id: 'PAY-006',
    userId: 'HMI-2024-002',
    invoiceId: 'INV-2024-002',
    date: '2024-04-01',
    amount: 15000000,
    method: 'Transfer',
    bank: 'BCA',
    status: 'verified',
    proof: 'bukti_transfer_bca_006.jpg',
  },
  {
    id: 'PAY-007',
    userId: 'HMI-2024-003',
    invoiceId: 'INV-2024-003',
    date: '2024-02-01',
    amount: 5000000,
    method: 'Tunai',
    bank: null,
    status: 'verified',
    proof: null,
  },
];

/**
 * Dummy invoice records
 */
const INVOICES_DB = [
  {
    id: 'INV-2024-001',
    userId: 'HMI-2024-001',
    tourPackage: 'Paket Umrah Reguler 2024',
    totalAmount: 25000000,
    paidAmount: 15000000,
    status: 'belum_lunas',
    createdDate: '2024-01-10',
    dueDate: '2024-08-15',
  },
  {
    id: 'INV-2024-002',
    userId: 'HMI-2024-002',
    tourPackage: 'Paket Umrah VIP 2024',
    totalAmount: 45000000,
    paidAmount: 45000000,
    status: 'lunas',
    createdDate: '2024-01-03',
    dueDate: '2024-07-20',
  },
  {
    id: 'INV-2024-003',
    userId: 'HMI-2024-003',
    tourPackage: 'Paket Umrah Ekonomi 2024',
    totalAmount: 20000000,
    paidAmount: 5000000,
    status: 'belum_lunas',
    createdDate: '2024-01-25',
    dueDate: '2024-10-01',
  },
];

/**
 * Initialize app data into localStorage for persistence across sessions.
 * Seeds invoice and payment data from static constants on first load only.
 */
const initializeAppData = () => {
  if (loadFromStorage('hmi_invoices') === null) {
    saveToStorage('hmi_invoices', INVOICES_DB.map((inv) => ({ ...inv })));
  }
  if (loadFromStorage('hmi_payments') === null) {
    saveToStorage('hmi_payments', []);
  }
};
initializeAppData();

/**
 * Attempt to log in a user
 * @param {string} email - User email
 * @param {string} password - User password
 * @returns {object|null} User object if successful, null otherwise
 */
const loginUser = (email, password) => {
  const user = USERS_DB.find(
    (u) => u.email === email && u.password === password
  );

  if (user) {
    const { password: _, ...safeUser } = user;

    // Recalculate paidAmount from getUserInvoices() instead of using stored value
    const userInvoices = getUserInvoices(user.id);
    const totalPaid = userInvoices.reduce((sum, inv) => sum + (inv.paidAmount || 0), 0);
    safeUser.paidAmount = totalPaid;

    saveToStorage('hmi_current_user', safeUser);
    saveToStorage('hmi_is_logged_in', true);

    return safeUser;
  }

  return null;
};

/**
 * Log out the current user
 */
const logoutUser = () => {
  localStorage.removeItem('hmi_current_user');
  localStorage.removeItem('hmi_is_logged_in');
  window.location.href = '/';
};

/**
 * Get the currently logged-in user
 * @returns {object|null} Current user or null
 */
const getCurrentUser = () => {
  return loadFromStorage('hmi_current_user', null);
};

/**
 * Check if a user is currently logged in
 * @returns {boolean} Whether a user is logged in
 */
const isLoggedIn = () => {
  return loadFromStorage('hmi_is_logged_in', false);
};

/**
 * Protect a page by redirecting to login if not authenticated
 */
const requireAuth = () => {
  if (!isLoggedIn()) {
    window.location.href = '/';
    return false;
  }
  return true;
};

/**
 * Get payments for a specific user
 * @param {string} userId - User ID
 * @returns {Array} Array of payment records
 */
const getUserPayments = (userId) => {
  const storedPayments = loadFromStorage('hmi_payments', []);
  const allPayments = [...PAYMENTS_DB, ...storedPayments];
  return allPayments
    .filter((p) => p.userId === userId)
    .sort((a, b) => new Date(b.date) - new Date(a.date));
};

/**
 * Get invoices for a specific user
 * @param {string} userId - User ID
 * @returns {Array} Array of invoice records
 */
const getUserInvoices = (userId) => {
  // Read from localStorage first, fallback to INVOICES_DB
  const storedInvoices = loadFromStorage('hmi_invoices');
  const invoices = storedInvoices ? storedInvoices.filter((inv) => inv.userId === userId) : INVOICES_DB.filter((inv) => inv.userId === userId);

  // Recalculate paid amounts from payments
  const userPayments = getUserPayments(userId);

  const updatedInvoices = invoices.map((inv) => {
    const invPayments = userPayments.filter((p) => p.invoiceId === inv.id);
    const totalPaid = invPayments.reduce((sum, p) => sum + p.amount, 0);
    return {
      ...inv,
      paidAmount: totalPaid,
      status: totalPaid >= inv.totalAmount ? 'lunas' : 'belum_lunas',
      payments: invPayments,
    };
  });

  // Sync updated invoices back to localStorage
  if (storedInvoices) {
    // Update only this user's invoices in localStorage
    const otherInvoices = storedInvoices.filter((inv) => inv.userId !== userId);
    saveToStorage('hmi_invoices', [...otherInvoices, ...updatedInvoices]);
  }

  return updatedInvoices;
};

/**
 * Add a new payment record
 * @param {object} payment - Payment data
 * @returns {object} The created payment record
 */
const addPayment = (payment) => {
  const storedPayments = loadFromStorage('hmi_payments', []);
  const newPayment = {
    id: generateId('PAY'),
    date: new Date().toISOString().split('T')[0],
    status: 'pending',
    ...payment,
  };
  storedPayments.push(newPayment);
  saveToStorage('hmi_payments', storedPayments);

  // Update user's paid amount by recalculating from getUserInvoices()
  const user = getCurrentUser();
  if (user) {
    const userInvoices = getUserInvoices(user.id);
    const totalPaid = userInvoices.reduce((sum, inv) => sum + (inv.paidAmount || 0), 0);
    user.paidAmount = totalPaid;
    saveToStorage('hmi_current_user', user);
  }

  return newPayment;
};

/**
 * Get a user by their ID
 * @param {string} userId - User ID
 * @returns {object|null} User object
 */
const getUserById = (userId) => {
  return USERS_DB.find((u) => u.id === userId) || null;
};
