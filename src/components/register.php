<?php
include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/db.php');
?>

<section class="register">
    <div class="register-head">
        <h4>Sign up</h4>
        <p class="iks1"><i class="fa-solid fa-square-xmark fa-xl" style="color: #adb5bd;"></i></p>
    </div>
    <div class="register-form">
        <form id="register-form" method="post" action="/WEB2-Ebooking/src/ajax-register.php" novalidate>
            <div class="name-surname">
                <input class="login-change" type="text" id="register-name" placeholder="Enter your name"
                    name="register_name" required>
                <input class="login-change" type="text" id="register-surname" placeholder="Enter your surname"
                    name="register_surname" required>
            </div>
            <div>
                <input class="login-change" type="email" id="register-email" placeholder="Enter your email"
                    name="register_email" required>
            </div>
            <div>
                <input class="login-change" type="tel" id="register-phone" placeholder="Enter your phone number"
                    name="register_phoneNumber" required>
            </div>
            <div style="position: relative;">
                <input class="login-change" type="password" id="register-password" placeholder="Enter your password"
                    name="register_password" required>
                <i class="fa fa-eye-slash toggle-password2" aria-hidden="true" style="right: 17px;"></i>
            </div>
            <div style="position: relative;">
                <input class="login-change" type="password" id="confirm-password" placeholder="Confirm your password"
                    name="confirm_password" required>
                <i class="fa fa-eye-slash toggle-password3" aria-hidden="true" style="right: 17px;"></i>
            </div>
            <div style="position: relative;">
                <input type="submit" style="width: 100%; margin: auto;" value="Sign up" id="register-submit"><br>
                <span id="message"
                    style="position:absolute; font-size: 13px; top: -20px; width: 434px; transform: translateX(-50%); color: red; text-align:center;"></span>
            </div>
        </form>
    </div>
    <div class="register-end">
        <p>You have an account? <span class="signbutton">Sign in</span></p>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('register-form');
        const message = document.getElementById('message');
        const submitButton = document.getElementById('register-submit');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            message.textContent = '';
            submitButton.disabled = true;
            submitButton.value = 'Registering...';

            const formData = new FormData(form);

            fetch('/WEB2-Ebooking/src/ajax-register.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    message.style.color = data.success ? 'green' : 'red';
                    message.textContent = data.message;
                    if (data.success) {
                        form.reset();
                        setTimeout(() => window.location.href = '/WEB2-Ebooking/src/index.php', 20);
                    }
                })
                .catch(err => {
                    message.textContent = 'An error occurred. Please try again.';
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.value = 'Sign up';
                });
        });
    });
</script>