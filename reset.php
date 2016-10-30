<?php
$_SESSION = array();
session_destroy();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 1800, '/');
}

header('Location: index.php');
exit;
?>