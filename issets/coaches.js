// ==========================================
// BOOKING SYSTEM - VERY BEGINNER FRIENDLY
// ==========================================

// Function to open the booking modal when user clicks "Réserver"
function bookSessionModal(coachId) {
    // Create the modal HTML
    const modalHTML = `
        <div class="modal" id="bookingModal" style="display: flex;">
            <div class="modal-content" style="max-width: 600px;">
                <div class="modal-header">
                    <h3><i class="fas fa-calendar-plus"></i> Réserver une séance</h3>
                    <button class="close-modal" onclick="closeBookingModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="bookingForm" method="POST" action="create_reservation.php">
                    <!-- Hidden input to send coach ID -->
                    <input type="hidden" name="coach_id" value="${coachId}">

                    <!-- Date Selection -->
                    <div class="form-group">
                        <label><i class="fas fa-calendar"></i> Date de la séance</label>
                        <input type="date"
                               name="date_seance"
                               id="date_seance"
                               class="form-control"
                               min="${getTodayDate()}"
                               required>
                        <small style="color: var(--text-gray); display: block; margin-top: 5px;">
                            Choisissez une date à partir d'aujourd'hui
                        </small>
                    </div>

                    <!-- Time Selection -->
                    <div class="form-group">
                        <label><i class="fas fa-clock"></i> Heure de début</label>
                        <input type="time"
                               name="heure_debut"
                               id="heure_debut"
                               class="form-control"
                               required>
                        <small style="color: var(--text-gray); display: block; margin-top: 5px;">
                            Exemple: 14:00 pour 2h de l'après-midi
                        </small>
                    </div>

                    <!-- Duration Selection -->
                    <div class="form-group">
                        <label><i class="fas fa-hourglass-half"></i> Durée de la séance</label>
                        <select name="duree" id="duree" class="form-control" required>
                            <option value="">Sélectionnez la durée</option>
                            <option value="0.5">30 minutes</option>
                            <option value="1">1 heure</option>
                            <option value="1.5">1 heure 30 minutes</option>
                            <option value="2">2 heures</option>
                            <option value="2.5">2 heures 30 minutes</option>
                            <option value="3">3 heures</option>
                        </select>
                    </div>

                    <!-- Discipline Selection (Optional) -->
                    <div class="form-group">
                        <label><i class="fas fa-running"></i> Discipline (optionnel)</label>
                        <select name="discipline_id" id="discipline_id" class="form-control">
                            <option value="">Choisissez une discipline</option>
                            ${getDisciplineOptions(coachId)}
                        </select>
                    </div>

                    <!-- Submit Button (simple) -->
                    <button type="submit"
                            class="btn-submit"
                            style="width: 100%;">
                        <i class="fas fa-check"></i> Réserver
                    </button>
                </form>
            </div>
        </div>
    `;

    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modalHTML);
}

// Function to get today's date in YYYY-MM-DD format
function getTodayDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// Function to get coach's disciplines (simplified version)
function getDisciplineOptions(coachId) {
    // This is a simplified version. In real app, you'd fetch from database
    // For now, returning common sports
    return `
        <option value="1">Football</option>
        <option value="2">Tennis</option>
        <option value="3">Natation</option>
        <option value="4">Boxe</option>
        <option value="5">Préparation physique</option>
    `;
}

// Function to close booking modal
function closeBookingModal() {
    const modal = document.getElementById('bookingModal');
    if (modal) {
        modal.remove();
    }
}

// Function to view coach profile
function viewCoachProfileModal(coachId) {
    const contentDiv = document.getElementById('coachModalContent' + coachId);
    const modalContent = contentDiv.innerHTML;

    const modalHTML = `
        <div class="modal" id="coachModal" style="display: flex;">
            <div class="modal-content" style="max-width: 700px;">
                <div class="modal-header">
                    <h3>Profil du Coach</h3>
                    <button class="close-modal" onclick="closeModal('coachModal')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="modalContent">
                    ${modalContent}
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);
}

// Function to close modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.remove();
    }
}

// Function to filter coaches (search functionality)
function filterCoaches() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const sportFilter = document.getElementById('sportFilter').value.toLowerCase();

    const coachCards = document.querySelectorAll('.coach-card');
    let visibleCount = 0;

    coachCards.forEach(card => {
        const coachName = card.querySelector('.coach-name').textContent.toLowerCase();
        const coachSpecialty = card.querySelector('.coach-specialty').textContent.toLowerCase();

        const matchesSearch = coachName.includes(searchInput);
        const matchesSport = sportFilter === '' || coachSpecialty.includes(sportFilter);

        if (matchesSearch && matchesSport) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const noResultsMsg = document.getElementById('noResultsMessage');
    if (visibleCount === 0) {
        noResultsMsg.style.display = 'block';
    } else {
        noResultsMsg.style.display = 'none';
    }
}
