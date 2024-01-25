import * as utils from './functions';

document.getElementById('addForm').addEventListener('submit', function (event) {
    event.preventDefault();
    const data = {
        action: 'add',
        token: utils.getToken(),
        cover: this.querySelector('input[name="image"]').value,
        title: this.querySelector('input[name="title"]').value,
        author: this.querySelector('input[name="author"]').value,
        editor: this.querySelector('input[name="editor"]').value,
        isbn: this.querySelector('input[name="isbn"]').value,
        size: this.querySelector('input[name="size"]').value,
        summary: this.querySelector('textarea[name="summary"]').value
    };
    console.log(data);

    if (data.token.length < 1) {
        utils.displayError('error_token');
        return;
    }
    if (data.title.length < 1) {
        utils.displayError('Veuillez saisir le titre du livre.');
        return;
    }

    utils.fetchAPI('POST', data)
        .then(response => {
            console.log(response);
            if (!response.result) {
                utils.displayError(response.error);
                return;
            }
            utils.displayMsg(response.msg);
            // setTimeout(() => document.location.replace('books.php'), 1500);
            return;
        })
})