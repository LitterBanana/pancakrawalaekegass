/* ========================================
   HMI Tour Payment - Payment Form Module
   ======================================== */

/**
 * Bank account data mapping
 */
// 4 rekening tujuan resmi HMI Tour Travel
const BANK_ACCOUNTS = {
  bri: {
    name: 'Bank BRI KCP Puspitek Raya',
    accountNumber: '1185-01-000369-302',
    holder: 'HMI Tour Travel'
  },
  bsi: {
    name: 'BSI KCP Pamulang',
    accountNumber: '7201210822',
    holder: 'HMI Tour Travel'
  },
  bca_syariah: {
    name: 'BCA Syariah KCP Ciledug',
    accountNumber: '0281789891',
    holder: 'HMI Tour Travel'
  },
  btn: {
    name: 'Bank BTN',
    accountNumber: '4401880002323',
    holder: 'HMI Tour Travel'
  }
};

/**
 * Initialize the payment form page
 * Catatan: Data user sudah di-render server-side oleh Laravel (Blade).
 * Tidak perlu requireAuth() / getCurrentUser() dari localStorage lagi.
 */
const initPaymentPage = () => {
  if (!document.getElementById('paymentForm')) return;

  initPaymentMethod();
  initAmountInput();
  initAmountShortcuts();
  initFileUpload();
  updatePaymentSummary();

  // ── Helper: tampilkan / sembunyikan error inline ──────────────────────────
  const showErr = (id) => document.getElementById(id)?.classList.add('visible');
  const hideErr = (id) => document.getElementById(id)?.classList.remove('visible');

  // ── Auto-clear error saat user mulai mengisi ───────────────────────────────
  document.getElementById('paymentAmount')?.addEventListener('input', () => {
    document.getElementById('paymentAmount')?.classList.remove('error');
    hideErr('errorAmount');
  });

  document.querySelectorAll('input[name="payment_method"]').forEach((r) => {
    r.addEventListener('change', () => {
      document.getElementById('paymentMethodGroup')?.classList.remove('error-group');
      hideErr('errorMethod');
      // Reset error bank saat metode berganti
      document.getElementById('bankGrid')?.classList.remove('error-group');
      hideErr('errorBank');
    });
  });

  document.querySelectorAll('input[name="bank"]').forEach((r) => {
    r.addEventListener('change', () => {
      document.getElementById('bankGrid')?.classList.remove('error-group');
      hideErr('errorBank');
    });
  });

  document.getElementById('proofFile')?.addEventListener('change', () => {
    document.getElementById('uploadArea')?.classList.remove('error-upload');
    hideErr('errorProof');
  });

  // ── Submit: validasi semua field sebelum dikirim ke server ────────────────
  const form = document.getElementById('paymentForm');
  form?.addEventListener('submit', (e) => {
    const amountInput  = document.getElementById('paymentAmount');
    const amountRaw    = document.getElementById('paymentAmountRaw');
    const methodRadio  = document.querySelector('input[name="payment_method"]:checked');
    const bankRadio    = document.querySelector('input[name="bank"]:checked');
    const proofFile    = document.getElementById('proofFile');

    let valid = true;

    // 1. Validasi Nominal
    const raw = (amountInput?.value || '').replace(/\D/g, '');
    if (!raw || parseInt(raw, 10) <= 0) {
      amountInput?.classList.add('error');
      showErr('errorAmount');
      if (valid) amountInput?.scrollIntoView({ behavior: 'smooth', block: 'center' });
      valid = false;
    } else {
      amountInput?.classList.remove('error');
      hideErr('errorAmount');
      if (amountRaw) amountRaw.value = raw;
    }

    // 2. Validasi Metode Pembayaran
    if (!methodRadio) {
      document.getElementById('paymentMethodGroup')?.classList.add('error-group');
      showErr('errorMethod');
      if (valid) document.getElementById('paymentMethodGroup')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
      valid = false;
    } else {
      document.getElementById('paymentMethodGroup')?.classList.remove('error-group');
      hideErr('errorMethod');
    }

    // 3. Validasi Bank (hanya jika Transfer dipilih)
    if (methodRadio?.value === 'transfer' && !bankRadio) {
      document.getElementById('bankGrid')?.classList.add('error-group');
      showErr('errorBank');
      if (valid) document.getElementById('bankGrid')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
      valid = false;
    } else {
      document.getElementById('bankGrid')?.classList.remove('error-group');
      hideErr('errorBank');
    }

    // 4. Validasi Bukti Upload (wajib jika Transfer)
    const hasFile = proofFile && proofFile.files.length > 0;
    if (methodRadio?.value === 'transfer' && !hasFile) {
      document.getElementById('uploadArea')?.classList.add('error-upload');
      showErr('errorProof');
      if (valid) document.getElementById('uploadArea')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
      valid = false;
    } else {
      document.getElementById('uploadArea')?.classList.remove('error-upload');
      hideErr('errorProof');
    }

    if (!valid) {
      e.preventDefault();
      showToast('Perhatian', 'Lengkapi semua field yang wajib diisi.', 'error');
    }
    // Jika valid, form dikirim secara normal ke server Laravel
  });
};

