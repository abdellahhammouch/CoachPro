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
function viewCoachProfile(coachId) { ///////////////////
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
            e.preventDefault();
            
            showConfirmAlert(
                'Enregistrer les modifications',
                'Êtes-vous sûr de vouloir enregistrer les modifications ?',
                function() {
                    profileForm.submit();
                }
            );
        });
    }
});