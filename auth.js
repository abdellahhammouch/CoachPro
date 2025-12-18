// ==================== SIMPLE VALIDATION - EASY TO UNDERSTAND ====================

// Wait for page to load
document.addEventListener('DOMContentLoaded', function() {
    
    // Hide all error messages when page loads
    let allErrors = document.querySelectorAll('.error-message');
    for (let i = 0; i < allErrors.length; i++) {
        allErrors[i].style.display = 'none';
    }
    
    // ==================== LOGIN FORM ====================
    let loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Stop form from submitting immediately
            
            // Get the input values
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let userType = document.getElementById('userType').value;
            
            let formIsValid = true; // We assume form is valid
            
            // Check email
            if (email === '' || !email.includes('@')) {
                document.getElementById('emailError').style.display = 'block';
                document.getElementById('email').style.borderColor = 'red';
                formIsValid = false;
            } else {
                document.getElementById('emailError').style.display = 'none';
                document.getElementById('email').style.borderColor = '#e5e5e5';
            }
            
            // Check password
            if (password === '') {
                document.getElementById('passwordError').style.display = 'block';
                document.getElementById('password').style.borderColor = 'red';
                formIsValid = false;
            } else {
                document.getElementById('passwordError').style.display = 'none';
                document.getElementById('password').style.borderColor = '#e5e5e5';
            }
            
            // Check user type
            if (userType === '') {
                document.getElementById('userTypeError').style.display = 'block';
                document.getElementById('userType').style.borderColor = 'red';
                formIsValid = false;
            } else {
                document.getElementById('userTypeError').style.display = 'none';
                document.getElementById('userType').style.borderColor = '#e5e5e5';
            }
            
            // If everything is valid, submit the form
            if (formIsValid) {
                loginForm.submit();
            }
        });
    }
    
    // ==================== REGISTER FORM ====================
    let registerForm = document.getElementById('registerForm');
    let userTypeSelect = document.getElementById('userType');
    let coachFields = document.getElementById('coachFields');
    
    // Show coach fields when coach is selected
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
            e.preventDefault(); // Stop form from submitting immediately
            
            // Get all input values
            let userType = document.getElementById('userType').value;
            let firstName = document.getElementById('firstName').value;
            let lastName = document.getElementById('lastName').value;
            let email = document.getElementById('email').value;
            let phone = document.getElementById('phone').value;
            let password = document.getElementById('password').value;
            let confirmPassword = document.getElementById('confirmPassword').value;
            let terms = document.getElementById('terms').checked;
            
            let formIsValid = true;
            
            // Check user type
            if (userType === '') {
                document.getElementById('userTypeError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('userTypeError').style.display = 'none';
            }
            
            // Check first name
            if (firstName === '' || firstName.length < 2) {
                document.getElementById('firstNameError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('firstNameError').style.display = 'none';
            }
            
            // Check last name
            if (lastName === '' || lastName.length < 2) {
                document.getElementById('lastNameError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('lastNameError').style.display = 'none';
            }
            
            // Check email
            if (email === '' || !email.includes('@')) {
                document.getElementById('emailError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('emailError').style.display = 'none';
            }
            
            // Check phone
            if (phone === '' || phone.length < 10) {
                document.getElementById('phoneError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('phoneError').style.display = 'none';
            }
            
            // Check password
            if (password === '' || password.length < 6) {
                document.getElementById('passwordError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('passwordError').style.display = 'none';
            }
            
            // Check confirm password
            if (password !== confirmPassword) {
                document.getElementById('confirmPasswordError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('confirmPasswordError').style.display = 'none';
            }
            
            // Check terms
            if (!terms) {
                document.getElementById('termsError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('termsError').style.display = 'none';
            }
            
            // For coach, check disciplines
            if (userType === 'coach') {
                let disciplines = document.getElementById('hiddenInput').value;
                if (disciplines === '') {
                    alert('Veuillez sélectionner au moins une discipline');
                    formIsValid = false;
                }
            }
            
            // If everything is valid, submit the form
            if (formIsValid) {
                registerForm.submit(); // Now actually submit the form
            }
        });
    }
});

// ==================== PASSWORD VISIBILITY TOGGLE ====================
function togglePasswordVisibility(inputId) {
    let input = document.getElementById(inputId);
    if (input) {
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }
}