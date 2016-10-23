<?php

// Booting
require __DIR__ . '/bootstrap.php';
require __DIR__ . '/api-keys.php';

// Redirect logined user to index page
require_unlogined_session();

// Make an alias "Client" instead of "mpyw\Cowitter\Client"
use mpyw\Cowitter\Client;

try {
    if (!isset($_SESSION['state'])) {
        /* User is completely unlogined */

        // Create a client object
        $_SESSION['client'] = new Client([$Twitter['ck'], $Twitter['cs']]);

        // Update it with request_token
        $_SESSION['client'] = $_SESSION['client']->oauthForRequestToken((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);

        // Change state
        $_SESSION['state'] = 'pending';

        // Redirect to Twitter
        header("Location: {$_SESSION['client']->getAuthorizeUrl()}");
        exit;
    } else {
        /* User is unlogined, but pending access_token */

        // Update it with access_token (Using $_GET['oauth_verifier'] returned from Twitter)
        $_SESSION['client'] = $_SESSION['client']->oauthForAccessToken(filter_input(INPUT_GET, 'oauth_verifier'));

        // Change state
        $_SESSION['state'] = 'logined';

        // Redirect to index page
        header('Location: login.php');
        exit;
    }

} catch (RuntimeException $e) {
    require __DIR__ . '/reset.php';
}
