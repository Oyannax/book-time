<?php
// SECURITY FUNCTIONS
/**
 * Generate a valid token in $_SESSION
 *
 * @return void
 */
function generateToken(): void
{
    if (
        !isset($_SESSION['token'])
        || time() > $_SESSION['tokenExpiry']
    ) {
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        $_SESSION['tokenExpiry'] = time() + 15 * 60;
    }
}

/**
 * Check for CSRF with referer and token
 * Redirect to the given page in case of error
 *
 * @param string $url - The page to redirect to
 * @return void
 */
function checkCSRF(string $url): void
{
    if (
        !isset($_SERVER['HTTP_REFERER'])
        || !str_contains($_SERVER['HTTP_REFERER'], 'http://localhost/book-time/')
    ) {
        $_SESSION['error'] = 'error_referer';
    } else if (
        !isset($_SESSION['token'])
        || !isset($_REQUEST['token'])
        || $_SESSION['token'] !== $_REQUEST['token']
        || time() > $_SESSION['tokenExpiry']
    ) {
        $_SESSION['error'] = 'error_token';
    }

    if (!isset($_SESSION['error'])) return;

    header('Location: ' . $url);
    exit;
}

/**
 * ASYNC
 * Check for CSRF with referer and token
 *
 * @param string $data
 * @return void
 */
function checkCSRFAsync(string $data): void
{
    if (
        !isset($_SERVER['HTTP_REFERER'])
        || !str_contains($_SERVER['HTTP_REFERER'], 'http://localhost/book-time/')
    ) {
        $error = 'error_referer';
    } else if (
        !isset($_SESSION['token'])
        || !isset($data['token'])
        || $_SESSION['token'] !== $data['token']
        || time() > $_SESSION['tokenExpiry']
    ) {
        $error = 'error_token';
    }

    if (!isset($error)) return;

    echo json_encode([
        'result' => false,
        'error' => $error
    ]);
    exit;
}

/**
 * Apply treatment on given array to prevent XSS
 *
 * @param array $array
 * @return void
 */
function checkXSS(array &$array): void
{
    $array = array_map('strip_tags', $array);
}

function checkPwdFormat(string $pwd)
{
    $uppercase = preg_match('@[A-Z]@', $pwd);
    $lowercase = preg_match('@[a-z]@', $pwd);
    $number = preg_match('@[0-9]@', $pwd);

    if (!$uppercase || !$lowercase || !$number || strlen($pwd) < 8) {
        return false;
    } else {
        return true;
    }
}


// NOTIFICATIONS
/**
 * Add an error to display and stop script
 * Redirect to the given page
 *
 * @param string $error
 * @param string $url - The page to redirect to
 * @return void
 */
function addErrorAndExit(string $error, string $url): void
{
    $_SESSION['error'] = $error;
    header('Location: ' . $url);
    exit;
}

/**
 * ASYNC
 * Add an error to display and stop script
 *
 * @param string $error
 * @return void
 */
function throwAsyncError(string $error): void
{
    echo json_encode([
        'result' => false,
        'error' => $error
    ]);
    exit;
}

/**
 * Add a message to display
 *
 * @param string $msg
 * @return void
 */
function addMsg(string $msg): void
{
    $_SESSION['msg'] = $msg;
}

/**
 * Display messages and errors
 *
 * @return string
 */
function displayNotif(): string
{
    $html = '<ul>';

    if (isset($_SESSION['msg'])) {
        $html .= '<li>' . $_SESSION['msg'] . '</li>';
        unset($_SESSION['msg']);
    }

    if (isset($_SESSION['error'])) {
        $html .= '<li>' . $_SESSION['error'] . '</li>';
        unset($_SESSION['error']);
    }

    $html .= '</ul>';
    return $html;
}
