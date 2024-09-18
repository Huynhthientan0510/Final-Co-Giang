document.querySelector("form").addEventListener("submit", function (event) {
    const email = document.querySelector('input[name="email"]').value;
    const password = document.querySelector('input[name="password"]').value;
    const errorMessage = document.getElementById("error-message");

    if (!email || !password) {
        errorMessage.textContent = "Please fill in all fields.";
        event.preventDefault();
    }
});
