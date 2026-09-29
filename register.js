const registerForm =
    document.getElementById("registerForm");

const status =
    document.getElementById("status");


registerForm.addEventListener("submit", function(event) {

    event.preventDefault();


    const fullname =
        document.getElementById("fullname").value.trim();

    const username =
        document.getElementById("username").value.trim();

    const birthdate =
        document.getElementById("birthdate").value;

    const password =
        document.getElementById("password").value;

    const confirmPassword =
        document.getElementById("confirmPassword").value;

    const terms =
        document.getElementById("terms").checked;


    /* Check Full Name */

    if (fullname === "") {

        status.textContent =
            "PLEASE ENTER YOUR FULL NAME";

        status.style.color = "#ff4d6d";

        return;
    }


    /* Check Username */

    if (username.length < 4) {

        status.textContent =
            "USERNAME MUST BE AT LEAST 4 CHARACTERS";

        status.style.color = "#ff4d6d";

        return;
    }


    /* Check Date of Birth */

    if (birthdate === "") {

        status.textContent =
            "PLEASE ENTER YOUR DATE OF BIRTH";

        status.style.color = "#ff4d6d";

        return;
    }


    /* Check Password */

    if (password.length < 8) {

        status.textContent =
            "PASSWORD MUST BE AT LEAST 8 CHARACTERS";

        status.style.color = "#ff4d6d";

        return;
    }


    /* Check Confirm Password */

    if (password !== confirmPassword) {

        status.textContent =
            "PASSWORDS DO NOT MATCH";

        status.style.color = "#ff4d6d";

        return;
    }


    /* Check Terms */

    if (!terms) {

        status.textContent =
            "PLEASE ACCEPT THE TERMS & CONDITIONS";

        status.style.color = "#ff4d6d";

        return;
    }


    /* Success */

    status.textContent =
        "ACCOUNT CREATED SUCCESSFULLY!";

    status.style.color = "#00f7ff";


    console.log("===== NEW ACCOUNT =====");

    console.log("Full Name:", fullname);

    console.log("Username:", username);

    console.log("Date of Birth:", birthdate);

    console.log("======================");


    /* Clear form */

    registerForm.reset();

});