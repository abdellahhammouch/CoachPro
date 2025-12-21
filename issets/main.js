// ==================== MOBILE MENU ====================
document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');

    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function () {
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

// ==================== SHOW/HIDE SECTIONS ====================
function showSection(sectionName) {
    // Hide all sections
    var sections = document.querySelectorAll('.dashboard-section');
    for (var i = 0; i < sections.length; i++) {
        sections[i].style.display = 'none';
    }

    // Show the section you clicked
    var targetSection = document.getElementById(sectionName + 'Section');
    if (targetSection) {
        targetSection.style.display = 'block';
    }

    // Remove active from all sidebar links
    var links = document.querySelectorAll('.sidebar-link');
    for (var j = 0; j < links.length; j++) {
        links[j].classList.remove('active');
    }

    // Add active to clicked link (safe: event may not exist)
    var ev = (typeof event !== 'undefined') ? event : null;
    var clicked = ev && ev.currentTarget ? ev.currentTarget : null;
    if (clicked && clicked.classList) {
        clicked.classList.add('active');
    }

    // Scroll to top
    window.scrollTo(0, 0);
}


// ==================== MODAL FUNCTIONS ====================
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
    }
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// ==================== AUTO HIDE MESSAGES ====================
window.addEventListener('DOMContentLoaded', function() {
    var successMsg = document.querySelector('[style*="background: #d1fae5"]');
    var errorMsg = document.querySelector('[style*="background: #fee2e2"]');
    
    if (successMsg) {
        setTimeout(function() {
            successMsg.style.display = 'none';
        }, 5000);
    }
    
    if (errorMsg) {
        setTimeout(function() {
            errorMsg.style.display = 'none';
        }, 5000);
    }

    // --------------------
    // COACH PHOTO PREVIEW (SIMPLE)
    // --------------------
    var coachPhotoInput = document.getElementById('coachPhotoInput');
    var coachPhotoPreview = document.getElementById('coachPhotoPreview');

    if (coachPhotoInput && coachPhotoPreview) {
        coachPhotoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var url = URL.createObjectURL(this.files[0]);
                coachPhotoPreview.src = url;
            }
        });
    }
});