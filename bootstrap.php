<?php

// Load libraries
require __DIR__ . '/vendor/autoload.php';

// Start session
session_start();

// You MUST apply this function when you show raw text in HTML contexts.
// However, tweet texts are already escaped by Twitter, therefore the option
//   $double_encode = false
// is required for them.
function h($str, $double_encode = true)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8', $double_encode);
}

// Redirect unlogined user to login page
function require_logined_session()
{
    if (!isset($_SESSION['state']) || $_SESSION['state'] !== 'logined') {
        header('Location: login-twitter.php');
        exit;
    }
}

// Redirect logined user to index page
function require_unlogined_session()
{
    if (isset($_SESSION['state']) && $_SESSION['state'] === 'logined') {
        header('Location: index.php');
        exit;
    }
}
