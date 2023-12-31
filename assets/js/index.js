import * as utils from './functions';

const notifContainer = document.getElementById('notifContainer');
if (notifContainer.children.length > 0) setTimeout(() => notifContainer.innerHTML = '', 2000);

document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();
    const data = {
        action: 'login',
        token: utils.getToken(),
        email: this.querySelector('input[name="email"]').value,
        password: this.querySelector('input[name="password"]').value
    };

    if (data.token.length < 1) {
        utils.displayError('error_token');
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