/**
 * Check if the user has fully paid and disable form if so
 * @param {object} user - Current user
 */
const checkPaidStatus = (user) => {
  const invoices = getUserInvoices(user.id);
  const activeInvoice = invoices.find((inv) => inv.status === 'belum_lunas');

  // If no unpaid invoice found, user is fully paid
  if (!activeInvoice) {
    const paidBanner = document.getElementById('paidBanner');
    const paymentFormCard = document.getElementById('paymentFormCard');
    const submitBtn = document.querySelector('button[form="paymentForm"]');

    // Show the lunas banner
    if (paidBanner) paidBanner.classList.add('visible');

    // Add disabled overlay class to the form card
    if (paymentFormCard) paymentFormCard.classList.add('payment-disabled');

    // Disable all form inputs except bank radios
    const form = document.getElementById('paymentForm');
    if (form) {
      // Disable amount input
      const amountInput = document.getElementById('paymentAmount');
      if (amountInput) {
        amountInput.disabled = true;
        amountInput.placeholder = 'Tagihan sudah lunas';
      }

      // Disable payment method radios
      const methodRadios = form.querySelectorAll('input[name="paymentMethod"]');
      methodRadios.forEach((radio) => {
        radio.disabled = true;
      });

      // Disable amount shortcuts
      const shortcuts = form.querySelectorAll('.amount-shortcut');
      shortcuts.forEach((btn) => {
        btn.disabled = true;
        btn.style.pointerEvents = 'none';
        btn.style.opacity = '0.4';
      });

      // Disable file upload
      const uploadArea = document.getElementById('uploadArea');
      const fileInput = document.getElementById('proofFile');
      if (uploadArea) {
        uploadArea.style.pointerEvents = 'none';
        uploadArea.style.opacity = '0.4';
      }
      if (fileInput) fileInput.disabled = true;

      // Bank selection stays enabled (user can still view account numbers)
      // Show bank options so they can browse account info
      const bankOptions = document.getElementById('bankOptions');
      if (bankOptions) {
        bankOptions.classList.add('visible');
        // Add a label to clarify
        const bankLabel = bankOptions.querySelector('.form-label');
        if (bankLabel) {
          bankLabel.innerHTML = 'Informasi Rekening Bank <span style="font-weight: normal; color: var(--color-text-muted);">(lihat saja)</span>';
        }
      }
    }

    // Disable submit button
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.innerHTML = '✅ Tagihan Sudah Lunas';
      submitBtn.classList.add('btn-disabled');
    }
  }
};

/**
 * Pre-fill user data in the payment form
 * @param {object} user - Current user object
 */
const prefillUserData = (user) => {
  const userIdField = document.getElementById('userId');
  const nikField = document.getElementById('userNik');
  const nameField = document.getElementById('userName');
  const packageField = document.getElementById('userPackage');

  if (userIdField) userIdField.value = user.id;
  if (nikField) nikField.value = user.nik;
  if (nameField) nameField.value = user.name;
  if (packageField) packageField.value = user.tourPackage;

  // Calculate remaining balance
  const invoices = getUserInvoices(user.id);
  const activeInvoice = invoices.find((inv) => inv.status === 'belum_lunas');
  if (activeInvoice) {
    const remaining = activeInvoice.totalAmount - activeInvoice.paidAmount;
    const remainingInfo = document.getElementById('remainingBalance');
    if (remainingInfo) {
      remainingInfo.textContent = `Sisa tagihan: ${formatCurrency(remaining)}`;
    }
  }
};

/**
 * Initialize payment method toggle (Tunai/Transfer)
 */
