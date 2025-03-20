document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (e) {
        const errors = {};
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("pwd").value.trim();

        if (!email) {
            errors.email = "Email is empty";
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errors.email = "Email is invalid";
        }
        if (!password) {
            errors.pwd = "Password is empty";
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
