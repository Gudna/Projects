/*
 * File: assets/js/main.js
 * Consolidated JavaScript for Vehicle Insurance Management System
 * Source: FProjects 1, 2, 3, 4
 * Contains: Common functions, utilities, modal handling, validation
 */

// ===== NAMESPACE FOR BACKWARD COMPATIBILITY =====
window.Legacy = {};

// ===== MONEY FORMATTING =====
/**
 * Format number as Vietnamese Dong currency
 * @param {number} amount - Amount in VND
 * @returns {string} Formatted currency string
 */
function formatMoney(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

window.Legacy.formatMoney = formatMoney;

// ===== DATE FORMATTING =====
/**
 * Format date as DD/MM/YYYY
 * @param {string} dateString - Date string (YYYY-MM-DD)
 * @returns {string} Formatted date DD/MM/YYYY
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

window.Legacy.formatDate = formatDate;

// ===== CONFIRMATION DIALOGS =====
/**
 * Show confirmation dialog for delete action
 * @param {string} message - Message to display
 * @returns {boolean} True if confirmed, false otherwise
 */
function confirmDelete(message = "Bạn có chắc chắn muốn xóa?") {
    return confirm(message);
}

window.Legacy.confirmDelete = confirmDelete;

// ===== MODAL FUNCTIONS =====
/**
 * Open modal by ID
 * @param {string} modalId - Modal element ID
 */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
    }
}

window.Legacy.openModal = openModal;

/**
 * Close modal by ID
 * @param {string} modalId - Modal element ID
 */
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
    }
}

window.Legacy.closeModal = closeModal;

/**
 * Close modal when clicking outside
 */
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
};

// ===== TABLE SEARCH & FILTERING =====
/**
 * Initialize table search (FProjects/3 pattern)
 * Searches table by keyword with debounce
 */
function initSearch() {
    const searchInput = document.getElementById('search');
    if (!searchInput) return;

    const table = document.getElementById('customerTable') || document.querySelector('table');
    if (!table) return;

    const rows = table.querySelectorAll("tbody tr");

    function filterTable() {
        const keyword = searchInput.value.toLowerCase();
        rows.forEach(row => {
            let found = false;
            for (let i = 0; i < row.cells.length; i++) {
                if (row.cells[i].textContent.toLowerCase().includes(keyword)) {
                    found = true;
                    break;
                }
            }
            row.style.display = found ? "" : "none";
        });
    }

    searchInput.addEventListener('input', debounce(filterTable, 300));
}

window.Legacy.initSearch = initSearch;

// ===== DEBOUNCE UTILITY =====
/**
 * Debounce function to limit function calls
 * @param {function} func - Function to debounce
 * @param {number} wait - Wait time in milliseconds
 * @returns {function} Debounced function
 */
function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(context, args);
        }, wait);
    };
}

window.Legacy.debounce = debounce;

// ===== DATE PICKER INITIALIZATION =====
/**
 * Initialize date pickers (FProjects/1 pattern)
 */
function initDatePickers() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        // HTML5 date input already provides date picker in modern browsers
        // Additional initialization can be done here if needed
        input.addEventListener('change', function() {
            // Validate date if needed
            if (this.value && !isValidDate(this.value)) {
                alert('Ngày không hợp lệ');
                this.value = '';
            }
        });
    });
}

window.Legacy.initDatePickers = initDatePickers;

/**
 * Validate date format YYYY-MM-DD
 * @param {string} dateString - Date string to validate
 * @returns {boolean} True if valid, false otherwise
 */
function isValidDate(dateString) {
    const regex = /^\d{4}-\d{2}-\d{2}$/;
    if (!regex.test(dateString)) return false;
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

window.Legacy.isValidDate = isValidDate;

// ===== FORM VALIDATION =====
/**
 * Initialize form validation (FProjects/1 pattern)
 */
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
}

window.Legacy.initFormValidation = initFormValidation;

/**
 * Validate form fields
 * @param {HTMLFormElement} form - Form to validate
 * @returns {boolean} True if valid, false otherwise
 */
function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');

    inputs.forEach(input => {
        if (input.type === 'email') {
            if (!isValidEmail(input.value)) {
                input.style.borderColor = 'var(--danger)';
                isValid = false;
            } else {
                input.style.borderColor = '';
            }
        } else if (input.value.trim() === '') {
            input.style.borderColor = 'var(--danger)';
            isValid = false;
        } else {
            input.style.borderColor = '';
        }
    });

    return isValid;
}