const initPaymentMethod = () => {
  // HTML menggunakan name="payment_method"
  const methodRadios = document.querySelectorAll('input[name="payment_method"]');
  const bankOptions = document.getElementById('bankOptions');
  const bankAccountInfo = document.getElementById('bankAccountInfo');

  methodRadios.forEach((radio) => {
    radio.addEventListener('change', (e) => {
      if (e.target.value === 'transfer') {
        bankOptions?.classList.add('visible');
      } else {
        bankOptions?.classList.remove('visible');
        bankAccountInfo?.classList.remove('visible');
        const bankRadios = document.querySelectorAll('input[name="bank"]');
        bankRadios.forEach((br) => (br.checked = false));
      }
      updatePaymentSummary();
    });
  });

  initBankSelection();
};

/**
 * Initialize bank selection to display account info
 */
const initBankSelection = () => {
  const bankRadios = document.querySelectorAll('input[name="bank"]');
  const bankAccountInfo = document.getElementById('bankAccountInfo');
  const bankInfoName = document.getElementById('bankInfoName');
  const bankInfoNumber = document.getElementById('bankInfoNumber');
  const bankInfoHolder = document.getElementById('bankInfoHolder');
  const copyBtn = document.getElementById('copyAccountNumber');

  bankRadios.forEach((radio) => {
    radio.addEventListener('change', (e) => {
      const bankKey = e.target.value;
      const bankData = BANK_ACCOUNTS[bankKey];

      if (bankData && bankAccountInfo) {
        bankInfoName.textContent = bankData.name;
        bankInfoNumber.textContent = bankData.accountNumber;
        bankInfoHolder.textContent = bankData.holder;
        bankAccountInfo.classList.add('visible');
      }

      updatePaymentSummary();
    });
  });

  // Copy button
  if (copyBtn) {
    copyBtn.addEventListener('click', () => {
      const accountNumber = bankInfoNumber?.textContent;
      if (accountNumber && accountNumber !== '-') {
        // Remove spaces/dots for clean copy
        const cleanNumber = accountNumber.replace(/\s/g, '');
        navigator.clipboard.writeText(cleanNumber).then(() => {
          copyBtn.textContent = '✅ Tersalin!';
          setTimeout(() => {
            copyBtn.textContent = '📋 Salin No. Rekening';
          }, 2000);
        }).catch(() => {
          // Fallback for older browsers
          showToast('Info', 'No. Rekening: ' + accountNumber, 'info');
        });
      }
    });
  }
};

/**
 * Initialize the amount input with formatting
 */
const initAmountInput = () => {
  const amountInput = document.getElementById('paymentAmount');
  const amountRaw   = document.getElementById('paymentAmountRaw');
  if (!amountInput) return;

  const syncRaw = () => {
    // Hapus semua karakter bukan angka untuk mendapatkan nilai murni
    const raw = amountInput.value.replace(/\D/g, '');
    if (amountRaw) amountRaw.value = raw || '';
  };

  amountInput.addEventListener('input', (e) => {
    // Ambil posisi kursor sebelum format ulang
    const cursorPos = e.target.selectionStart;
    const oldLen    = e.target.value.length;

    // Hapus non-digit lalu format ulang dengan titik ribuan
    const digits = e.target.value.replace(/\D/g, '');
    if (digits) {
      const formatted = parseInt(digits, 10).toLocaleString('id-ID');
      e.target.value  = formatted;
      // Pertahankan posisi kursor secara relatif
      const diff = formatted.length - oldLen;
      const newPos = Math.max(0, cursorPos + diff);
      e.target.setSelectionRange(newPos, newPos);
    } else {
      e.target.value = '';
    }
    syncRaw();
    updatePaymentSummary();
  });

  amountInput.addEventListener('focus', () => {
    if (amountInput.value === '0') amountInput.value = '';
  });

  amountInput.addEventListener('blur', syncRaw);
};

/**
 * Initialize quick amount shortcut buttons
 */
const initAmountShortcuts = () => {
  const shortcuts  = document.querySelectorAll('.amount-shortcut');
  const amountInput = document.getElementById('paymentAmount');
  const amountRaw   = document.getElementById('paymentAmountRaw');

  shortcuts.forEach((btn) => {
    btn.addEventListener('click', () => {
      const value = parseInt(btn.dataset.amount, 10);
      if (amountInput) {
        // Format dengan titik ribuan
        amountInput.value = value.toLocaleString('id-ID');
        // Simpan nilai murni ke hidden input
        if (amountRaw) amountRaw.value = value;
        updatePaymentSummary();
      }
    });
  });
};

