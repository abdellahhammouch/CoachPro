// ==================== LOGIN FORM HANDLING ====================
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const userType = document.getElementById('userType').value;
            
            let isValid = true;
            
            // Validate email
            if (!ValidationPatterns.email.test(email)) {
                showError('email', 'emailError', true);
                isValid = false;
            } else {
                showError('email', 'emailError', false);
            }
            
            // Validate password
            if (password.length === 0) {
                showError('password', 'passwordError', true);
                isValid = false;
            } else {
                showError('password', 'passwordError', false);
            }
            
            // Validate user type
            if (!userType) {
                showError('userType', 'userTypeError', true);
                isValid = false;
            } else {
                showError('userType', 'userTypeError', false);
            }
            
            if (isValid) {
                handleLogin(email, password, userType);
            }
        });
        
        // Real-time validation
        document.getElementById('email').addEventListener('blur', function() {
            validateField('email', ValidationPatterns.email, 'emailError');
        });
    }
});

function handleLogin(email, password, userType) {
    showLoading();
    
    // Simulate API call
    setTimeout(() => {
        hideLoading();
        
        // In real implementation, this would be an API call
        // For demo purposes, we'll simulate a successful login
        
        showSuccessAlert(
            'Connexion réussie !',
            'Redirection vers votre espace...'
        );
        
        setTimeout(() => {
            if (userType === 'coach') {
                window.location.href = 'dashboard-coach.html';
            } else {
                window.location.href = 'athlete-space.html';
            }
        }, 1500);
    }, 1500);
}

// ==================== REGISTER FORM HANDLING ====================
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const userTypeSelect = document.getElementById('userType');
    const coachFields = document.getElementById('coachFields');
    
    // Show/hide coach specific fields
    if (userTypeSelect && coachFields) {
        userTypeSelect.addEventListener('change', function() {
            if (this.value === 'coach') {
                coachFields.style.display = 'block';
            } else {
                coachFields.style.display = 'none';
            }
        });
    }
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                userType: document.getElementById('userType').value,
                firstName: document.getElementById('firstName').value.trim(),
                lastName: document.getElementById('lastName').value.trim(),
                email: document.getElementById('email').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                password: document.getElementById('password').value,
                confirmPassword: document.getElementById('confirmPassword').value,
                terms: document.getElementById('terms').checked
            };
            
            // Coach specific fields
            if (formData.userType === 'coach') {
                formData.specialties = document.getElementById('specialties').value.trim();
                formData.experience = document.getElementById('experience').value;
            }
            
            let isValid = true;
            
            // Validate user type
            if (!formData.userType) {
                showError('userType', 'userTypeError', true);
                isValid = false;
            } else {
                showError('userType', 'userTypeError', false);
            }
            
            // Validate first name
            if (!ValidationPatterns.name.test(formData.firstName)) {
                showError('firstName', 'firstNameError', true);
                isValid = false;
            } else {
                showError('firstName', 'firstNameError', false);
            }
            
            // Validate last name
            if (!ValidationPatterns.name.test(formData.lastName)) {
                showError('lastName', 'lastNameError', true);
                isValid = false;
            } else {
                showError('lastName', 'lastNameError', false);
            }
            
            // Validate email
            if (!ValidationPatterns.email.test(formData.email)) {
                showError('email', 'emailError', true);
                isValid = false;
            } else {
                showError('email', 'emailError', false);
            }
            
            // Validate phone
            if (!ValidationPatterns.phone.test(formData.phone)) {
                showError('phone', 'phoneError', true);
                isValid = false;
            } else {
                showError('phone', 'phoneError', false);
            }
            
            // Validate password
            if (!ValidationPatterns.password.test(formData.password)) {
                showError('password', 'passwordError', true);
                isValid = false;
            } else {
                showError('password', 'passwordError', false);
            }
            
            // Validate password confirmation
            if (formData.password !== formData.confirmPassword) {
                showError('confirmPassword', 'confirmPasswordError', true);
                isValid = false;
            } else {
                showError('confirmPassword', 'confirmPasswordError', false);
            }
            
            // Validate terms
            if (!formData.terms) {
                showError('terms', 'termsError', true);
                isValid = false;
            } else {
                showError('terms', 'termsError', false);
            }
            
            if (isValid) {
                handleRegister(formData);
            }
        });
        
        // Real-time validation
        const fields = [
            { id: 'firstName', pattern: ValidationPatterns.name, error: 'firstNameError' },
            { id: 'lastName', pattern: ValidationPatterns.name, error: 'lastNameError' },
            { id: 'email', pattern: ValidationPatterns.email, error: 'emailError' },
            { id: 'phone', pattern: ValidationPatterns.phone, error: 'phoneError' },
            { id: 'password', pattern: ValidationPatterns.password, error: 'passwordError' }
        ];
        
        fields.forEach(field => {
            const element = document.getElementById(field.id);
            if (element) {
                element.addEventListener('blur', function() {
                    validateField(field.id, field.pattern, field.error);
                });
            }
        });
        
        // Confirm password validation
        const confirmPassword = document.getElementById('confirmPassword');
        if (confirmPassword) {
            confirmPassword.addEventListener('blur', function() {
                const password = document.getElementById('password').value;
                if (this.value !== password) {
                    showError('confirmPassword', 'confirmPasswordError', true);
                } else {
                    showError('confirmPassword', 'confirmPasswordError', false);
                }
            });
        }
    }
});

function handleRegister(formData) {
    showLoading();
    
    // Simulate API call
    setTimeout(() => {
        hideLoading();
        
        // In real implementation, this would be an API call
        // For demo purposes, we'll simulate a successful registration
        
        showSuccessAlert(
            'Inscription réussie !',
            'Votre compte a été créé avec succès. Vous allez être redirigé vers la page de connexion.'
        );
        
        setTimeout(() => {
            window.location.href = 'login.html';
        }, 2000);
    }, 1500);
}

// ==================== PASSWORD VISIBILITY TOGGLE ====================
function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }
}

// ==================== LOGOUT FUNCTION ====================
function logout() {
    showConfirmAlert(
        'Déconnexion',
        'Êtes-vous sûr de vouloir vous déconnecter ?',
        function() {
            showLoading();
            setTimeout(() => {
                hideLoading();
                window.location.href = 'index.html';
            }, 1000);
        }
    );
}