import * as utils from './functions';

document.getElementById('registerForm').addEventListener('submit', function (event) {
    event.preventDefault();
    const data = {
        action: 'register',
        token: utils.getToken(),
        username: this.querySelector('input[name="username"]').value,
        email: this.querySelector('input[name="email"]').value,
        password: this.querySelector('input[name="password"]').value,
        passwordCheck: this.querySelector('input[name="password-check"]').value
    };

    if (data.token.length < 1) {
        utils.displayError('error_token');
        return;
    }
    if (data.username.length < 1) {
        utils.displayError('Veuillez saisir un nom d\'utilisateur.');
        return;
    }
    if (data.email.length < 1) {
        utils.displayError('Veuillez saisir une adresse mail.');
        return;
    }
    if (data.password.length < 1) {
        utils.displayError('Veuillez saisir un mot de passe.');
        return;
    }
    if (data.passwordCheck.length < 1 || data.password !== data.passwordCheck) {
        utils.displayError('Veuillez confirmer le mot de passe.');
        return;
    }

    utils.fetchAPI('POST', data)
        .then(response => {
            if (!response.result) {
                utils.displayError(response.error);
                return;
            }
            utils.displayMsg(response.msg);
            setTimeout(() => document.location.replace('books.php'), 1500);
            return;
        })
})