/**
 * Initialize the file upload area with drag & drop
 */
const initFileUpload = () => {
  const uploadArea = document.getElementById('uploadArea');
  const fileInput = document.getElementById('proofFile');
  const previewContainer = document.getElementById('filePreview');

  if (!uploadArea || !fileInput) return;

  // Drag events
  ['dragenter', 'dragover'].forEach((event) => {
    uploadArea.addEventListener(event, (e) => {
      e.preventDefault();
      uploadArea.classList.add('drag-over');
    });
  });

  ['dragleave', 'drop'].forEach((event) => {
    uploadArea.addEventListener(event, (e) => {
      e.preventDefault();
      uploadArea.classList.remove('drag-over');
    });
  });

  uploadArea.addEventListener('drop', (e) => {
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      handleFileSelect(files[0]);
    }
  });

  fileInput.addEventListener('change', (e) => {
    if (e.target.files.length > 0) {
      handleFileSelect(e.target.files[0]);
    }
  });
};

/**
 * Handle file selection for proof upload
 * @param {File} file - Selected file
 */
/**
 * Handle file selection – preview bergaya Google Form
 * (Gambar: thumbnail; PDF: ikon; keduanya dengan status "Berhasil diupload")
 */
const handleFileSelect = (file) => {
  const previewContainer = document.getElementById('filePreview');
  const uploadArea       = document.getElementById('uploadArea');

  const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
  if (!allowedTypes.includes(file.type)) {
    showToast('Error', 'Format file tidak didukung. Gunakan JPG, PNG, atau PDF.', 'error');
    return;
  }

  if (file.size > 5 * 1024 * 1024) {
    showToast('Error', 'Ukuran file maksimal 5MB.', 'error');
    return;
  }

  const isImage = file.type.startsWith('image/');

  const renderPreview = (thumbSrc) => {
    if (!previewContainer) return;

    // Thumbnail HTML: gambar asli atau ikon PDF
    const thumbHtml = isImage
      ? `<img src="${thumbSrc}" class="file-preview-thumb" alt="Pratinjau bukti pembayaran">`
      : `<div class="file-preview-thumb-pdf">📄</div>`;

    previewContainer.innerHTML = `
      <div class="file-preview-card">
        ${thumbHtml}
        <div class="file-preview-info">
          <span class="file-preview-name">${file.name}</span>
          <span class="file-preview-size">${formatFileSize(file.size)}</span>
          <span class="file-preview-status">✅ Berhasil diupload</span>
        </div>
        <button type="button" class="file-preview-remove" id="removeFile" aria-label="Hapus file" title="Hapus file">✕</button>
      </div>
    `;

    document.getElementById('removeFile')?.addEventListener('click', () => {
      previewContainer.innerHTML = '';
      const fileInput = document.getElementById('proofFile');
      if (fileInput) fileInput.value = '';
    });
  };

  if (isImage) {
    // Baca file sebagai data URL untuk tampilkan thumbnail
    const reader = new FileReader();
    reader.onload = (e) => renderPreview(e.target.result);
    reader.readAsDataURL(file);
  } else {
    renderPreview(null);
  }
};

/**
 * Update the payment summary section
 */
const updatePaymentSummary = () => {
  const amountInput = document.getElementById('paymentAmount');
  // Selector sesuaikan dengan name HTML: payment_method
  const methodRadio = document.querySelector('input[name="payment_method"]:checked');
  const bankRadio   = document.querySelector('input[name="bank"]:checked');

  const summaryAmount = document.getElementById('summaryAmount');
  const summaryMethod = document.getElementById('summaryMethod');
  const summaryBank   = document.getElementById('summaryBank');
  const summaryTotal  = document.getElementById('summaryTotal');

  // Parse nominal dari tampilan dengan titik ribuan
  const raw    = (amountInput?.value || '').replace(/\D/g, '');
  const amount = raw ? parseInt(raw, 10) : 0;

  const method = methodRadio
    ? (methodRadio.value === 'transfer' ? 'Transfer Bank' : 'Tunai')
    : '-';

  const bankKey  = bankRadio ? bankRadio.value : null;
  const bankData = bankKey ? BANK_ACCOUNTS[bankKey] : null;
  const bankLabel = bankData ? bankData.name : '-';

  if (summaryAmount) summaryAmount.textContent = amount > 0 ? formatCurrency(amount) : '-';
  if (summaryMethod) summaryMethod.textContent = method;
  if (summaryBank)   summaryBank.textContent   = methodRadio?.value === 'transfer' ? bankLabel : '-';
  if (summaryTotal)  summaryTotal.textContent  = amount > 0 ? formatCurrency(amount) : '-';
};

