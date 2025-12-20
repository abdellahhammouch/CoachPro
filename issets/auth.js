// ==================== SIMPLE VALIDATION - ALL IN ONE FILE ====================

// Wait for page to load
document.addEventListener('DOMContentLoaded', function() {
    
    // Hide all error messages when page loads
    var allErrors = document.querySelectorAll('.error-message');
    for (var i = 0; i < allErrors.length; i++) {
        allErrors[i].style.display = 'none';
    }
    
    // ==================== LOGIN FORM ====================
    var loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Stop form from submitting immediately
            
            // Get the input values
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var userType = document.getElementById('userType').value;
            
            var formIsValid = true; // We assume form is valid
            
            // Check email using regex
            // Regex: something@something.something
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            if (email === '' || !emailRegex.test(email)) {
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
    var registerForm = document.getElementById('registerForm');
    var userTypeSelect = document.getElementById('userType');
    var coachFields = document.getElementById('coachFields');
    
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
            var userType = document.getElementById('userType').value;
            var firstName = document.getElementById('firstName').value;
            var lastName = document.getElementById('lastName').value;
            var email = document.getElementById('email').value;
            var phone = document.getElementById('phone').value;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            var terms = document.getElementById('terms').checked;
            
            var formIsValid = true;
            
            // Check user type
            if (userType === '') {
                document.getElementById('userTypeError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('userTypeError').style.display = 'none';
            }
            
            // Check first name using regex
            // Regex: at least 2 letters, only letters and spaces
            var nameRegex = /^[a-zA-ZÀ-ÿ\s]{2,}$/;
            
            if (firstName === '' || !nameRegex.test(firstName)) {
                document.getElementById('firstNameError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('firstNameError').style.display = 'none';
            }
            
            // Check last name
            if (lastName === '' || !nameRegex.test(lastName)) {
                document.getElementById('lastNameError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('lastNameError').style.display = 'none';
            }
            
            // Check email using regex
            // Regex: name@domain.com format
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            if (email === '' || !emailRegex.test(email)) {
                document.getElementById('emailError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('emailError').style.display = 'none';
            }
            
            // Check phone number using regex
            // Regex: 0612345678 or +212612345678
            var phoneRegex = /^(\+212|0)[5-7][0-9]{8}$/;
            
            // Remove spaces and dashes from phone before checking
            var cleanPhone = phone.replace(/\s/g, '').replace(/-/g, '');
            
            if (phone === '' || !phoneRegex.test(cleanPhone)) {
                document.getElementById('phoneError').style.display = 'block';
                formIsValid = false;
            } else {
                document.getElementById('phoneError').style.display = 'none';
            }
            
            // Check password (at least 6 characters)
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
            
            // For coach, check disciplines - NO ALERT, use error div
            if (userType === 'coach') {
                var hiddenInput = document.getElementById('hiddenInput');
                var disciplineError = document.getElementById('disciplineError');
                
                if (hiddenInput && hiddenInput.value === '') {
                    // Show error message below disciplines
                    if (disciplineError) {
                        disciplineError.style.display = 'block';
                    }
                    formIsValid = false;
                } else {
                    // Hide error message
                    if (disciplineError) {
                        disciplineError.style.display = 'none';
                    }
                }
            }
            
            // If everything is valid, submit the form
            if (formIsValid) {
                registerForm.submit();
            }
        });
    }
});

// ==================== PASSWORD VISIBILITY TOGGLE ====================
function togglePasswordVisibility(inputId) {
    var input = document.getElementById(inputId);
    if (input) {
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }
}