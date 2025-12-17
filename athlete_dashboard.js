// ==================== ATHLETE BOOKINGS DATA ====================
/* const athleteBookingsData = [
    {
        id: 1,
        coachName: 'Ahmed Benali',
        discipline: 'Football',
        date: '2024-12-20',
        time: '10:00',
        duration: '1h',
        status: 'pending',
        location: 'Stade Municipal',
        price: '200 DH'
    },
    {
        id: 2,
        coachName: 'Fatima Zahra',
        discipline: 'Tennis',
        date: '2024-12-21',
        time: '14:00',
        duration: '1h',
        status: 'pending',
        location: 'Club de Tennis',
        price: '250 DH'
    },
    {
        id: 3,
        coachName: 'Ahmed Benali',
        discipline: 'Football',
        date: '2024-12-19',
        time: '16:00',
        duration: '1h',
        status: 'confirmed',
        location: 'Stade Municipal',
        price: '200 DH'
    },
    {
        id: 4,
        coachName: 'Karim El Mansouri',
        discipline: 'Natation',
        date: '2024-12-22',
        time: '11:00',
        duration: '1.5h',
        status: 'confirmed',
        location: 'Piscine Olympique',
        price: '270 DH'
    },
    {
        id: 5,
        coachName: 'Ahmed Benali',
        discipline: 'Football',
        date: '2024-12-18',
        time: '15:00',
        duration: '1h',
        status: 'completed',
        location: 'Stade Municipal',
        price: '200 DH'
    },
    {
        id: 6,
        coachName: 'Fatima Zahra',
        discipline: 'Tennis',
        date: '2024-12-17',
        time: '09:00',
        duration: '1h',
        status: 'completed',
        location: 'Club de Tennis',
        price: '250 DH'
    },
    {
        id: 7,
        coachName: 'Sara Benjelloun',
        discipline: 'Préparation Physique',
        date: '2024-12-16',
        time: '08:00',
        duration: '1h',
        status: 'completed',
        location: 'Gym Center',
        price: '200 DH'
    }
]; */

// ==================== CANCEL BOOKING ====================
function cancelBooking(bookingId) {
    const booking = athleteBookingsData.find(b => b.id === bookingId);
    
    if (!booking) return;
    
    showConfirmAlert(
        'Annuler la réservation',
        `Êtes-vous sûr de vouloir annuler votre séance avec ${booking.coachName} le ${formatDate(booking.date)} à ${booking.time} ?`,
        function() {
            showLoading();
            
            // Simulate API call
            setTimeout(() => {
                hideLoading();
                booking.status = 'cancelled';
                
                showSuccessAlert(
                    'Réservation annulée',
                    'Votre réservation a été annulée avec succès. Le coach en a été informé.'
                );
                
                // Refresh the display
                loadAthleteBookingsTable();
            }, 1000);
        }
    );
}

// ==================== VIEW BOOKING DETAILS (ATHLETE) ====================
function viewBookingDetails(bookingId) {
    const booking = athleteBookingsData.find(b => b.id === bookingId);
    
    if (!booking) return;
    
    const statusText = {
        'pending': 'En attente de confirmation',
        'confirmed': 'Confirmée',
        'cancelled': 'Annulée',
        'completed': 'Terminée'
    };
    
    const statusColor = {
        'pending': 'var(--warning)',
        'confirmed': 'var(--success)',
        'cancelled': 'var(--danger)',
        'completed': 'var(--primary-brown)'
    };
    
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Détails de la réservation',
            html: `
                <div style="text-align: left; padding: 20px;">
                    <div style="margin-bottom: 20px; padding: 15px; background-color: var(--primary-light); border-radius: 8px;">
                        <h3 style="color: var(--primary-dark); margin-bottom: 10px;">
                            <i class="fas fa-user-tie"></i> ${booking.coachName}
                        </h3>
                        <p style="color: var(--text-gray); margin-bottom: 5px;">
                            <i class="fas fa-futbol"></i> <strong>Discipline:</strong> ${booking.discipline}
                        </p>
                        <p style="color: var(--text-gray); margin-bottom: 5px;">
                            <i class="fas fa-calendar"></i> <strong>Date:</strong> ${formatDate(booking.date)}
                        </p>
                        <p style="color: var(--text-gray); margin-bottom: 5px;">
                            <i class="fas fa-clock"></i> <strong>Heure:</strong> ${booking.time}
                        </p>
                        <p style="color: var(--text-gray); margin-bottom: 5px;">
                            <i class="fas fa-hourglass-half"></i> <strong>Durée:</strong> ${booking.duration}
                        </p>
                        <p style="color: var(--text-gray); margin-bottom: 5px;">
                            <i class="fas fa-map-marker-alt"></i> <strong>Lieu:</strong> ${booking.location}
                        </p>
                        <p style="color: var(--text-gray); margin-bottom: 5px;">
                            <i class="fas fa-tag"></i> <strong>Prix:</strong> ${booking.price}
                        </p>
                        <p style="margin-top: 15px;">
                            <strong>Statut:</strong> 
                            <span style="color: ${statusColor[booking.status]}; font-weight: bold;">
                                ${statusText[booking.status]}
                            </span>
                        </p>
                    </div>
                    ${booking.status === 'pending' || booking.status === 'confirmed' ? `
                        <div style="margin-top: 20px;">
                            <button onclick="cancelBooking(${booking.id}); Swal.close();" 
                                    style="width: 100%; padding: 12px; background-color: var(--danger); color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer;">
                                <i class="fas fa-times"></i> Annuler cette réservation
                            </button>
                        </div>
                    ` : ''}
                </div>
            `,
            confirmButtonColor: '#FEBA17',
            confirmButtonText: 'Fermer',
            showConfirmButton: true
        });
    }
}

