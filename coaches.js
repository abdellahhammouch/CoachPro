// ==================== COACHES DATA ====================
const coachesData = [
    {
        id: 1,
        name: 'Ahmed Benali',
        specialty: 'Football',
        sport: 'football',
        rating: 4.9,
        experience: '10 ans',
        students: '150+',
        certification: 'Certifié CAF',
        tags: ['Technique', 'Tactique', 'Jeunes'],
        bio: 'Coach de football professionnel avec 10 ans d\'expérience. Spécialisé dans le développement technique et tactique des jeunes joueurs.',
        availability: ['Lun-Ven: 14h-20h', 'Sam: 9h-18h'],
        price: '200 DH/heure'
    },
    {
        id: 2,
        name: 'Fatima Zahra',
        specialty: 'Tennis',
        sport: 'tennis',
        rating: 5.0,
        experience: '8 ans',
        students: '80+',
        certification: 'Certifiée ITF',
        tags: ['Service', 'Revers', 'Compétition'],
        bio: 'Coach de tennis certifiée ITF. Spécialiste en préparation aux compétitions et perfectionnement technique.',
        availability: ['Mar-Sam: 8h-16h'],
        price: '250 DH/heure'
    },
    {
        id: 3,
        name: 'Karim El Mansouri',
        specialty: 'Natation',
        sport: 'natation',
        rating: 4.8,
        experience: '12 ans',
        students: '200+',
        certification: 'Certifié FRMN',
        tags: ['Crawl', 'Brasse', 'Papillon'],
        bio: 'Maître-nageur certifié avec une expertise dans l\'enseignement de toutes les nages. Formation de nageurs de tous niveaux.',
        availability: ['Lun-Sam: 7h-19h'],
        price: '180 DH/heure'
    },
    {
        id: 4,
        name: 'Youssef Alami',
        specialty: 'Boxe & Sports de Combat',
        sport: 'boxe',
        rating: 4.9,
        experience: '15 ans',
        students: '120+',
        certification: 'Ex-Champion',
        tags: ['Boxe anglaise', 'Kick-boxing', 'Cardio'],
        bio: 'Ex-champion de boxe professionnelle. Spécialisé dans l\'entraînement boxe et préparation physique intensive.',
        availability: ['Lun-Ven: 16h-21h'],
        price: '220 DH/heure'
    },
    {
        id: 5,
        name: 'Sara Benjelloun',
        specialty: 'Préparation Physique',
        sport: 'fitness',
        rating: 5.0,
        experience: '7 ans',
        students: '90+',
        certification: 'Certifiée NSCA',
        tags: ['Musculation', 'Perte de poids', 'Nutrition'],
        bio: 'Coach en préparation physique certifiée. Programmes personnalisés de remise en forme, musculation et conseils nutritionnels.',
        availability: ['Lun-Ven: 6h-20h', 'Sam: 8h-14h'],
        price: '200 DH/heure'
    },
    {
        id: 6,
        name: 'Omar Idrissi',
        specialty: 'Football',
        sport: 'football',
        rating: 4.7,
        experience: '6 ans',
        students: '70+',
        certification: 'Licence B',
        tags: ['Gardien', 'Défense', 'Adultes'],
        bio: 'Coach spécialisé dans l\'entraînement des gardiens de but et la défense. Formation pour adultes et amateurs.',
        availability: ['Mar-Jeu: 15h-19h', 'Sam: 10h-16h'],
        price: '180 DH/heure'
    }
];