/**
 * Initialize payment form submission
 */
const initPaymentForm = () => {
  const form = document.getElementById('paymentForm');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    handlePaymentSubmit();
  });
};

/**
 * Handle payment form submission
 */
const handlePaymentSubmit = () => {
  const user = getCurrentUser();
  if (!user) return;

  const amountInput = document.getElementById('paymentAmount');
  // Selector sesuaikan dengan name HTML: payment_method
  const methodRadio = document.querySelector('input[name="payment_method"]:checked');
  const proofFile   = document.getElementById('proofFile');

  // Validate amount
  const raw    = (amountInput?.value || '').replace(/\D/g, '');
  const amount = raw ? parseInt(raw, 10) : 0;
  if (amount <= 0) {
    amountInput?.classList.add('error');
    showToast('Error', 'Masukkan nominal pembayaran yang valid.', 'error');
    return;
  }
  amountInput?.classList.remove('error');

  // Validate method
  if (!methodRadio) {
    showToast('Error', 'Pilih metode pembayaran.', 'error');
    return;
  }

  // Validate bank for transfer
  if (methodRadio.value === 'transfer') {
    const bankRadio = document.querySelector('input[name="bank"]:checked');
    if (!bankRadio) {
      showToast('Error', 'Pilih bank tujuan transfer.', 'error');
      return;
    }
  }

  // Get invoice
  const invoices = getUserInvoices(user.id);
  const activeInvoice = invoices.find((inv) => inv.status === 'belum_lunas') || invoices[0];

  // Create payment object
  const bankRadio = document.querySelector('input[name="bank"]:checked');
  const bankValue = methodRadio.value === 'transfer' && bankRadio ? bankRadio.value.toUpperCase() : null;
  const payment = {
    userId: user.id,
    invoiceId: activeInvoice?.id || 'INV-NEW',
    amount: amount,
    method: methodRadio.value === 'transfer' ? 'Transfer' : 'Tunai',
    bank: bankValue,
    proof: proofFile?.files?.[0]?.name || null,
  };

  // Save payment
  const saved = addPayment(payment);

  // Show success
  showPaymentSuccess(saved, user, activeInvoice);
};

/**
 * Show payment success state
 * @param {object} payment - Saved payment object
 * @param {object} user - Current user
 * @param {object} invoice - The invoice that was paid
 */
const showPaymentSuccess = (payment, user, invoice) => {
  const formCard = document.getElementById('paymentFormCard');
  const successCard = document.getElementById('paymentSuccess');

  if (formCard) formCard.style.display = 'none';
  if (successCard) {
    successCard.classList.add('visible');

    // Populate success details
    const detailId = document.getElementById('successPaymentId');
    const detailDate = document.getElementById('successDate');
    const detailAmount = document.getElementById('successAmount');
    const detailMethod = document.getElementById('successMethod');
    const detailInvoice = document.getElementById('successInvoiceId');

    if (detailId) detailId.textContent = payment.id;
    if (detailDate) detailDate.textContent = formatDate(payment.date);
    if (detailAmount) detailAmount.textContent = formatCurrency(payment.amount);
    if (detailMethod) {
      detailMethod.textContent = payment.method === 'Transfer'
        ? `Transfer ${payment.bank}`
        : 'Tunai';
    }
    if (detailInvoice) detailInvoice.textContent = invoice?.id || '-';
  }

  // Update step indicators
  updateStepIndicator(3);

  showToast('Pembayaran Berhasil!', `Pembayaran telah ditambahkan ke invoice ${invoice?.id || ''}.`, 'success');
};

/**
 * Update the step indicator state
 * @param {number} activeStep - Current active step (1-3)
 */
const updateStepIndicator = (activeStep) => {
  const steps = document.querySelectorAll('.step-item');
  const connectors = document.querySelectorAll('.step-connector');

  steps.forEach((step, index) => {
    step.classList.remove('active', 'completed');
    if (index + 1 < activeStep) {
      step.classList.add('completed');
    } else if (index + 1 === activeStep) {
      step.classList.add('active');
    }
  });

  connectors.forEach((conn, index) => {
    conn.classList.toggle('active', index + 1 < activeStep);
  });
};
