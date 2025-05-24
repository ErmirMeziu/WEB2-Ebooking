<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/db.php');
?>

<section class="login-all">
    <div class="login">
        <div class="login-head">
            <h4>Sign in</h4>
            <p class="iks"><i class="fa-solid fa-square-xmark fa-xl" style="color: #adb5bd;"></i></p>
        </div>
        <div class="login-form">
            <div class="login-input">
                <form id="login-form" method="post" action='/WEB2-Ebooking/src/ajax-login.php' novalidate>
                    <div>
                        <input class="login-change" type="email" id="login-email" placeholder="Enter your email"
                            name="login_email" required>
                    </div>

                    <div style="position: relative;">
                        <input class="login-change" type="password" id="login-password"
                            placeholder="Enter your password" name="login_password" required>
                        <i class="fa fa-eye-slash toggle-password1" aria-hidden="true"></i>
                    </div>

                    <div style="position: relative; width: 100%; margin: auto; margin-bottom: -20px">
                        <button type="submit" id="login-submit">Log In</button>
                        <p id="message1" class="font" style="color:red; position: absolute; top: -23px; left: 50%; transform: translateX(-50%);
                                  font-size: 13px; width: 300px;"></p>
                    </div>
                </form>
            </div>
            <div class="divider">
                <p class="font change-responsive"
                    style="font-weight: 300; font-size: 14px; margin-top: -10px; margin-bottom: 10px;">
                    -------------
                    <span class="font">Sign In With More Methods</span>
                    -------------
                </p>
            </div>
            <div class="socials">
                <div class="social"><i class="fa-brands fa-facebook" style="color: #0033ff;"></i></div>
                <div class="social"><i class="fa-brands fa-whatsapp" style="color: #1bde32;"></i></div>
                <div class="social"><i class="fa-brands fa-linkedin icon" style="color: #0033ff;"></i></div>
                <div class="social"><i class="fa-brands fa-square-x-twitter icon" style="color: #002f80;"></i></div>
            </div>
        </div>
        <div class="login-end">
            <p>Don't have an account yet? <span class="sregister">Sign up</span></p>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loginForm = document.getElementById('login-form');
        const message1 = document.getElementById('message1');

        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(loginForm);

            fetch('/WEB2-Ebooking/src/ajax-login.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '/WEB2-Ebooking/src/index.php';
                    } else {
                        message1.textContent = data.message;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    message1.textContent = 'An error occurred. Please try again later.';
                });
        });
    });

</script>