window.Legacy.validateForm = validateForm;

/**
 * Validate email format
 * @param {string} email - Email to validate
 * @returns {boolean} True if valid email, false otherwise
 */
function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

window.Legacy.isValidEmail = isValidEmail;

// ===== TOOLTIP INITIALIZATION =====
/**
 * Initialize tooltips (FProjects/1 pattern)
 */
function initTooltips() {
    const tooltips = document.querySelectorAll('[title]');
    tooltips.forEach(el => {
        el.addEventListener('mouseenter', showTooltip.bind(el));
        el.addEventListener('mouseleave', hideTooltip);
    });
}

window.Legacy.initTooltips = initTooltips;

/**
 * Show tooltip
 */
function showTooltip() {
    const tooltipText = this.getAttribute('title');
    const tooltipEl = document.createElement('div');
    tooltipEl.className = 'custom-tooltip';
    tooltipEl.textContent = tooltipText;
    tooltipEl.style.cssText = `
        position: fixed;
        background: var(--dark);
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 10000;
        white-space: nowrap;
        box-shadow: var(--shadow);
    `;
    document.body.appendChild(tooltipEl);

    const rect = this.getBoundingClientRect();
    tooltipEl.style.left = rect.left + 'px';
    tooltipEl.style.top = (rect.top - tooltipEl.offsetHeight - 10) + 'px';

    this.removeAttribute('title');
    this.setAttribute('data-original-title', tooltipText);
    this._tooltipEl = tooltipEl;
}

/**
 * Hide tooltip
 */
function hideTooltip() {
    const tooltipEl = document.querySelector('.custom-tooltip');
    if (tooltipEl) {
        tooltipEl.remove();
    }
}

window.Legacy.hideTooltip = hideTooltip;

// ===== DOCUMENT READY INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all features on page load
    initTooltips();
    initFormValidation();
    initSearch();
    initDatePickers();

    // Log successful initialization
    console.log('Vehicle Insurance System JS initialized');
});

// ===== UTILITY FUNCTIONS =====
/**
 * Show alert notification
 * @param {string} message - Message to display
 * @param {string} type - Alert type: success, error, warning, info
 * @param {number} duration - Duration in milliseconds (0 = permanent)
 */
function showAlert(message, type = 'info', duration = 5000) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    alertDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        max-width: 400px;
        z-index: 10001;
    `;
    document.body.appendChild(alertDiv);

    if (duration > 0) {
        setTimeout(() => {
            alertDiv.remove();
        }, duration);
    }
}

window.Legacy.showAlert = showAlert;

/**
 * Format phone number
 * @param {string} phone - Phone number
 * @returns {string} Formatted phone number
 */
function formatPhone(phone) {
    const digits = phone.replace(/\D/g, '');
    if (digits.length === 10) {
        return digits.slice(0, 3) + '-' + digits.slice(3, 6) + '-' + digits.slice(6);
    }
    return phone;
}

window.Legacy.formatPhone = formatPhone;

/**
 * Get URL parameter value
 * @param {string} paramName - Parameter name
 * @returns {string|null} Parameter value or null if not found
 */
function getURLParameter(paramName) {
    const params = new URLSearchParams(window.location.search);
    return params.get(paramName);
}

window.Legacy.getURLParameter = getURLParameter;

/**
 * Redirect to URL
 * @param {string} url - URL to redirect to
 * @param {number} delay - Delay in milliseconds before redirect
 */
function redirect(url, delay = 0) {
    if (delay > 0) {
        setTimeout(() => {
            window.location.href = url;
        }, delay);
    } else {
        window.location.href = url;
    }
}

window.Legacy.redirect = redirect;

/**
 * Make AJAX request
 * @param {string} url - URL to fetch
 * @param {object} options - Fetch options (method, body, headers, etc)
 * @returns {Promise} Promise with response JSON
 */
async function ajaxRequest(url, options = {}) {
    const defaultOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    };

    const mergedOptions = { ...defaultOptions, ...options };

    try {
        const response = await fetch(url, mergedOptions);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error('AJAX Request Error:', error);
        throw error;
    }
}

window.Legacy.ajaxRequest = ajaxRequest;

console.log('Vehicle Insurance Management System JS Library Loaded');
