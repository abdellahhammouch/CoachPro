// ==================== CANCEL BOOKING ====================
function cancelBooking(bookingId) {
    showConfirmAlert(
        'Annuler la réservation',
        'Êtes-vous sûr de vouloir annuler cette réservation ?',
        function() {
            const form = document.getElementById('cancelForm' + bookingId);
            if (form) {
                form.submit();
            }
        }
    );
}

// ==================== VIEW BOOKING DETAILS ====================
function viewBookingDetails(bookingId) {
    const detailsDiv = document.getElementById('bookingDetails' + bookingId);
    if (detailsDiv) {
        document.getElementById('modalContent').innerHTML = detailsDiv.innerHTML;
        openModal('bookingModal');
    }
}

// ==================== VIEW COACH PROFILE ====================
function viewCoachProfile(coachId) {
    window.location.href = 'coaches.php';
}

// ==================== BOOK SESSION ====================
function bookSession(coachId) {
    openModal('bookingModal' + coachId);
}

// ==================== PROFILE FORM ====================
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('athleteProfileForm');
    
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {

            var prenom = profileForm.querySelector('input[name="prenom"]');
            var nom = profileForm.querySelector('input[name="nom"]');
            var email = profileForm.querySelector('input[name="email"]');
            var phone = profileForm.querySelector('input[name="phone"]');
            
            var formIsValid = true;
            
            var existingErrors = profileForm.querySelectorAll('.form-error-message');
            for (var i = 0; i < existingErrors.length; i++) {
                existingErrors[i].remove();
            }
            
            if (prenom && prenom.value.trim() === '') {
                e.preventDefault();
                showFieldError(prenom, 'Veuillez entrer un prénom valide(pas de chiffres,min 2 caractères)');
                formIsValid = false;
            }
            
            if (nom && nom.value.trim() === '') {
                e.preventDefault();
                showFieldError(nom, 'Veuillez entrer un nom valide(pas de chiffres,min 2 caractères)');
                formIsValid = false;
            }
            
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (email && (email.value.trim() === '' || !emailRegex.test(email.value))) {
                e.preventDefault();
                showFieldError(email, 'Veuillez entrer un email valide');
                formIsValid = false;
            }
            
            if (phone && phone.value.trim() === '') {
                e.preventDefault();
                showFieldError(phone, 'Veuillez entrer un numero de telephone valide');
                formIsValid = false;
            }
            
            if (!formIsValid) {
                e.preventDefault();
            }
        });
    }
});

// ==================== SHOW FIELD ERROR ====================
function showFieldError(inputElement, message) {
    var errorDiv = document.createElement('div');
    errorDiv.className = 'form-error-message';
    errorDiv.style.cssText = 'color: #dc2626; font-size: 13px; margin-top: 5px; padding: 8px; background: #fee2e2; border-radius: 5px; border-left: 3px solid #dc2626;';
    errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + message;
    
    inputElement.style.borderColor = '#dc2626';
    
    var parent = inputElement.closest('.form-group');
    if (parent) {
        parent.appendChild(errorDiv);
    }
    
    inputElement.addEventListener('input', function() {
        this.style.borderColor = '#e5e5e5';
        var errorMsg = this.closest('.form-group').querySelector('.form-error-message');
        if (errorMsg) {
            errorMsg.remove();
        }
    });
}