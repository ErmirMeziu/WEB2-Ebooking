<section class="login-all">
    <div class="login">
        <div class="login-head">
            <h4>Sign in</h4>
            <p class="iks"><i class="fa-solid fa-square-xmark fa-xl" style="color: #adb5bd;"></i></p>
        </div>
        <div class="login-form">
            <div class="login-input">
                <form action="" method="post">
                    <div><input class="login-change" type="email" id="login-email" placeholder="Enter your email" name="login_email" required></div>
                    <div style="position: relative;">
                        <input class="login-change" type="password" id="login-password" placeholder="Enter your password" name="login_password" required>
                        <i class="fa fa-eye-slash toggle-password1" aria-hidden="true"></i>
                    </div>

                    <div style="position: relative; width: 100%; margin: auto; margin-bottom: -20px">
                        <button id="login-submit">Log In</button>
                        <p id="message1" class="font" style="position: absolute; top: -23px; left: 50%; transform: translateX(-50%); font-size: 13px;">
                        </p>
                    </div>

                    <div class="check">
                        <div class="remember">
                            <input type="checkbox" name="remember-me" id="remember-me">
                            <label for="remember-me" style="cursor: pointer;" class="font">Remember me</label>
                        </div>
                        <div><a href="" class="font">Forgot password?</a></div>
                    </div>
                </form>
            </div>
            <div class="divider">
                <p class="font change-responsive" style="font-weight: 300; font-size: 14px; margin-top: 10px; margin-bottom: 10px;">
                    -------------
                    <span class="font">Sign In With More Methods</span> -------------
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

<section class="register">
    <div class="register-head">
        <h4>Sign up</h4>
        <p class="iks1"><i class="fa-solid fa-square-xmark fa-xl" style="color: #adb5bd;"></i></p>
    </div>
    <div class="register-form">
        <form action="" method="post">
            <div class="name-surname">
                <input class="login-change" type="text" id="register-name" placeholder="Enter your name" name="register_name" required>
                <input class="login-change" type="text" id="register-surname" placeholder="Enter your surname" name="register_surname" required>
            </div>
            <div>
                <input class="login-change" type="email" id="register-email" placeholder="Enter your email" name="register_email" required>
            </div>
            <div>
                <input class="login-change" type="tel" id="register-phone" placeholder="Enter your phone number" name="register_phoneNumber" required>
            </div>
            <div style="position: relative;">
                <input class="login-change" type="password" id="register-password" placeholder="Enter your password" name="register_password" required>
                <i class="fa fa-eye-slash toggle-password2" aria-hidden="true" style="right: 17px;"></i>
            </div>
            <div style="position: relative;">
                <input class="login-change" type="password" id="confirm-password" placeholder="Confirm your password" required>
                <i class="fa fa-eye-slash toggle-password3" aria-hidden="true" style="right: 17px;"></i>
            </div>
            <div style="position: relative;">
                <input type="submit" style="width: 100%; margin: auto;" value="Sign up" id="register-submit"><br>
                <span id="message" style="position:absolute;font-size: 13px; top: -25px; width: 434px; transform: translateX(-50%);"></span>
            </div>
        </form>
    </div>
    <div class="register-end">
        <p>You have an account? <span class="signbutton">Sign in</span></p>
    </div>
</section>

<?php

function validateEmail($email)
{
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    return preg_match($pattern, $email);
}

function formatNumberWithHyphens($number)
{
    $pattern = '/(\d{3})(\d{3})(\d{3})/';
    $replacement = '$1-$2-$3';
    return preg_replace($pattern, $replacement, $number);
}

function validatePassword($password)
{
    return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/', $password);
}


class User
{
    public $email;
    public $password;
    public $name;
    public $surname;
    public $phoneNumber;
    public $dateCreated;

    function __construct($email, $password, $name, $surname, $phoneNumber, $dateCreated)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->phoneNumber = $phoneNumber;
        $this->dateCreated = $dateCreated;
    }

    function __destruct()
    {
        echo "destruktori u thirr";
    }
}


function &getUsersList()
{
    static $users = [];
    return $users;
}

function &getLoginLog()
{
    static $log = [];
    return $log;
}




if (isset($_POST['register_email']) && isset($_POST['register_password'])) {
    $registerEmail = $_POST['register_email'];
    $registerPassword = $_POST['register_password'];
    $registerName = $_POST['register_name'];
    $registerSurname = $_POST['register_surname'];
    $registerPhoneNumber = $_POST['register_phoneNumber'];

    if (validateEmail($registerEmail)) {
        if (validatePassword($registerPassword)) {
            $date = (new DateTime())->format('Y-m-d');
            $user = new User($registerEmail, $registerPassword, $registerName, $registerSurname, formatNumberWithHyphens($registerPhoneNumber), $date);
            getUsersList()[] = $user;
            //User created
        } else {
            //Password not in the correct format
        }
    } else {
        //Email not in the correct format
    }
}


if (isset($_POST['login_email']) && isset($_POST['login_password'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];
    $users = getUsersList();
    $found = false;

    foreach ($users as $user) {
        if ($user->email === $email && $user->password === $password) {
            getLoginLog()[] = ['email' => $email, 'time' => (new DateTime())->format('Y-m-d H:i:s')];
            //Login successful
            $found = true;
            break;
        }
    }

    if (!$found) {
        //Invalid login

    }
}
?>