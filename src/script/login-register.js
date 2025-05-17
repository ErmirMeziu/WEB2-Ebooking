/* login/register */
const btnOpenLogin = document.querySelector('.sign-in1');
const btnCloseLogin = document.querySelector('.iks');
const btnCloseRegister = document.querySelector('.iks1');
const containerOverlay = document.querySelector('.login-all');
const loginModal = document.querySelector('.login');
const btnToRegister = document.querySelector('.sregister');
const registerModal = document.querySelector('.register');
const btnToLogin = document.querySelector('.signbutton');
const body = document.querySelector('body');

function openLogin() {
    loginModal.classList.add('login-special');
    containerOverlay.classList.add('login-special');
    body.classList.add('body-special');
}

function closeAll() {
    loginModal.classList.remove('login-special');
    registerModal.classList.remove('register-special');
    containerOverlay.classList.remove('login-special');
    body.classList.remove('body-special');
}

function openRegister() {
    registerModal.classList.add('register-special');
    loginModal.classList.remove('login-special');
}

function switchToLogin() {
    loginModal.classList.add('login-special');
    registerModal.classList.remove('register-special');
}

btnOpenLogin.addEventListener('click', openLogin);
btnCloseLogin.addEventListener('click', closeAll);
btnCloseRegister.addEventListener('click', closeAll);
containerOverlay.addEventListener('click', closeAll);

btnToRegister.addEventListener('click', openRegister);
btnToLogin.addEventListener('click', switchToLogin);

loginModal.addEventListener('click', event => event.stopPropagation());
registerModal.addEventListener('click', event => event.stopPropagation());


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





