function showLogin() {
    document.getElementById("adminLoginForm").style.display = "block";
    document.getElementById("userSignupForm").style.display = "none";
}

function showSignup() {
    document.getElementById("userSignupForm").style.display = "block";
    document.getElementById("adminLoginForm").style.display = "none";
}

function closeForm() {
    document.getElementById("adminLoginForm").style.display = "none";
    document.getElementById("userSignupForm").style.display = "none";
}
