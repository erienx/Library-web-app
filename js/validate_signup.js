document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (e) {
        const errors = {};
        const firstName = document.getElementById("first_name").value.trim();
        const lastName = document.getElementById("last_name").value.trim();
        const email = document.getElementById("email").value.trim();
        const phoneNumber = document.getElementById("phone_number").value.trim();
        const address = document.getElementById("address").value.trim();
        const password = document.getElementById("pwd").value;
        const confirmPassword = document.getElementById("pwd_confirm").value;

        if (!firstName) {
            errors.first_name = "First name is empty";
        } else if (!/^[\p{L}]+$/u.test(firstName)) {
            errors.first_name = "First name is invalid";
        }

        if (!lastName) {
            errors.last_name = "Last name is empty";
        } else if (!/^[\p{L}]+$/u.test(lastName)) {
            errors.last_name = "Last name is invalid";
        }

        if (!email) {
            errors.email = "Email is empty";
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errors.email = "Email is invalid";
        }

        if (!phoneNumber) {
            errors.phone_number = "Phone number is empty";
        } else if (!/^[0-9 ]+$/.test(phoneNumber)) {
            errors.phone_number = "Phone number is invalid";
        }

        if (!address) {
            errors.address = "Address is empty";
        }

        if (!password) {
            errors.pwd = "Password is empty";
        } else if (password.length < 6) {
            errors.pwd = "Password must be at least 6 characters long";
        }

        if (!confirmPassword) {
            errors.pwd_confirm = "Confirm password is empty";
        } else if (password !== confirmPassword) {
            errors.pwd_confirm = "Passwords do not match";
        }

        const errorElements = document.querySelectorAll(".error");
        errorElements.forEach(el => {
            el.classList.remove("show-error");
            el.textContent = "";
        });

        if (Object.keys(errors).length > 0) {
            e.preventDefault();
            for (const key in errors) {
                const errorElement = document.querySelector(`.error.${key}`);
                if (errorElement) {
                    errorElement.textContent = errors[key];
                    errorElement.classList.add("show-error");
                }
            }
        }
    });
});
