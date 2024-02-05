import * as utils from './functions';

const searchParams = new URLSearchParams(window.location.search);

document.getElementById(`${searchParams.get('status')}`).checked = true;

const imgContainer = document.getElementById('imgContainer');
const fileInput = document.getElementById('fileInput');

fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
        const fileReader = new FileReader();

        fileReader.onload = () => {
            imgContainer.style.backgroundImage = `url(${fileReader.result})`;
            imgContainer.style.backgroundSize = 'cover';
            imgContainer.style.backgroundPosition = 'center';
        }

        fileReader.readAsDataURL(fileInput.files[0]);

        if (document.getElementById('imgIcon') !== null) {
            document.getElementById('imgIcon').remove();
        }
    }
})

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
    if (formData.get('status') === null) {
        utils.displayError('Veuillez définir le statut du livre.');
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