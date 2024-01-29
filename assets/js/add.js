import * as utils from './functions';

document.getElementById('addForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    const headers = new Headers();

    console.log(formData);

    if (utils.getToken().length < 1) {
        utils.displayError('error_token');
        return;
    }
    if (formData.get('title').length < 1) {
        utils.displayError('Veuillez saisir le titre du livre.');
        return;
    }

    fetch('api.php', {
        method: 'POST',
        body: formData,
        headers: headers
    })
        .then(response => response.json())
        .then(response => {
            console.log(response);

            if (!response.result) {
                utils.displayError(response.error);
                return;
            }

            utils.displayMsg(response.msg);
            return;
        })
})