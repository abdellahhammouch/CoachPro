// ==================== MOBILE MENU ====================
document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');

    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function () {
            // Afficher ou cacher le menu
            if (navMenu.style.display === 'flex') {
                navMenu.style.display = 'none';
            } else {
                navMenu.style.display = 'flex';
            }
        });
    }
});

// ==================== NAVBAR SCROLL EFFECT ====================
window.addEventListener('scroll', function () {
    const navbar = document.getElementById('navbar');
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
});

// ==================== MODAL FUNCTIONS ====================
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Fermer modal en cliquant à l'extérieur
window.addEventListener('click', function (event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
});

// ==================== DASHBOARD SECTION NAVIGATION ====================
function showSection(sectionName) {
    // Cacher toutes les sections
    const sections = document.querySelectorAll('.dashboard-section');
    for (let i = 0; i < sections.length; i++) {
        sections[i].style.display = 'none';
    }

    // Afficher la section sélectionnée
    const targetSection = document.getElementById(sectionName + 'Section');
    if (targetSection) {
        targetSection.style.display = 'block';
    }

    // Retirer active de tous les liens
    const links = document.querySelectorAll('.sidebar-link');
    for (let i = 0; i < links.length; i++) {
        links[i].classList.remove('active');
    }

    // Ajouter active au lien cliqué
    event.target.closest('.sidebar-link').classList.add('active');

    // Scroll en haut
    window.scrollTo(0, 0);
}

// ==================== FORM VALIDATION ====================
function validateEmail(email) {
    const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return re.test(email);
}

function validatePhone(phone) {
    const re = /^(\+212|0)[5-7][0-9]{8}$/;
    return re.test(phone);
}

function validatePassword(password) {
    const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    return re.test(password);
}

function validateName(name) {
    const re = /^[a-zA-ZÀ-ÿ\s]{2,}$/;
    return re.test(name);
}

function showError(fieldId, errorId) {
    const field = document.getElementById(fieldId);
    const error = document.getElementById(errorId);

    if (field && error) {
        field.classList.add('error');
        error.style.display = 'block';
    }
}

function hideError(fieldId, errorId) {
    const field = document.getElementById(fieldId);
    const error = document.getElementById(errorId);

    if (field && error) {
        field.classList.remove('error');
        error.style.display = 'none';
    }
}

// ==================== SWEETALERT FUNCTIONS ====================
function showSuccessAlert(title, text) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: title,
            text: text,
            confirmButtonColor: '#FEBA17'
        });
    } else {
        alert(title + '\n' + text);
    }
}

function showErrorAlert(title, text) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            confirmButtonColor: '#FEBA17'
        });
    } else {
        alert(title + '\n' + text);
    }
}

function showConfirmAlert(title, text, confirmCallback) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FEBA17',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui',
            cancelButtonText: 'Annuler'
        }).then(function (result) {
            if (result.isConfirmed && confirmCallback) {
                confirmCallback();
            }
        });
    } else {
        if (confirm(title + '\n' + text)) {
            if (confirmCallback) {
                confirmCallback();
            }
        }
    }
}

// ==================== LOADING INDICATOR ====================

function showLoading() {
    let loading = document.getElementById('loadingOverlay');
    if (!loading) {
        loading = document.createElement('div');
        loading.id = 'loadingOverlay';
        loading.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: flex; align-items: center; justify-content: center; z-index: 9999;';
        loading.innerHTML = '<div style="text-align: center; color: white;"><i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #FEBA17;"></i><p style="margin-top: 20px; font-size: 18px;">Chargement...</p></div>';
        document.body.appendChild(loading);
    }
    loading.style.display = 'flex';
}

function hideLoading() {
    const loading = document.getElementById('loadingOverlay');
    if (loading) {
        loading.style.display = 'none';
    }
}

// ==================== PREVENT DOUBLE SUBMIT ====================
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');
    for (let i = 0; i < forms.length; i++) {
        forms[i].addEventListener('submit', function () {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                setTimeout(function () {
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    }
});

const select = document.getElementById("discipline");

  select.addEventListener("change", () => {
    const values = [...select.selectedOptions].map(o => o.value);
  });