// ==================== LOAD ATHLETE BOOKINGS TABLE ====================
function loadAthleteBookingsTable() {
    const table = document.getElementById('allBookingsTable');
    
    if (!table) return;
    
    table.innerHTML = '';
    
    athleteBookingsData.forEach(booking => {
        const statusBadge = {
            'pending': '<span class="status-badge pending">En attente</span>',
            'confirmed': '<span class="status-badge confirmed">Confirmée</span>',
            'cancelled': '<span class="status-badge cancelled">Annulée</span>',
            'completed': '<span class="status-badge confirmed">Terminée</span>'
        };
        
        const actions = (booking.status === 'pending' || booking.status === 'confirmed')
            ? `
                <div class="action-buttons">
                    <button class="btn-view" onclick="viewBookingDetails(${booking.id})">Détails</button>
                    <button class="btn-reject" onclick="cancelBooking(${booking.id})">Annuler</button>
                </div>
            `
            : `<button class="btn-view" onclick="viewBookingDetails(${booking.id})">Détails</button>`;
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>#${booking.id}</td>
            <td><strong>${booking.coachName}</strong></td>
            <td>${booking.discipline}</td>
            <td>${formatDate(booking.date)}, ${booking.time}</td>
            <td>${booking.duration}</td>
            <td>${statusBadge[booking.status]}</td>
            <td>${actions}</td>
        `;
        
        table.appendChild(row);
    });
}

// ==================== VIEW COACH PROFILE (FROM ATHLETE SPACE) ====================
function viewCoachProfile(coachId) {
    // Redirect to coaches page or open modal
    window.location.href = 'coaches.html';
}

// ==================== BOOK SESSION (FROM ATHLETE SPACE) ====================
function bookSession(coachId) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Réserver une séance',
            html: `
                <div style="text-align: left;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Date</label>
                        <input type="date" id="bookingDate" class="swal2-input" style="width: 100%; margin: 0;" min="${new Date().toISOString().split('T')[0]}">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Heure</label>
                        <select id="bookingTime" class="swal2-input" style="width: 100%; margin: 0;">
                            <option value="">Sélectionnez une heure</option>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                            <option value="18:00">18:00</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Durée</label>
                        <select id="bookingDuration" class="swal2-input" style="width: 100%; margin: 0;">
                            <option value="1h">1 heure</option>
                            <option value="1.5h">1.5 heures</option>
                            <option value="2h">2 heures</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Notes (optionnel)</label>
                        <textarea id="bookingNotes" class="swal2-input" style="width: 100%; margin: 0; height: 80px;" placeholder="Objectifs de la séance, besoins spécifiques..."></textarea>
                    </div>
                </div>
            `,
            confirmButtonText: 'Réserver',
            confirmButtonColor: '#FEBA17',
            showCancelButton: true,
            cancelButtonText: 'Annuler',
            preConfirm: () => {
                const date = document.getElementById('bookingDate').value;
                const time = document.getElementById('bookingTime').value;
                const duration = document.getElementById('bookingDuration').value;
                const notes = document.getElementById('bookingNotes').value;
                
                if (!date || !time) {
                    Swal.showValidationMessage('Veuillez sélectionner une date et une heure');
                    return false;
                }
                
                return { date, time, duration, notes };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                setTimeout(() => {
                    hideLoading();
                    showSuccessAlert(
                        'Réservation envoyée',
                        'Votre demande de réservation a été envoyée au coach. Vous recevrez une confirmation par email.'
                    );
                    
                    // Refresh bookings
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }, 1000);
            }
        });
    }
}

// ==================== PROFILE FORM HANDLING (ATHLETE) ====================
document.addEventListener('DOMContentLoaded', function() {
    const athleteProfileForm = document.getElementById('athleteProfileForm');
    
    if (athleteProfileForm) {
        athleteProfileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            showConfirmAlert(
                'Enregistrer les modifications',
                'Êtes-vous sûr de vouloir enregistrer les modifications de votre profil ?',
                function() {
                    showLoading();
                    
                    // Simulate API call
                    setTimeout(() => {
                        hideLoading();
                        showSuccessAlert(
                            'Profil mis à jour',
                            'Vos informations ont été mises à jour avec succès.'
                        );
                    }, 1000);
                }
            );
        });
    }
    
    // Load bookings table on page load
    loadAthleteBookingsTable();
});