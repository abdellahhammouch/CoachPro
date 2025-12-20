// ==================== FILTER COACHES (Afficher/Cacher) ====================
function filterCoaches() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const sportFilter = document.getElementById('sportFilter').value.toLowerCase();
    const coachCards = document.querySelectorAll('.coach-card');
    const noResultsMessage = document.getElementById('noResultsMessage');
    
    let visibleCount = 0;
    
    // Parcourir toutes les cards
    for (let i = 0; i < coachCards.length; i++) {
        const card = coachCards[i];
        const coachName = card.querySelector('.coach-name');
        const coachSport = card.getAttribute('data-sport');
        const coachSpecialty = card.querySelector('.coach-specialty');
        
        // Check if elements exist before accessing textContent
        if (!coachName || !coachSpecialty) continue;
        
        const nameText = coachName.textContent.toLowerCase();
        const specialtyText = coachSpecialty.textContent.toLowerCase();
        const sportValue = coachSport ? coachSport.toLowerCase() : '';
        
        // Vérifier si correspond à la recherche
        const matchesSearch = nameText.indexOf(searchInput) !== -1 || specialtyText.indexOf(searchInput) !== -1;
        const matchesSport = !sportFilter || sportValue === sportFilter;
        
        // Afficher ou cacher la card
        if (matchesSearch && matchesSport) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    }
    
    // Afficher ou cacher le message "Aucun résultat"
    if (noResultsMessage) {
        if (visibleCount === 0) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    }
}

// ==================== VIEW COACH PROFILE (For Dashboard Modal) ====================
function viewCoachProfileModal(coachId) {
    // Récupérer le contenu caché du coach
    const hiddenContent = document.getElementById('coachModalContent' + coachId);
    const modalContent = document.getElementById('modalContent');
    
    if (hiddenContent && modalContent) {
        // Copier le contenu
        modalContent.innerHTML = hiddenContent.innerHTML;
        // Afficher le modal
        openModal('coachModal');
    }
}

// ==================== BOOK SESSION (For Dashboard) ====================
function bookSessionModal(coachId) {
    showConfirmAlert(
        'Réserver une séance',
        'Voulez-vous réserver une séance avec ce coach ?',
        function() {
            // Here you would normally open a booking form or redirect
            showSuccessAlert(
                'Demande envoyée',
                'Votre demande de réservation a été envoyée au coach. Vous recevrez une confirmation bientôt.'
            );
        }
    );
}

// ==================== LEGACY FUNCTIONS (For standalone coaches.php if still used) ====================
function viewCoachProfile(coachId) {
    viewCoachProfileModal(coachId);
}

function bookSession(coachId) {
    bookSessionModal(coachId);
}

// ==================== INITIALIZE (Événements sur filtres) ====================
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const sportFilter = document.getElementById('sportFilter');
    
    // Filtrer quand on tape dans le champ recherche
    if (searchInput) {
        searchInput.addEventListener('input', filterCoaches);
    }
    
    // Filtrer quand on change le sport
    if (sportFilter) {
        sportFilter.addEventListener('change', filterCoaches);
    }
});