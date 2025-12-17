// ==================== BOOKINGS DATA ====================
const bookingsData = [
    {
        id: 1,
        athleteName: 'Amine Alaoui',
        discipline: 'Football',
        date: '2024-12-20',
        time: '10:00',
        duration: '1h',
        status: 'pending',
        location: 'Stade Municipal'
    },
    {
        id: 2,
        athleteName: 'Sara Bennani',
        discipline: 'Football',
        date: '2024-12-21',
        time: '14:00',
        duration: '1h',
        status: 'pending',
        location: 'Stade Municipal'
    },
    {
        id: 3,
        athleteName: 'Karim Fassi',
        discipline: 'Football',
        date: '2024-12-19',
        time: '16:00',
        duration: '1h',
        status: 'confirmed',
        location: 'Stade Municipal'
    },
    {
        id: 4,
        athleteName: 'Leila Amrani',
        discipline: 'Football',
        date: '2024-12-22',
        time: '11:00',
        duration: '1.5h',
        status: 'confirmed',
        location: 'Centre Sportif'
    },
    {
        id: 5,
        athleteName: 'Hassan Zaki',
        discipline: 'Football',
        date: '2024-12-18',
        time: '15:00',
        duration: '1h',
        status: 'completed',
        location: 'Stade Municipal'
    },
    {
        id: 6,
        athleteName: 'Nadia El Fassi',
        discipline: 'Football',
        date: '2024-12-23',
        time: '09:00',
        duration: '1h',
        status: 'pending',
        location: 'Complexe Sportif'
    }
];

// ==================== HANDLE BOOKING ====================
function handleBooking(action, bookingId) {
    const booking = bookingsData.find(b => b.id === bookingId);
    
    if (!booking) return;
    
    const actionText = action === 'accept' ? 'accepter' : 'refuser';
    const actionTitle = action === 'accept' ? 'Accepter la réservation' : 'Refuser la réservation';
    
    showConfirmAlert(
        actionTitle,
        `Êtes-vous sûr de vouloir ${actionText} la réservation de ${booking.athleteName} le ${formatDate(booking.date)} à ${booking.time} ?`,
        function() {
            showLoading();
            
            // Simulate API call
            setTimeout(() => {
                hideLoading();
                
                if (action === 'accept') {
                    booking.status = 'confirmed';
                    showSuccessAlert(
                        'Réservation acceptée',
                        'La réservation a été confirmée avec succès. Un email de confirmation a été envoyé au sportif.'
                    );
                } else {
                    booking.status = 'cancelled';
                    showSuccessAlert(
                        'Réservation refusée',
                        'La réservation a été refusée. Le sportif en a été informé par email.'
                    );
                }
                
                // Refresh the display
                loadBookingsTable();
            }, 1000);
        }
    );
}

// ==================== VIEW BOOKING DETAILS ====================
function viewBookingDetails(bookingId) {
    const booking = bookingsData.find(b => b.id === bookingId);
    
    if (!booking) return;
    
    const statusText = {
        'pending': 'En attente',
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
                            <i class="fas fa-user"></i> ${booking.athleteName}
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
                        <p style="margin-top: 15px;">
                            <strong>Statut:</strong> 
                            <span style="color: ${statusColor[booking.status]}; font-weight: bold;">
                                ${statusText[booking.status]}
                            </span>
                        </p>
                    </div>
                </div>
            `,
            confirmButtonColor: '#FEBA17',
            confirmButtonText: 'Fermer'
        });
    }
}

// ==================== LOAD BOOKINGS TABLE ====================
function loadBookingsTable() {
    const table = document.getElementById('bookingsTable');
    
    if (!table) return;
    
    table.innerHTML = '';
    
    bookingsData.forEach(booking => {
        const statusBadge = {
            'pending': '<span class="status-badge pending">En attente</span>',
            'confirmed': '<span class="status-badge confirmed">Confirmée</span>',
            'cancelled': '<span class="status-badge cancelled">Annulée</span>',
            'completed': '<span class="status-badge confirmed">Terminée</span>'
        };
        
        const actions = booking.status === 'pending' 
            ? `
                <div class="action-buttons">
                    <button class="btn-accept" onclick="handleBooking('accept', ${booking.id})">Accepter</button>
                    <button class="btn-reject" onclick="handleBooking('reject', ${booking.id})">Refuser</button>
                </div>
            `
            : `<button class="btn-view" onclick="viewBookingDetails(${booking.id})">Détails</button>`;
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>#${booking.id}</td>
            <td><strong>${booking.athleteName}</strong></td>
            <td>${booking.discipline}</td>
            <td>${formatDate(booking.date)}, ${booking.time}</td>
            <td>${booking.duration}</td>
            <td>${statusBadge[booking.status]}</td>
            <td>${actions}</td>
        `;
        
        table.appendChild(row);
    });
}

// ==================== ADD AVAILABILITY ====================
function addAvailability() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Ajouter un créneau',
            html: `
                <div style="text-align: left;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Jour</label>
                        <select id="availDay" class="swal2-input" style="width: 100%; margin: 0;">
                            <option value="lundi">Lundi</option>
                            <option value="mardi">Mardi</option>
                            <option value="mercredi">Mercredi</option>
                            <option value="jeudi">Jeudi</option>
                            <option value="vendredi">Vendredi</option>
                            <option value="samedi">Samedi</option>
                            <option value="dimanche">Dimanche</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Heure de début</label>
                        <input type="time" id="availStart" class="swal2-input" style="width: 100%; margin: 0;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Heure de fin</label>
                        <input type="time" id="availEnd" class="swal2-input" style="width: 100%; margin: 0;">
                    </div>
                </div>
            `,
            confirmButtonText: 'Ajouter',
            confirmButtonColor: '#FEBA17',
            showCancelButton: true,
            cancelButtonText: 'Annuler',
            preConfirm: () => {
                const day = document.getElementById('availDay').value;
                const start = document.getElementById('availStart').value;
                const end = document.getElementById('availEnd').value;
                
                if (!start || !end) {
                    Swal.showValidationMessage('Veuillez remplir tous les champs');
                    return false;
                }
                
                if (start >= end) {
                    Swal.showValidationMessage('L\'heure de fin doit être après l\'heure de début');
                    return false;
                }
                
                return { day, start, end };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showSuccessAlert(
                    'Créneau ajouté',
                    `Disponibilité ajoutée: ${result.value.day} de ${result.value.start} à ${result.value.end}`
                );
            }
        });
    }
}

// ==================== PROFILE FORM HANDLING ====================
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profileForm');
    
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
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
    loadBookingsTable();
});