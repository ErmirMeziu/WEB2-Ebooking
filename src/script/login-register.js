/* login/register */
const sign = document.querySelector('.sign-in1');
const iks = document.querySelector('.iks');
const iks1 = document.querySelector('.iks1');
const loginall = document.querySelector('.login-all');
const login = document.querySelector('.login');
const sregister = document.querySelector('.sregister');
const register = document.querySelector('.register');
const signbutton = document.querySelector('.signbutton');
const body = document.querySelector('body');


sign.addEventListener('click', function () {
    login.classList.add('login-special');
    loginall.classList.add('login-special');
    body.classList.add('body-special');
});

iks.addEventListener('click', function () {
    login.classList.remove('login-special');
    loginall.classList.remove('login-special');
    body.classList.remove('body-special');
});


iks1.addEventListener('click', function () {
    register.classList.remove('register-special');
    loginall.classList.remove('login-special');
    body.classList.remove('body-special');
});

sregister.addEventListener('click', function () {
    login.classList.remove('login-special');
    register.classList.add('register-special');
});


signbutton.addEventListener('click', function () {
    login.classList.add('login-special');
    register.classList.remove('register-special');
});


loginall.addEventListener('click', function () {
    login.classList.remove('login-special');
    register.classList.remove('register-special');
    loginall.classList.remove('login-special');
    body.classList.remove('body-special');
});


login.addEventListener('click', function (event) {
    event.stopPropagation();
});

register.addEventListener('click', function (event) {
    event.stopPropagation();
});

/*login-form*/
var login_submit = document.getElementById("login-submit");

login_submit.addEventListener('click', function (event) {
    event.preventDefault();
    var login_email = document.getElementById("login-email").value;
    var login_password = document.getElementById("login-password").value;
    var mesazhi1 = document.getElementById('message1');
    var text1 = '';
    var valid = true;

    if (login_email.length === 0 || !login_email.includes('@') || login_password.length < 8) {
        valid = false;
    } else {
        var position1 = login_email.indexOf('@');
        var textAfter1 = login_email.substring(position1 + 1);
        var contains1 = textAfter1.split('.');

        if (contains1.length < 2 || login_email[position1 + 1] === '.' || textAfter1.endsWith('.') || position1 === 0) {
            valid = false;
        }
    }

    if (valid) {
        mesazhi1.style.color = 'green';
        mesazhi1.innerHTML = 'You have successfully logged in.';
        alert('You have successfully logged in.');
    } else {
        mesazhi1.style.color = 'red';
        mesazhi1.innerHTML = 'Wrong Email or Password';
    }

    return valid;
});


/*register-form*/
const submit = document.getElementById('register-submit')
submit.addEventListener('click', function validate(event) {
    event.preventDefault();

    var isValid = true;
    var isValid1 = true;
    var name = document.getElementById('register-name').value;
    var surname = document.getElementById('register-surname').value;
    var email = document.getElementById('register-email').value;
    var password = document.getElementById('register-password').value;
    var confirmPassword = document.getElementById('confirm-password').value;
    var mesazhi = document.getElementById('message');
    var text = '';

    if (name.length == 0 || surname.length == 0 || email.length == 0 || password.length == 0 || confirmPassword == 0) {
        isValid = false;
        isValid1 = false;
        text = 'One of the required fields isn\'t filled.';
    }
    if (email.length > 0 && !email.includes('@') && isValid1) {
        text = text.concat(' ', 'Email doesn\'t contain \'@\'.');
        isValid = false;
    }
    if (email.length > 0 && email.includes('@') && isValid1) {
        var position = email.indexOf('@');
        var textAfter = email.substring(position + 1);
        var contains = textAfter.split('.');
        if (position == 0) {
            isValid = false;
            text = text.concat(' ', '\' @ \' - is used at wrong position.');
        } else if (contains.length == 1) {
            isValid = false;
            text = text.concat(' ', 'Email doesnt contain \' . \'.');
        }
        else if (email[position + 1] == '.') {
            isValid = false;
            text = text.concat(' ', '\' . \' - is used at wrong position.');
        }
    }

    if (password.length < 8 && isValid1) {
        isValid = false;
        text = text.concat(' ', 'Password is too short.');
    }
    else if (!password.match(new RegExp(`^${confirmPassword}$`)) && isValid1) {
        isValid = false;
        text = text.concat(' ', 'Passwords don\'t match.');
    }

    if (isValid) {
        let newAccount = new Account(name, surname, email, password);
        newAccount.displayInfo();
        mesazhi.style.color = 'green';
        mesazhi.innerHTML = 'You have successfully signed up.';
        alert('You have successfully signed up.');
    } else {
        mesazhi.style.color = 'red';
        mesazhi.innerHTML = text.replace();
    }
    return isValid;
});


/* new account */
class Account {
    constructor(name, surname, email, password) {
        this.name = name;
        this.surname = surname;
        this.email = email;
        this.password = password;
    }

    //Method
    displayInfo() {
        console.log(`Name: ${this.name} ${this.surname}`);
        console.log(`Email: ${this.email}`);
        console.log(`Email Length: ${this.email.length.toExponential()}`)
    }
}

/*hidden/show password*/
$(document).ready(function () {
    $('.toggle-password1').on('click', function () {
        var inputField = $('#login-password');
        var fieldType = inputField.attr('type');

        if (fieldType === 'password') {
            inputField.attr('type', 'text');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            inputField.attr('type', 'password');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });

    $('.toggle-password2').on('click', function () {
        var inputField = $('#register-password');
        var fieldType = inputField.attr('type');

        if (fieldType === 'password') {
            inputField.attr('type', 'text');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            inputField.attr('type', 'password');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });

    $('.toggle-password3').on('click', function () {
        var inputField = $('#confirm-password');
        var fieldType = inputField.attr('type');

        if (fieldType === 'password') {
            inputField.attr('type', 'text');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            inputField.attr('type', 'password');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });
});

/*list show */
const list = document.querySelector(".list");
const sidebar = document.querySelector(".sidebar");
const sidebar_all = document.querySelector(".page-container");

list.addEventListener('click', function () {
    sidebar.classList.toggle("sidebar-special");
    sidebar_all.classList.toggle("page-container-special");
});

sidebar_all.addEventListener('click', function () {
    sidebar.classList.remove('sidebar-special');
    sidebar_all.classList.remove('page-container-special');
});


sidebar.addEventListener('click', function (event) {
    event.stopPropagation();
});





