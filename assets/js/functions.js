// SECURITY
/**
 * Get the current token available in the page
 * 
 * @returns {string} Current token
 */
export function getToken() {
    return document.getElementById('token').value;
}


// NOTIFICATIONS
/**
 * Display an error on the page
 * Will disappear after 2 seconds
 * 
 * @param {string} error 
 */
export function displayError(error) {
    const notif = document.createElement('li');
    notif.classList.add('notif', 'error', 'flex', 'ai-center');
    notif.textContent = error;

    const icon = document.createElement('i');
    icon.classList.add('icon', 'jc-center', 'ai-center', 'fa-solid', 'fa-exclamation')

    notif.prepend(icon);
    document.getElementById('notifContainer').appendChild(notif);
    setTimeout(() => notif.remove(), 2000);
}

/**
 * Display a message on the page
 * Will disappear after 2 seconds
 * 
 * @param {string} msg 
 */
export function displayMsg(msg) {
    const notif = document.createElement('li');
    notif.classList.add('notif', 'msg', 'flex', 'ai-center');
    notif.textContent = msg;
    
    const icon = document.createElement('i');
    icon.classList.add('icon', 'jc-center', 'ai-center', 'fa-solid', 'fa-check')

    notif.prepend(icon);
    document.getElementById('notifContainer').appendChild(notif);
    setTimeout(() => notif.remove(), 2000);
}


// API
/**
 * Call the api.php script asynchronously with the HTTP method given
 * Data object will be sent into the request body
 * 
 * @param {string} method 
 * @param {array} data 
 * @returns 
 */
export async function fetchAPI(method, data) {
    try {
        const response = await fetch('api.php', {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        return response.json();
    } catch (error) {
        console.error('Unable to load API.')
    }
}