// ==================== FILTER COACHES ====================
function filterCoaches() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const sportFilter = document.getElementById('sportFilter').value.toLowerCase();
    const coachCards = document.querySelectorAll('.coach-card');
    
    let visibleCount = 0;
    
    coachCards.forEach(card => {
        const coachName = card.querySelector('.coach-name').textContent.toLowerCase();
        const coachSport = card.getAttribute('data-sport').toLowerCase();
        const coachSpecialty = card.querySelector('.coach-specialty').textContent.toLowerCase();
        
        const matchesSearch = coachName.includes(searchInput) || 
                             coachSpecialty.includes(searchInput);
        const matchesSport = !sportFilter || coachSport === sportFilter;
        
        if (matchesSearch && matchesSport) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Show message if no results
    let noResultsMsg = document.getElementById('noResultsMessage');
    if (visibleCount === 0) {
        if (!noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.id = 'noResultsMessage';
            noResultsMsg.style.cssText = 'text-align: center; padding: 60px 20px; grid-column: 1/-1;';
            noResultsMsg.innerHTML = `
                <i class="fas fa-search" style="font-size: 64px; color: var(--primary-gold); margin-bottom: 20px; display: block;"></i>
                <h3 style="color: var(--primary-dark); margin-bottom: 10px;">Aucun coach trouvé</h3>
                <p style="color: var(--text-gray);">Essayez de modifier vos critères de recherche</p>
            `;
            document.getElementById('coachesGrid').appendChild(noResultsMsg);
        }
    } else {
        if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }
}

// ==================== VIEW COACH PROFILE ====================
function viewCoachProfile(coachId) {
    const coach = coachesData.find(c => c.id === coachId);
    
    if (!coach) return;
    
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
        <div style="text-align: center; margin-bottom: 25px;">
            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(coach.name)}&background=FEBA17&color=fff&size=120" 
                 alt="${coach.name}" 
                 style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 15px;">
            <h2 style="color: var(--primary-dark); margin-bottom: 5px;">${coach.name}</h2>
            <p style="color: var(--primary-gold); font-weight: 600; font-size: 18px;">${coach.specialty}</p>
            <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 10px;">
                <span style="color: var(--primary-gold); font-size: 20px;">
                    <i class="fas fa-star"></i> ${coach.rating}
                </span>
                <span style="color: var(--text-gray);">•</span>
                <span style="color: var(--text-gray);">${coach.students} élèves</span>
            </div>
        </div>
        
        <div style="background-color: var(--primary-light); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
            <h3 style="color: var(--primary-dark); margin-bottom: 15px;">
                <i class="fas fa-user"></i> À propos
            </h3>
            <p style="color: var(--text-gray); line-height: 1.8;">${coach.bio}</p>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
            <div style="background-color: var(--primary-light); padding: 15px; border-radius: 10px;">
                <i class="fas fa-medal" style="color: var(--primary-gold); font-size: 20px; margin-bottom: 8px; display: block;"></i>
                <strong style="color: var(--primary-dark);">Expérience</strong>
                <p style="color: var(--text-gray); margin-top: 5px;">${coach.experience}</p>
            </div>
            <div style="background-color: var(--primary-light); padding: 15px; border-radius: 10px;">
                <i class="fas fa-certificate" style="color: var(--primary-gold); font-size: 20px; margin-bottom: 8px; display: block;"></i>
                <strong style="color: var(--primary-dark);">Certification</strong>
                <p style="color: var(--text-gray); margin-top: 5px;">${coach.certification}</p>
            </div>
        </div>
        
        <div style="background-color: var(--primary-light); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
            <h3 style="color: var(--primary-dark); margin-bottom: 15px;">
                <i class="fas fa-tags"></i> Spécialités
            </h3>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                ${coach.tags.map(tag => `
                    <span style="background-color: white; color: var(--primary-brown); padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 500;">
                        ${tag}
                    </span>
                `).join('')}
            </div>
        </div>
        
        <div style="background-color: var(--primary-light); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
            <h3 style="color: var(--primary-dark); margin-bottom: 15px;">
                <i class="fas fa-clock"></i> Disponibilités
            </h3>
            ${coach.availability.map(slot => `
                <p style="color: var(--text-gray); margin-bottom: 8px;">
                    <i class="fas fa-check-circle" style="color: var(--success);"></i> ${slot}
                </p>
            `).join('')}
        </div>
        
        <div style="background-color: var(--primary-light); padding: 20px; border-radius: 10px; margin-bottom: 25px; text-align: center;">
            <h3 style="color: var(--primary-dark); margin-bottom: 10px;">
                <i class="fas fa-tag"></i> Tarif
            </h3>
            <p style="color: var(--primary-gold); font-size: 24px; font-weight: bold;">${coach.price}</p>
        </div>
        
        <button onclick="bookSession(${coach.id})" class="btn-submit" style="width: 100%;">
            <i class="fas fa-calendar-plus"></i> Réserver une séance
        </button>
    `;
    
    openModal('coachModal');
}

// ==================== BOOK SESSION ====================
function bookSession(coachId) {
    const coach = coachesData.find(c => c.id === coachId);
    
    if (!coach) return;
    
    // Check if user is logged in (in real app)
    // For demo, we'll show a login prompt
    showConfirmAlert(
        'Réserver une séance',
        'Connectez-vous pour réserver une séance avec ' + coach.name,
        function() {
            window.location.href = 'login.html';
        }
    );
}

// ==================== INITIALIZE FILTERS ====================
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const sportFilter = document.getElementById('sportFilter');
    
    if (searchInput) {
        searchInput.addEventListener('input', filterCoaches);
    }
    
    if (sportFilter) {
        sportFilter.addEventListener('change', filterCoaches);
    }
});