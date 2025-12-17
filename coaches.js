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
        const coachName = card.querySelector('.coach-name').textContent.toLowerCase();
        const coachSport = card.getAttribute('data-sport').toLowerCase();
        const coachSpecialty = card.querySelector('.coach-specialty').textContent.toLowerCase();
        
        // Vérifier si correspond à la recherche
        const matchesSearch = coachName.indexOf(searchInput) !== -1 || coachSpecialty.indexOf(searchInput) !== -1;
        const matchesSport = !sportFilter || coachSport === sportFilter;
        
        // Afficher ou cacher la card
        if (matchesSearch && matchesSport) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    }
    
    // Afficher ou cacher le message "Aucun résultat"
    if (visibleCount === 0) {
        noResultsMessage.style.display = 'block';
    } else {
        noResultsMessage.style.display = 'none';
    }
}

// ==================== VIEW COACH PROFILE (Copier contenu caché vers modal) ====================
function viewCoachProfile(coachId) {
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

// ==================== BOOK SESSION (Redirection vers login) ====================
function bookSession(coachId) {
    showConfirmAlert(
        'Réserver une séance',
        'Connectez-vous pour réserver une séance avec ce coach',
        function() {
            window.location.href = 'login.php';
        }
    );
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